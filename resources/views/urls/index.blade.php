@extends('layouts.app')

@section('title', 'Urls List')

@section('content')
    <a href="/"> Главная </a>
    <a href="{{ route('urls.index') }}">Urls</a>
    <hr>
    <table>
        @foreach ($urls as $url)
            <tr>
                <td> <a href="{{ route('urls.show', $url->id) }}"> {{ $url->name }} </td>
                <td>|  {{$lastChecks[$url->id]->created_at ?? ''}}</td>
                <td>|  {{$lastChecks[$url->id]->status_code ?? ''}}</td>
            </tr>
        @endforeach
    </table>
@endsection
