@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_list.css') }}">
@endsection

@section('content')

<body>
    <div class="container-title {{ empty($search) ? 'has-add-button' : 'no-add-button' }}">
        <h1>
            @if(isset($search) && $search != '')
            "{{ $search }}"の 商品一覧
            @else
            商品一覧
            @endif
        </h1>
        @if(empty($search))
        <div class="add__button">
            <a href="/products/register" class="button">+商品を追加</a>
        </div>
        @endif
    </div>

    <div class="container">
        <div class="left-menu">
            <form class="form__button" action="{{ route('products.search') }}" method="GET" id="search-sort-form">
                <div class="form-group">
                    <input type="text" name="query" id="item" class="form-control" placeholder="商品名で検索" value="{{ request('query') }}">
                </div>
                <button type="submit" class="btn btn-primary">検索</button>

                <h2>価格順で表示</h2>

                <div class="select-wrapper">
                    <label class="select-box">
                        <select class="form-select" id="sort-select" name="sort_by">
                            <option value="" disabled selected>価格で並べ替え</option>
                            <option value="high_to_low" {{ request('sort_by') == 'high_to_low' ? 'selected' : '' }}>高い順に表示</option>
                            <option value="low_to_high" {{ request('sort_by') == 'low_to_high' ? 'selected' : '' }}>安い順に表示</option>
                        </select>
                    </label>

                    <div class="line"></div>

                    <!-- モーダル -->
                    <div class="modal" id="modal">
                        <div class="modal-content">
                            <p id="modal-content"></p>
                            <span class="close" id="modal-close">&times;</span>
                        </div>
                    </div>
                </div>
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
            <div class="main-contents__bottom">
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
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('sort-select');
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            const modalClose = document.getElementById('modal-close');
            const form = document.getElementById('search-sort-form');
            const queryInput = document.getElementById('item');

            // ページがロードされたときにモーダルを表示する
            window.addEventListener('load', () => {
                const urlParams = new URLSearchParams(window.location.search);
                const sortBy = urlParams.get('sort_by');
                if (sortBy) {
                    const selectedValue = select.options[select.selectedIndex].text;
                    modalContent.textContent = `${selectedValue}`;
                    modal.style.display = 'block';
                }
            });

            // 並び替え
            select.addEventListener('change', () => {
                form.submit();
            });

            // モーダルのクローズボタン
            modalClose.addEventListener('click', () => {
                // 検索クエリはそのままにする
                // 並び替え選択肢をリセットしてフォームを送信
                const formData = new FormData(form);
                formData.set('sort_by', ''); // 並び替えの選択肢をリセット
                const queryString = new URLSearchParams(formData).toString();
                window.location.search = queryString; // クエリパラメータを更新
                modal.style.display = 'none'; // モーダルを非表示にする
            });

            // モーダル外のクリックで閉じる（オプション）
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none'; // モーダルを非表示にする
                }
            });
        });
    </script>

</body>
@endsection