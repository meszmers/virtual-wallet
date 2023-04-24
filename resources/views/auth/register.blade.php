@extends('index')

@section('content')
    <div class="wrapper">
        <form action="/register" method="post">
            @csrf
            <div class="container">
                @csrf
                <input type="text" placeholder="Enter Name" name="name" required>
                <input type="email" placeholder="Enter Email" name="email" required>
                <input type="password" placeholder="Enter Password" name="password" required>
                <input type="password" placeholder="Enter Password" name="password_confirmation" required>
                <button type="submit">Login</button>
            </div>
        </form>
        <a href="/login">
            Login
        </a>
        @if($errors->any())
            <span class="errors">{{ $errors->first() }}</span>
        @endif
    </div>



@endsection


<style>
    body {font-family: Arial, Helvetica, sans-serif;}
    form {
        border: 3px solid #f1f1f1;
    }
    .wrapper {
        width: 400px;
        margin: 300px auto auto auto;
    }

    a {
        color: #04AA6D;
    }

    a:link {
        text-decoration: none;
    }

    a:visited {
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    a:active {
        text-decoration: underline;
    }

    input {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        opacity: 0.8;
    }

    .container {
        padding: 16px;
    }

    span.psw {
        float: right;
        padding-top: 16px;
    }

    span.errors {
        color: red;
    }
</style>

