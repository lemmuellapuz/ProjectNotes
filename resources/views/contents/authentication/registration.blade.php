@extends('layouts.auth')

@section('content')
    <div class="container">
            
            <form action="{{ route('signup.attempt') }}" method="POST">
                <div class="row mt-3">

                    @csrf

                    <div class="col-auto">
                        <input class="form-control" type="text" placeholder="Name" name="name" required>
                    </div>
                
                    <div class="col-auto">
                        <input class="form-control" type="email" placeholder="Email" name="email" required>
                    </div>
                
                    <div class="col-auto">
                        <input class="form-control" type="password" placeholder="Password" name="password" required>
                    </div>
                
                    <div class="col-auto">
                        <input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation" required>
                    </div>

                    <div class="col-12">
                        <div class="row mt-3">
                            @foreach($errors->all() as $error)
                                <p style="color:red;">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <input class="btn btn-primary" type="submit" value="Sign Up">
                    </div>

                </div>
            </form>

    </div>
@endsection