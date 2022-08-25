@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>Edit Note</h2>

        <a href="{{ url()->previous() }}">Back</a>

        @include('components.alerts')

        <form action="{{ route('notes.update', ['note' => $note]) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">
            
                <div class="col-auto">
                    <input type="text" class="form-input" placeholder="Title" name="title" value="{{ $note->title }}" required>
                </div>

                <div class="col-auto">
                    <textarea name="content" class="form-input" placeholder="Note" required>{{ $note->content }}</textarea>
                </div>

                <div class="col-auto">
                    <input type="submit" value="Update" class="btn btn-success">
                </div>

            </div>

        </form>

    </div>

@endsection