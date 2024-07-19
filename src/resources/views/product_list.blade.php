@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_list.css') }}">
@endsection

@section('content')

<body>
    <div class="container-title">
        <h1>商品一覧</h1>
        @if(empty($search))
        <div class="add__button">
            <a href="/products/register" class="button">+商品を追加</a>
        </div>
        @endif
    </div>

    <div class="container">
        <div class="left-menu">
            <form class="form__button" action="{{ route('products.search') }}" method="GET">
                <div class="form-group">
                    <input type="text" name="query" id="item" class="form-control" placeholder=商品名で検索 value="{{ request('query') }}">
                </div>
                <button type=" submit" class="btn btn-primary">検索</button>
            </form>
            <h2>価格順で表示</h2>
            <form class="sort-form" action="{{ route('products.search') }}" method="get">
                <select class="form-choice" name="sort_by" onchange="this.form.submit()">
                    <option value="" disabled {{ !request('sort_by') ? 'selected' : '' }}>価格で並べ替え</option>
                    <option value="high_to_low" {{ request('sort_by') == 'high_to_low' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="low_to_high" {{ request('sort_by') == 'low_to_high' ? 'selected' : '' }}>安い順に表示</option>
                </select>
            </form>
        </div>
        <div class="main-contents">
            @foreach ($products as $product)
            <a href="{{ url('/products/' . $product->id) }}" class="card">
                <div class="card__img">
                    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}の画像">
                </div>
                <div class="card__container">
                    <p class="text">{{ $product->name }}</p>
                    <p class="text">¥{{ $product->price }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    @if(empty($search))
    <div class="pagination">
        @if ($products->onFirstPage())
        <span class="arrow">&lt;</span>
        @else
        <a href="{{ $products->previousPageUrl() }}" rel="prev" class="arrow">&lt;</a>
        @endif

        @for ($i = 1; $i <= $products->lastPage(); $i++)
            @if ($i == $products->currentPage())
            <span class="active">{{ $i }}</span>
            @else
            <a href="{{ $products->url($i) }}">{{ $i }}</a>
            @endif
            @endfor

            @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" rel="next" class="arrow">&gt;</a>
            @else
            <span class="arrow">&gt;</span>
            @endif

    </div>
    @endif



</body>
@endsection