@extends('layouts.master')

@section('title', __('main.title'))

@section('content')
    <h1>@lang('main.all_products')</h1>
    <div class="row" style="margin-top: 2rem">
        <div class="col-lg-2">
            <form method="GET" action="{{route("index")}}">
                <div class="row">
                    <select name="sortField" id="sortField" class="form-control">
                        <option value="year">По году</option>
                        <option value="sells"
                                @if(request()->sortField == "sells")
                                selected
                            @endif
                        >По объемам продаж</option>
                        <option value="price"
                                @if(request()->sortField == "price")
                                selected
                            @endif
                        >По цене</option>
                    </select>
                </div>
                <div class="row" style="margin-top: 1rem">
                    <select name="sortOrder" id="sortOrder" class="form-control">
                        <option value="asc">По возрастанию</option>
                        <option value="desc"
                                @if(request()->sortOrder == "desc")
                                selected
                            @endif
                        >По убыванию</option>
                    </select>
                </div>
                <div class="row" style="margin-top: 2rem">
                    <label for="book_name">
                    <input type="text" name="book_name" id="book_name" size="30" placeholder="Название" value="{{ request()->book_name }}">
                    </label>
                </div>
                <div class="row" style="margin-top: 2rem">
                    <label for="author">
                        <input type="text" name="author" id="author" size="30" placeholder="Автор" value="{{ request()->author }}">
                    </label>
                </div>
                <div class="row" style="margin-top: 2rem">
                        <label for="price_from">@lang('main.price_from')
                            <input type="number" name="price_from" id="price_from" size="6"
                                   value="{{ request()->price_from}}" placeholder="число">
                        </label>
                        <label for="price_to">@lang('main.to')
                            <input type="number" name="price_to" id="price_to" size="6" placeholder="число" value="{{ request()->price_to }}">
                        </label>
                </div>
                <div class="row" style="margin-top:1rem">
                    <label for="year_from">Год от
                        <input type="number" name="year_from" id="year_from" size="6" placeholder="yyyy">
                    </label>
                    <label for="year_to">до
                        <input type="number" name="year_to" id="year_to" size="6" placeholder="yyyy">
                    </label>
                </div>
                <div class="row" style="margin-top:1rem">
                    <label for="filterGenre" class="col-form-label col-lg-3">Жанр</label>
                    <div class="col-lg-9">
                        <select name="filterGenre" id="filterGenre" class="form-control">
                            <option value="Все">Все</option>
                            <option value="Фантастика"
                                    @if(request()->filterGenre == "Фантастика")
                                    selected
                                @endif
                            >Фантастика</option>
                            <option value="Мистика"
                                    @if(request()->filterGenre == "Мистика")
                                    selected
                                @endif
                            >Мистика</option>
                            <option value="Драма"
                                    @if(request()->filterGenre == "Драма")
                                    selected
                                @endif>Драма</option>
                            <option value="Ужасы"
                                    @if(request()->filterGenre == "Ужасы")
                                    selected
                                @endif>Ужасы</option>
                            <option value="Фэнтези"
                                    @if(request()->filterGenre == "Фэнтези")
                                    selected
                                @endif>Фэнтези</option>
                        </select>
                    </div>
                </div>
                <div class="row" style="margin-top: 1rem">
                    <div class="col-lg-6">
                    <label for="hit">
                        <input type="checkbox" name="hit" id="hit" @if(request()->has('hit')) checked @endif> Бестселлер
                    </label>
                    </div>
                </div>
                <div class="row"  style="margin-top: 1rem">
                    <div class="col-lg-5">
                    <label for="new">
                        <input type="checkbox" name="new" id="new" @if(request()->has('new')) checked @endif> @lang('main.properties.new')
                    </label>
                    </div>
                </div>
                <div class="row"  style="margin-top: 1rem">
                    <div class="col-lg-7">
                    <label for="recommend">
                        <input type="checkbox" name="recommend" id="recommend" @if(request()->has('recommend')) checked @endif> @lang('main.properties.recommend')
                    </label>
                    </div>
                </div>
                <div class="row" style="margin-top: 1rem">
                    <button type="submit" class="btn btn-primary" style="width:20rem">@lang('main.filter')</button>
                    <a href="{{ route("index") }}" class="btn btn-warning">@lang('main.reset')</a>
                </div>
            </form>
        </div>
        <div class="col-lg-10">
            @foreach($skus as $sku)
                @include('layouts.card', compact('sku'))
            @endforeach
        </div>
        {{ $skus->links() }}
    </div>

@endsection
