@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


@endsection

@section('content')

<body>
    <div class="container">
        <form action="{{ route('products.update', ['product_id' => $product->id]) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="product-top">
                <a class="product-list" href="/products">商品一覧</a> > {{ $product->name }}
            </div>

            <div class="products">
                <div class="products__image">
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}の画像">
                    <input type="file" name="document" class="form-control" value="{{ old('image') }}" />
                    <div class="form__error">
                        @error('document')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="products__container">
                    <div class="form-item">
                        <p class="form-item-label">商品名</p>
                        <input type="text" name="name" class="form-item-input" value="{{ $product->name }}" />
                        <div class="form__error">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-item">
                        <p class="form-item-label">値段</p>
                        <input type="text" name="price" class="form-item-input" value="{{ $product->price }}" />
                        <div class="form__error">
                            @error('price')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-item">
                        <p class="form-item-label">季節</p>
                        <div class="checkbox-group">
                            @foreach(['春', '夏', '秋', '冬'] as $season)
                            <input type="checkbox" id="checkbox{{ $season }}" name="season[]" value="{{ $season }}" {{ in_array($season, old('season', $season_names)) ? 'checked' : '' }}>
                            <label for="checkbox{{ $season }}" class="label_test">{{ $season }}</label>
                            @endforeach
                            <div class="form__error">
                                @error('season')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-item">
                <p class="form-item-label form-item-label-description">商品説明</p>
                <textarea name="description" class="form-item-textarea">{{ $product->description }}</textarea>
                <div class="form__error">
                    @error('description')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="button-container">
                <div class="button-group">
                    <button type="button" class="form-btn__back" onclick="history.back()">戻る</button>
                    <input type="submit" class="form-btn" value="変更を保存" />
                </div>
        </form>

        @if (session('errors'))

        @else
        <form action="{{ route('products.delete', ['product_id' => $product->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </form>
        @endif

    </div>
    </div>

    <script>
        document.querySelector('.delete-btn').addEventListener('click', function() {
            if (confirm('本当に削除しますか？')) {
                document.getElementById('delete-form').submit();
            }
        });
    </script>

</body>
@endsection