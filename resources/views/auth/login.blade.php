@extends('index')

@section('content')
    <form method="post" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>


    <form method="post" action="/login">
        @csrf
        <input type="email" name="email">
        <input type="password" name="password">
        <button type="submit">Login</button>
    </form>

    @if($errors->any())
        <h1>{{ $errors->first() }}</h1>
    @endif
@endsection

