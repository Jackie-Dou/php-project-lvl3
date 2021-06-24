@extends('layouts.app')

@section('title', 'Url Page')

@section('content')
    <h1>{{$url->name}}</h1>
    <div>{{$url->created_at}}</div>
@endsection
