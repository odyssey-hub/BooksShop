@extends('auth.layouts.master')

@isset($product)
    @section('title', 'Редактировать товар ' . $product->name)
@else
    @section('title', 'Создать товар')
@endisset

@section('content')
    <link href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
            integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="{{asset("js/autocomplete.js")}}"></script>
    <div class="col-md-12">
        @isset($product)
            <h1>Редактировать товар <b>{{ $product->name }}</b></h1>
        @else
            <h1>Добавить товар</h1>
        @endisset
        <form method="POST" enctype="multipart/form-data"
              @isset($product)
              action="{{ route('products.update', $product) }}"
              @else
              action="{{ route('products.store') }}"
            @endisset
        >
            <div>
                @isset($product)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Код: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'code'])
                        <input type="text" class="form-control" name="code" id="code"
                               value="@isset($product){{ $product->code }}@endisset" required placeholder="Введите код">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'name'])
                        <input type="text" class="form-control" name="name" id="name"
                               value="@isset($product){{ $product->name }}@endisset" required placeholder="Введите название">
                    </div>
                </div>
                <br>
                    <div class="input-group row">
                        <label for="author" class="col-sm-2 col-form-label">Автор: </label>
                        <div class="col-sm-6">
                            @include('auth.layouts.error', ['fieldName' => 'author'])
                            <input type="text" class="form-control" name="author" id="author"
                                   value="@isset($product){{ $product->author }}@endisset" required placeholder="Введите фамилию и инициалы"
                            >
                        </div>
                    </div>
                    <br>
                <div class="input-group row">
                    <label for="genres" class="col-sm-2 col-form-label">Жанр: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'genres'])
{{--                        <input type="text" class="form-control" name="genres" id="genres"--}}
{{--                               value="@isset($product){{ $product->genres }}@endisset" required>--}}
                        <select name="genres" id="genres" class="form-control">
                            <option   @isset($product)
                                      @if($product->genres === "Фантастика")
                                      selected
                                      @endif
                                      @endisset
                                      value="Фантастика">Фантастика</option>
                            <option   @isset($product)
                                      @if($product->genres === "Мистика")
                                      selected
                                      @endif
                                      @endisset
                                      value="Мистика">Мистика</option>
                            <option   @isset($product)
                                      @if($product->genres === "Драма")
                                      selected
                                      @endif
                                      @endisset
                                      value="Драма">Драма</option>
                            <option   @isset($product)
                                      @if($product->genres === "Ужасы")
                                      selected
                                      @endif
                                      @endisset
                                      value="Ужасы">Ужасы</option>
                            <option    @isset($product)
                                       @if($product->genres === "Фэнтези")
                                       selected
                                       @endif
                                       @endisset
                                       value="Фэнтези">Фэнтези</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="year" class="col-sm-2 col-form-label">Год: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'year'])
                        <input type="number" class="form-control" name="year" id="year"
                               value="@isset($product){{ $product->year }}@endisset" required
                        pattern="[0-9][0-9][0-9][0-9]" placeholder="Введите год в формате yyyy">
                    </div>
                </div>
                <br>
                <div class="input-group row d-none">
                    <label for="name" class="col-sm-2 col-form-label">Название en: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'name_en'])
                        <input type="text" class="form-control" name="name_en" id="name_en"
                               value="fractal">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Категория: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'category_id'])
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        @isset($product)
                                        @if($product->category_id == $category->id)
                                        selected
                                    @endif
                                    @endisset
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'description'])
                        <textarea name="description" id="description" cols="72"
                                  rows="7" required placeholder="Введите описание">@isset($product){{ $product->description }}@endisset</textarea>
                    </div>
                </div>
                <br>
                <div class="input-group row d-none">
                    <label for="description" class="col-sm-2 col-form-label">Описание en: </label>
                    <div class="col-sm-6">
                        @include('auth.layouts.error', ['fieldName' => 'description_en'])
                        <textarea name="description_en" id="description_en" cols="72"
                                  rows="7">fractal</textarea>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-10">
                        <label class="btn btn-default btn-file">
                            Загрузить <input type="file" value="@isset($product){{$product->image}}}@endisset" style="display: none;" name="image" id="image">
                        </label>
                    </div>
                </div>
                <br>

                    <div class="input-group row d-none">
                        <label for="category_id" class="col-sm-2 col-form-label">Свойства товара: </label>
                        <div class="col-sm-6">
                            @include('auth.layouts.error', ['fieldName' => 'property_id[]'])
                            <select name="property_id[]" multiple>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}"
                                            @isset($product)
                                            @if($product->properties->contains($property->id))
                                            selected
                                        @endif
                                        @endisset
                                    >{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <br>

                @foreach ([
                'hit' => 'Хит',
                'new' => 'Новинка',
                'recommend' => 'Рекомендуемые'
                ] as $field => $title)
                    <div class="form-group row">
                        <label for="code" class="col-sm-2 col-form-label">{{ $title }}: </label>
                        <div class="col-sm-10">
                            <input type="checkbox" name="{{$field}}" id="{{$field}}"
                                   @if(isset($product) && $product->$field === 1)
                                   checked="'checked"
                                @endif
                            >
                        </div>
                    </div>
                    <br>
                @endforeach
                <button class="btn btn-success" type="submit">Сохранить</button>
            </div>
        </form>
    </div>

@endsection
