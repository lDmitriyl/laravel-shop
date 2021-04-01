@extends('layout.master')

@section('title', 'Корзина')

@section('content')
    <h1>Корзина</h1>
    <p>Оформление заказа</p>
    <div class="panel">
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
            @if(isset($order))
            @foreach($order->pros as $pro)
                <tr>
                    <td>
                        <a href="{{ route('product-offer',[$pro->product->category->code, $pro->product->code, $pro]) }}">
                            <img height="56px" src="{{ Storage::url($pro->product->image) }}">
                            {{ $pro->product->name}}
                        </a>
                    </td>
                    <td><span class="badge">{{ $pro->countInOrder }}</span>
                        <div class="btn-group form-inline">
                            <form action="{{ route('remove-basket', $pro) }}" method="POST">
                                <button type="submit" class="btn btn-danger" href=""><span
                                        class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
                                @csrf
                            </form>
                            <form action="{{ route('add-basket', $pro) }}" method="POST">
                                <button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </button>
                                @csrf
                            </form>
                        </div>
                    </td>
                    <td>{{ $pro->price }} {{ $currencySymbol }}</td>
                    <td>{{ $pro->price * $pro->countInOrder }} {{ $currencySymbol }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3">Общая стоимость:</td>
                @if($order->hasCoupon())
                    <td><strike>{{ $order->getFullSum() }} {{ $currencySymbol }}</strike>  <b>{{ $order->getFullSum(true) }}</b> {{ $currencySymbol }}</td>
                @else
                    <td>{{ $order->getFullSum() }} {{ $currencySymbol }}</td>
                @endif
            </tr>
            </tbody>
        </table>
        @if(!$order->hasCoupon())
            <div class="row">
                <div class="form-inline pull-right">
                    <form method="POST" action="{{ route('set-coupon') }}">
                        @csrf
                        <label for="coupon">@lang('basket.coupon.add_coupon'):</label>
                        <input class="form-control" type="text" name="coupon">
                        <button type="submit" class="btn btn-success">@lang('basket.coupon.apply')</button>
                    </form>
                </div>
            </div>
            @error('coupon')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @else
            <div>@lang('basket.coupon.your_coupon') {{ $order->coupon->code }}</div>
        @endif
        <br>
        @endif
        <br>
        <div class="btn-group pull-right" role="group">
            <a type="button" class="btn btn-success" href="{{ route('basket-place') }}">Оформить заказ</a>
        </div>
    </div>
@endsection
