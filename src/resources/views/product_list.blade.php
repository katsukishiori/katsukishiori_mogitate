@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_list.css') }}">
@endsection

@section('content')

<body>
    <div class="container-title">
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
            <form class="form__button" action="{{ route('products.search') }}" method="GET" id="search-form">
                <div class="form-group">
                    <input type="text" name="query" id="item" class="form-control" placeholder="商品名で検索" value="{{ request('query') }}">
                </div>
                <button type="submit" class="btn btn-primary">検索</button>
            </form>

            <h2>価格順で表示</h2>

            <!-- 並び替えフォーム -->
            <form class="sort-form" action="{{ route('products.search') }}" method="get" id="sort-form">
                <div class="select-wrapper">
                    <select class="form-choice" id="sort-select" name="sort_by">
                        <option value="" disabled selected>価格で並べ替え</option>
                        <option value="high_to_low" {{ request('sort_by') == 'high_to_low' ? 'selected' : '' }}>高い順に表示</option>
                        <option value="low_to_high" {{ request('sort_by') == 'low_to_high' ? 'selected' : '' }}>安い順に表示</option>
                    </select>

                    <!-- モーダル -->
                    <div class="modal" id="modal">
                        <div class="modal-content">
                            <p id="modal-content">選択された並び替え条件はここに表示されます。</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('sort-select');
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modal-content');
            const modalClose = document.getElementById('modal-close');
            const resetButton = document.getElementById('reset-button');
            const form = document.getElementById('sort-form');

            // セレクトボックスの変更イベント
            select.addEventListener('change', () => {
                form.submit();
            });

            // 選択された値をモーダルに表示する関数
            window.showModal = () => {
                const selectedValue = select.options[select.selectedIndex].text;
                modalContent.textContent = `選択された並び替え条件: ${selectedValue}`;
                modal.style.display = 'block';
                form.submit(); // 並び替えを実行
            };

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

            // モーダルのクローズボタンのイベント
            modalClose.addEventListener('click', () => {
                select.selectedIndex = 0; // セレクトボックスをリセット
                modal.style.display = 'none';
                form.submit(); // フォームを送信
            });
            // リセットボタンのイベント
            resetButton.addEventListener('click', () => {
                select.selectedIndex = 0; // セレクトボックスをリセット
                modal.style.display = 'none';
                form.submit(); // フォームを送信
            });

            // モーダル外のクリックで閉じる（オプション）
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                    form.submit(); // フォームを送信
                }
            });
        });
    </script>


</body>
@endsection