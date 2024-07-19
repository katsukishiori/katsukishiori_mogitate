<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

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

    // 商品検索
    public function search(Request $request)
    {
        $query = $request->input('input');
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        return view('product_list', ['products' => $products]);
    }

    // 商品登録
    public function register(ProductRequest $request)
    {
        $validated = $request->validated();

        $path = $request->file('document')->store('public/images');
        $filename = basename($path);

        $product = new Product();
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->image = $filename;
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

        // 成功時のリダイレクトなどの処理
        return redirect()->route('products.register')->with('success', '商品が登録されました。');
    }

    // 商品更新
    public function update(Request $request, $id)
    {
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
        $selectedSeasons = $request->input('seasons', []);
        $seasonIds = Season::whereIn('name', $selectedSeasons)->pluck('id')->toArray();
        $product->seasons()->sync($seasonIds);

        // データベースに変更を保存
        $product->save();


        // 更新完了メッセージをフラッシュ
        session()->flash('message', '商品情報が更新されました');

        // 更新後にリダイレクト
        return redirect()->route('products.index', ['id' => $product->id]);
    }
}
