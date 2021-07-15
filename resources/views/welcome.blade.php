@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div>
        <div>
            <h1>Page Analyzer</h1>
            <a href="{{ route('urls.index') }}">Urls</a>
            <p>Check web page for free</p>
            <hr>
            {{ Form::open(['route' => 'urls.store'])}}
                {{ Form::text('url[name]', $value = null, $attributes = [
                'placeholder' => 'https://www.example.com'])
                }}
                {{ Form::submit('Check') }}
            {{ Form::close() }}
        </div>
    </div>
@endsection
