@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product_list.css') }}">
@endsection

@section('content')

<body>

    <h1>{{ $product->name }}</h1>
    <p>価格: ¥{{ $product->price }}</p>
    <p>{{ $product->description }}</p>
    <img src="{{ asset('storage/images/' . $product->image) }}" alt="{{ $product->name }}の画像">

</body>
@endsection