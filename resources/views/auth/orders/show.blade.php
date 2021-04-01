@extends('auth.layout.master')

@section('title', 'Заказы')

@section('content')
    <div class="py-4">
        <div class="container">
            <div class="justify-content-center">
                <div class="panel">
                    <h1>Заказ №{{ $order->id }}</h1>
                    <p>Заказчик: <b>{{ $order->name }}</b></p>
                    <p>Номер телефона: <b>{{ $order->phone }}</b></p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Кол-во</th>
                            <th>Цена</th>
                            <th>Стоимость</th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach ($pros as $pro)
                            <tr>
                                <td>
                                    <a href="{{ route('product-offer', [$pro->product->category->code, $pro->product->code, $pro]) }}">
                                        <img height="56px" src="{{ Storage::url($pro->product->image) }}">
                                        {{ $pro->product->name }}
                                    </a>
                                </td>
                                <td><span class="badge">{{ $pro->pivot->count }}</span></td>
                                <td>{{ $pro->pivot->price }} {{ $order->currency->symbol }}</td>
                                <td>{{ $pro->pivot->price * $pro->pivot->count }} {{ $order->currency->symbol }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">Общая стоимость:</td>
                            <td>{{ $order->sum }} {{ $order->currency->symbol }}</td>
                        </tr>
                        @if($order->hasCoupon())
                            <tr>
                                <td colspan="3">Был использован купон:</td>
                                <td><a href="{{ route('coupons.show', $order->coupon) }}">{{ $order->coupon->code }}</a></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection
