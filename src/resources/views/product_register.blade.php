@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_register.css') }}">
@endsection

@section('content')

<body>

    <form class="form" name="contact" method="POST">
        <div class="container-title">
            <h1>商品登録</h1>
        </div>
        <div class="form-item">
            <p class="form-item-label">
                商品名<span class="form-item-label-required">必須</span>
            </p>
            <input type="text" name="name" class="form-item-input" placeholder="商品名を入力" />
        </div>
        <div class="form-item">
            <p class="form-item-label">
                値段<span class="form-item-label-required">必須</span>
            </p>
            <input type="text" name="price" class="form-item-input" placeholder="値段を入力" />
        </div>
        <div class="form-item">
            <p class="form-item-label">
                商品画像<span class="form-item-label-required">必須</span>
            </p>
            <input type="text" name="image" class="form-item-input" placeholder="値段を入力" />
        </div>
        <div class="form-item">
            <p class="form-item-label">
                季節<span class="form-item-label-required">必須</span>
                <span class="multi-select">複数選択可</span>
            </p>
            <div class="checkbox-group">
                <input type="checkbox" id="checkbox1">
                <label for="checkbox1" class="label_test">春</label>
                <input type="checkbox" id="checkbox2">
                <label for="checkbox2" class="label_test">夏</label>
                <input type="checkbox" id="checkbox3">
                <label for="checkbox3" class="label_test">秋</label>
                <input type="checkbox" id="checkbox4">
                <label for="checkbox4" class="label_test">冬</label>
            </div>
        </div>
        <div class="form-item">
            <p class="form-item-label">
                商品説明<span class="form-item-label-required">必須</span>
            </p>
            <textarea name="textarea" class="form-item-textarea" placeholder="商品の説明を入力"></textarea>
        </div>
        <div class="button-container">
            <button type="button" class="form-btn__back" onclick="history.back()">戻る</button>
            <input type="submit" class="form-btn" value="登録" />
        </div>
    </form>

</body>
@endsection