@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
@endsection

@section('content')

<body>
    <div class="container">
        <form action="{{ route('products.update', ['product_id' => $product->id]) }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="product-top">
                <a class="product-list" href="/products">商品一覧</a> > {{ $product->name }}
            </div>
            <div class="products">

                <div class="products__image">
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}の画像">
                    <input type="file" name="document" class="form-control" value="{{ old('image') }}" />

                </div>
                <div class="products__container">
                    <div class="form-item">
                        <p class="form-item-label">商品名</p>
                        <input type="text" name="name" class="form-item-input" value="{{ $product->name }}" />
                    </div>
                    <div class="form-item">
                        <p class="form-item-label">値段</p>
                        <input type="text" name="price" class="form-item-input" value="{{ $product->price }}" />
                    </div>
                    <div class="form-item">
                        <p class="form-item-label">季節</p>
                        <div class="checkbox-group">
                            @foreach(['春', '夏', '秋', '冬'] as $season)
                            <input type="checkbox" id="checkbox{{ $season }}" name="seasons[]" value="{{ $season }}" {{ in_array($season, old('seasons', $season_names)) ? 'checked' : '' }}>
                            <label for="checkbox{{ $season }}" class="label_test">{{ $season }}</label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-item">
                <p class="form-item-label form-item-label-description">商品説明</p>
                <textarea name="description" class="form-item-textarea">{{ $product->description }}</textarea>
            </div>

            <div class="button-container">
                <button type="button" class="form-btn__back" onclick="history.back()">戻る</button>
                <input type="submit" class="form-btn" value="変更を保存" />
            </div>
        </form>
    </div>

</body>
@endsection