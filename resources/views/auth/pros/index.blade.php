@extends('auth.layout.master')

@section('title', 'Товарные предложения')

@section('content')
    <div class="col-md-12">
        <h1>Товарные предложения</h1>
        <h2>{{ $product->name }}</h2>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Товарное предложение (свойства)
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($pros as $pro)
                <tr>
                    <td>{{ $pro->id }}</td>
                    <td>{{ $pro->propertyOptions->map->name->implode(', ') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('pros.destroy', [$product, $pro]) }}" method="POST">
                                <a class="btn btn-success" type="button" href="{{ route('pros.show', [$product, $pro]) }}">Открыть</a>
                                <a class="btn btn-warning" type="button" href="{{ route('pros.edit', [$product, $pro]) }}">Редактировать</a>
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger" type="submit" value="Удалить">
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $pros->links() }}
        <a class="btn btn-success" type="button"
           href="{{ route('pros.create', $product) }}">Добавить Pro</a>
    </div>
@endsection
