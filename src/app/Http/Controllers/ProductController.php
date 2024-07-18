<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;
use App\Http\Requests\ProductRequest;

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

    public function detail($id)
    {
        $product = Product::findOrFail($id);

        // product_idに関連するすべてのseason_idを取得
        $product_season = ProductSeason::where('product_id', $product->id)->pluck('season_id')->toArray();

        // season_idからseasonの名前を取得
        $season_names = Season::whereIn('id', $product_season)->pluck('name')->toArray();

        return view('product_detail', ['product' => $product, 'season_names' => $season_names]);
    }

    public function search(Request $request)
    {
        $query = $request->input('input');
        $products = Product::where('name', 'LIKE', "%{$query}%")->get();

        return view('product_list', ['products' => $products]);
    }

    public function register(ProductRequest $request)
    {
        $validated = $request->validated();

        // ファイルのアップロード処理
        $path = $request->file('document')->store('public/images');
        $filename = basename($path);

        // 商品データの保存
        $product = new Product();
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->image = $filename; // 保存したファイル名
        $product->description = $validated['description'];
        $product->save();

        // 季節データの保存
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
}
