@extends('layouts.app')

@section('title', 'Url Page')

@section('content')
    <a href="/"> Главная </a>
    <hr>
    <h1>{{$url->name}}</h1>
    <div>{{$url->created_at}}</div>
    <hr>
    {{ Form::open(array('route' => array('url_checks.store', $url->id)))}}
    {{ Form::submit('Run check') }}
    {{ Form::close() }}
@endsection
