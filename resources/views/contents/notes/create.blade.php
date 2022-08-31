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

                <div class="col-12">
                    <input type="file" name="attachment" id="attachment">
                </div>

                <div class="col-auto">
                    <input type="submit" value="Add" class="btn btn-success">
                </div>

            </div>

        </form>

    </div>

@endsection

@section('script')

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="{{ asset('js/filepond.js') }}"></script>

@endsection