@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>Add Note</h2>

        <a href="{{ route('notes.index') }}">Back</a>
        @include('components.alerts')

        <form action="{{ route('notes.store') }}" method="POST">

            @csrf

            <div class="row">
            
                <div class="col-auto">
                    <input type="text" class="form-input" placeholder="Title" name="title" required>
                </div>

                <div class="col-auto">
                    <textarea name="content" class="form-input" placeholder="Note" required></textarea>
                </div>

                <div class="col-auto">
                    <input type="submit" value="Add" class="btn btn-success">
                </div>

            </div>

        </form>

    </div>

@endsection