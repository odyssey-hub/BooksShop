@extends('layouts.master')

@section('title', __('main.all_categories'))

@section('content')
    @foreach($categories as $category)
        <div class="panel">
            <a href="{{ route('category', $category->code) }}">
                <img src="{{asset('storage/'.$category->image)}}" style="width:20rem">
                <h2>{{ $category->__('name') }}</h2>
            </a>
            <p>
                {{ $category->__('description') }}
            </p>
        </div>
    @endforeach
@endsection
