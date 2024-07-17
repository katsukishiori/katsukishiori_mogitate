@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
@endsection

@section('content')

<body>
    <div class="container">
        <div class="product-top">
            <a class="product-list" href="/products">商品一覧</a> > {{ $product->name }}
        </div>
        <div class="products">

            <div class="products__image">
                <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}の画像">

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

                </div>
            </div>
        </div>

        <div class="form-item">
            <p class="form-item-label form-item-label-description">商品説明</p>
            <textarea name="textarea" class="form-item-textarea">{{ $product->description }}</textarea>
        </div>

        <div class="button-container">
            <button type="button" class="form-btn__back" onclick="history.back()">戻る</button>
            <input type="submit" class="form-btn" value="変更を保存" />
        </div>



    </div>

</body>
@endsection