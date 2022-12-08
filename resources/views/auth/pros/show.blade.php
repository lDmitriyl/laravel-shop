@extends('auth.layout.master')

@section('title', 'Pro ' . $pro->name)

@section('content')
    <div class="col-md-12">
        <h1>Pro {{ $pro->product->name }}</h1>
        <h2>{{ $pro->propertyOptions->map->name->implode(', ') }}</h2>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $pro->id }}</td>
            </tr>
            <tr>
                <td>Цена</td>
                <td>{{ $pro->price }}</td>
            </tr>
            <tr>
                <td>Колличество</td>
                <td>{{ $pro->count }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
