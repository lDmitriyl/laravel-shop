@extends('auth.layout.master')

@isset($pro )
    @section('title', 'Редактировать свойство ' . $pro ->name)
@else
    @section('title', 'Создать свойство')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($pro )
            <h1>Редактировать Pro <b>{{ $pro ->name }}</b></h1>
        @else
            <h1>Добавить Pro</h1>
        @endisset

        <form method="POST" enctype="multipart/form-data"
              @isset($pro )
              action="{{route('pros.update', [$product, $pro] ) }}"
              @else
              action="{{route('pros.store', $product) }}"
            @endisset
        >
            <div>
                @isset($pro )
                    @method('PUT')
                @endisset
                @csrf

                <div class="input-group row">
                    <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-2">
                        @include('auth.layout.error', ['fieldName' => 'price'])
                        <input type="text" class="form-control" name="price"
                               value="@isset($pro){{ $pro->price }}@endisset">
                    </div>
                </div>
                <div class="input-group row">
                    <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
                    <div class="col-sm-2">
                        @include('auth.layout.error', ['fieldName' => 'count'])
                        <input type="text" class="form-control" name="count"
                               value="@isset($pro){{ $pro->count }}@endisset">
                    </div>
                </div>
                <br>

                    @foreach ($product->properties as $property)
                        <div class="input-group row">
                            <label for="property_id[{{ $property->id }}]" class="col-sm-2 col-form-label">{{ $property->name }}: </label>
                            <div class="col-sm-6">
                                <select name="property_id[{{ $property->id }}]" class="form-control">
                                    @foreach($property->propertyOptions as $propertyOption)
                                        <option value="{{ $propertyOption->id }}"
                                                @isset($pro)
                                                @if($pro->propertyOptions->contains($propertyOption->id))
                                                selected
                                            @endif
                                            @endisset
                                        >{{ $propertyOption->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                <br>
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
