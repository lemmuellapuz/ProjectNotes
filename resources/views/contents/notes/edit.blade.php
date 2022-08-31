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

                @if(!$attachment)
                <div class="col-12">
                    <input type="file" name="attachment" id="attachment">
                </div>
                @endif

                <div class="col-auto">
                    <input type="submit" value="Update" class="btn btn-success">
                </div>

            </div>

        </form>

        @if($attachment)

            <div class="col-12">

                <h2>Attachment</h2>

                <div class="card my-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="m-3">
                            <img src="{{ route('file.get', ['noteAttachment' => $attachment]) }}" alt="" style="width:10%">
                            <a href="{{ route('file.download', ['noteAttachment' => $attachment]) }}">{{ $attachment->filename }}</a>
                        </div>

                        <div id="right">
                            <form id="form-destroy-attachment">
                                <button type="submit" class="btn btn-sm btn-danger m-3"> <span class="fas fa-times"></span> </button>
                            </form>
                            
                        </div>

                    </div>
                </div>
            </div>

        @endif

    </div>

@endsection

@section('script')

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="{{ asset('js/filepond.js') }}"></script>

<script>
    $('#form-destroy-attachment').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Delete attachment?',
            text: 'Are you sure you want to delete this attachment? You cannot undo changes.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((response)=>{

            if(response.isConfirmed) {

                let loading = Swal.fire({
                    title: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: ()=>{
                        Swal.showLoading();
                    }
                })

                $.ajax({
                    url: "{{ route('file.destroy', ['noteAttachment'=> $attachment==''? '#':$attachment ] ) }}",
                    method: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        '_method': 'DELETE'
                    },
                    success: function(ajaxResponse) {
                        
                        loading.close()

                        Swal.fire(
                            'Success',
                            'Attachment has been removed.',
                            'success'
                        ).then((res)=>{
                            if(res) {
                                window.location.reload();
                            }
                        })

                    }
                })

            }

        })
    })
</script>

@endsection