@extends('layouts.app')

@section('title', 'Url Page')

@section('content')
    <a href="/"> Главная </a>
    <a href="{{ route('urls.index') }}">Urls</a>
    <hr>
    <h1>{{$url->name}}</h1>
    <div>{{$url->created_at}}</div>
    <hr>
    {{ Form::open(array('route' => array('url_checks.store', $url->id)))}}
    {{ Form::submit('Run check') }}
    {{ Form::close() }}
    <hr>
    <table>
        @foreach ($url_checks as $check)
            <tr>
                <td>{{ $check->id }} </td>
                <td>|  {{ $check->created_at ?? "___"}}</td>
                <td>|  {{ $check->status_code ?? "___"}}</td>
                <td>|  {{$check->h1 ?? "___"}}</td>
                <td>|  {{$check->keywords ?? "___"}}</td>
                <td>|  {{$check->description ?? "___"}}</td>
            </tr>
        @endforeach
    </table>
@endsection
