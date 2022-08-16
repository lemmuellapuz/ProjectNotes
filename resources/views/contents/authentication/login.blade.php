@extends('layouts.auth')

@section('content')
    <div class="container">

        <form action="{{ route('login.attempt') }}" method="POST">
            <div class="row mt-3">

                <h3 class="mb-3">Sign In</h3>

                @if(session('success'))
                    <div class="col-12">
                        <div class="alert alert-success">{{ session('success') }}</div>
                    </div>
                @elseif(session('error'))
                    <div class="col-12">
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    </div>
                @endif

                @csrf

                <div class="col-auto">
                    <input class="form-control" placeholder="Email" type="email" name="email" required>
                </div>

                <div class="col-auto">
                    <input class="form-control" placeholder="Password" type="password" name="password" required>
                </div>

                <div class="col-auto">
                    <input class="btn btn-primary mb-3" type="submit" value="Sign In" required>
                </div>

                <div class="col-12">
                    <div class="row mt-3">
                        @foreach($errors->all() as $error)
                            <p style="color:red;">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>

                <div class="col-12">
                    <a href="{{ route('signup') }}">Sign up</a>
                </div>
            </div>
        </form>
       
    </div>
@endsection