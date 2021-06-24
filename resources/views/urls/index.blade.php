@extends('layouts.app')

@section('title', 'Urls List')

@section('content')
    <a href="/"> Главная </a>
    <hr>
    <table>
        @foreach ($urls as $url)
            <tr>
                <td> <a href="{{ route('urls.show', $url->id) }}"> {{ $url->name }}</td>
                <td>{{$url->created_at}} / {{$url->updated_at}}</td>
            </tr>
        @endforeach
    </table>
@endsection
