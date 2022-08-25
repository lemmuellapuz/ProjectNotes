@extends('layouts.app')

@section('content')

    <div class="container">

        <h3>Title: {{ $note->title }}</h3>
        <p>{{ $note->content }}</p>

        <div class="row">
            <div class="col-auto">
                <a href=" {{ route('notes.edit', ['note' => $note]) }}" class="btn btn-secondary">Edit</a>
            </div> 

            <div class="col-auto">
                <a href="{{ route('notes.index') }}" class="btn btn-danger">Back</a>
            </div>
        </div>

    </div>

@endsection