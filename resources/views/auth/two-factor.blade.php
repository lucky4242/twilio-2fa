@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center bg-warning text-white">
                <h4>Two-Factor Authentication</h4>
            </div>
            <div class="card-body">
                @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <p class="text-center">Enter the 6-digit code sent to your phone.</p>
                <form method="POST" action="{{ route('2fa.check') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="two_factor_code" class="form-control text-center" required placeholder="Enter code">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Verify</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('2fa.send') }}" class="btn btn-link">Send Code</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection