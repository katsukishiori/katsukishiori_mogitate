<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::Paginate(6);

        return view('product_list', ['products' => $products]);
    }

    public function show()
    {
        return view('product_register');
    }

    // 商品詳細表示
    public function detail($id)
    {
        $product = Product::findOrFail($id);

        // product_idに関連するすべてのseason_idを取得
        $product_season = ProductSeason::where('product_id', $product->id)->pluck('season_id')->toArray();

        // season_idからseasonの名前を取得
        $season_names = Season::whereIn('id', $product_season)->pluck('name')->toArray();

        return view('product_detail', ['product' => $product, 'season_names' => $season_names]);
    }

    // 検索
    public function search(Request $request)
    {
        // クエリビルダーを初期化
        $query = Product::query();
        $search = $request->input('query', null);

        if (!is_null($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // 並び順の取得
        $sortBy = $request->input('sort_by');

        // 並び順に基づく条件の追加
        if ($sortBy == 'high_to_low') {
            $query->orderBy('price', 'desc');
        } elseif ($sortBy == 'low_to_high') {
            $query->orderBy('price', 'asc');
        }

        $products = $query->paginate(6)->appends(request()->query());

        return view('product_list', compact('products', 'search', 'sortBy'));
    }

    // 商品登録
    public function register(ProductRequest $request)
    {
        $validated = $request->validated();

        // 画像のアップロード処理
        if ($request->hasFile('document')) {
            $imageName = time() . '.' . $request->document->extension();
            $request->document->storeAs('public/images', $imageName);
        } else {
            return redirect()->back()->withErrors(['document' => '商品画像を登録してください']);
        }

        $product = new Product();
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->image = $imageName;
        $product->description = $validated['description'];
        $product->save();

        if (isset($validated['season'])) {
            foreach ($validated['season'] as $seasonName) {
                // シーズン名からシーズンIDを取得
                $season = Season::where('name', $seasonName)->first();
                if ($season) {
                    $productSeason = new ProductSeason();
                    $productSeason->product_id = $product->id;
                    $productSeason->season_id = $season->id;
                    $productSeason->save();
                } else {
                    // シーズンが見つからない場合のエラーハンドリング
                    return redirect()->back()->withErrors(['season' => 'シーズンが見つかりませんでした: ' . $seasonName]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', '商品が登録されました。');
    }

    // 商品更新
    public function update(ProductRequest $request, $id)
    {
        $validated = $request->validated();

        // フォームから送信されたデータを取得
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        // 画像のアップロード処理
        if ($request->hasFile('document')) {
            // 古い画像が存在する場合、それを削除する
            if ($product->image) {
                Storage::delete('public/images/' . $product->image);
            }

            // 新しい画像をサーバーに保存
            $imageName = time() . '.' . $request->document->extension();
            $request->document->storeAs('public/images', $imageName);

            // 新しい画像のファイル名をデータベースに保存
            $product->image = $imageName;
        }

        // 季節の更新
        $selectedSeasons = $request->input('season', []); // 'season' を使用

        $seasonIds = Season::whereIn('name', $selectedSeasons)->pluck('id')->toArray();

        // 古い季節を削除し、新しい季節を追加
        $product->seasons()->sync($seasonIds);



        // データベースに変更を保存
        $product->save();



        // 更新完了メッセージをフラッシュ
        session()->flash('message', '商品情報が更新されました');


        // 更新後にリダイレクト
        return redirect()->route('products.index');
    }
}
