@extends('layout.master')

@section('title', 'Товар')

@section('content')

    <h1>{{ $pro->product->__('name') }}</h1>
    <h2>{{ $pro->product->category->name }}</h2>
    <p>Цена: <b>{{ $pro->price }} ₽</b></p>

    @isset($pro->product->properties)
        @foreach($pro->propertyOptions as $propertyOption)
            <h4>{{$propertyOption->property->__('name')}}: {{ $propertyOption->__('name') }}</h4>
        @endforeach
    @endisset

    <img src="{{ Storage::url($pro->product->image) }}">
    <p>{{ $pro->product->__('description') }}</p>

        @if($pro->isAvailable())
            <form action="{{ route('add-basket', $pro->product) }}" method="POST">
            <button type="submit" class="btn btn-success" role="button">Добавить в корзину</button>
                @csrf
            </form>
        @else
            <span>Недоступен</span>
            <br>
            <span>Сообщить мне когда товар появиться в наличии:</span>
            @if($errors->get('email'))
                <span class="warning">{!! $errors->get('email')[0] !!}</span>
            @endif
            <form method="POST" action="{{ route('subscription', $pro) }}">
                <input type="text" name="email">
                <button type="submit">Отправить</button>
                @csrf
            </form>
        @endif
@endsection
