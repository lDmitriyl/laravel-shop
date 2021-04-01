@extends('layout.master')

@section('title', 'Список товаров')

@section('content')

    <h1>
        {{ $category->name }}
    </h1>
    <p>
        {{ $category->discription }}
    </p>
    @foreach($category->products->map->pros->flatten() as $prodOf)
        @include('layout.card', $prodOf)
    @endforeach

@endsection

