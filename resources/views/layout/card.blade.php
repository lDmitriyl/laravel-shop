<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
            @if($prodOf->product->isNew())
                <span class="badge badge-success">Новинка</span>
            @endif
            @if($prodOf->product->isHit())
                <span class="badge badge-warning">Хит продаж!!</span>
            @endif
            @if($prodOf->product->isRecommend())
                <span class="badge badge-danger">Рекомендуем</span>
            @endif

        </div>
        <img src="{{ Storage::url($prodOf->product->image) }}" alt="{{ $prodOf->product->__('name') }}">
        <div class="caption">
            <h3>{{ $prodOf->product->__('name') }}</h3>
            @isset($prodOf->product->properties)
                @foreach($prodOf->propertyOptions as $propertyOption)
                    <h4>{{$propertyOption->property->__('name')}}: {{ $propertyOption->__('name') }}</h4>
                @endforeach
            @endisset

            <p>{{ $prodOf->price }}{{ $currencySymbol }}</p>
            <p>
            <form action="{{ route('add-basket', $prodOf) }}" method="POST">
                @if($prodOf->isAvailable())
                    <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                @else
                    Недоступен
                @endif

                <a href="{{ route('product-offer', [isset($category->code) ? $category->code : $prodOf->product->category->code, $prodOf->product->code, $prodOf->id]) }}"
                   class="btn btn-default"
                   role="button">Подробнее</a>
                @csrf
            </form>
        </div>
    </div>
</div>
