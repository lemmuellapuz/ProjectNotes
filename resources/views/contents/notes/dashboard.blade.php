@extends('layouts.app')

@section('content')

    <div class="container mt-3">

        <div class="row">

            @include('components.alerts')

            <div class="col-auto">
                <a href="{{ route('notes.create') }}" class="btn btn-primary">Add note</a>
            </div>

            <div class="col-12">
                
                <div class="mt-3">
                    <h3>Notes list</h3>

                    <table id="notes-table" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
                
            </div>

        </div>

    </div>

@endsection

@section('script')
<script>
    $(document).ready( function () {
        $('#notes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('notes.table') }}",
            columns: [
                { data: 'note_id' },
                { data: 'title' },
                { data: 'content' },
                { data: 'actions' }
            ]
        });
    });
</script>
@endsection