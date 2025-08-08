@extends('layouts.app')
@section('content')
<div class="text-center mt-5">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    <p>You are now logged in.</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
@endsection