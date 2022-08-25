@extends('layouts.app')

@section('content')

    <div class="container mt-3">

        <div class="row">

            @include('components.alerts')

            <div class="col-auto">
                <a href="{{ route('notes.create') }}" class="btn btn-primary">Add note</a>
            </div>

            <div class="col-auto">
                <a onclick="scanQr()" class="btn btn-primary">Search via QR</a>
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

    @include('components.modals.qr_generate_modal')
    @include('components.modals.qr_scan_modal')

@endsection

@section('script')
<!-- DATATABLES -->
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

<!-- SHOW QR CODE -->
<script>

    function showQr(qr) {
        $('#qr-generate-modal').modal('show');

        var qrcode = new QRCode(document.getElementById('qr-code'), {
            text: qr,
            width: 256,
            height: 256,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H,
            logo: '/images/logo.png',
            logoWidth: 50,
            logoHeight: 50,
            onRenderingEnd: function(qrCodeOptions, dataUrl) {
                $('#qr-download-btn').attr('href', dataUrl);
            }
        });
    }

    $('#qr-generate-modal').on('hidden.bs.modal', function(){
        $('#qr-code').empty();
    })

   
</script>

<!-- SCAN QR CODE -->
<script>

    const html5QrCode = new Html5Qrcode("reader");
    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        
        html5QrCode.stop().then((ignore) => {

            let loading = Swal.fire({
                title: 'Searching data',
                text: 'This may take a while. Please wait.',
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: '/notes/search-qr',
                method: "POST",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'qr': decodedText
                },
                success: function(response) {

                    loading.close();
                    window.location.replace('/notes/'+response.data)

                },
                error: function(response) {
                    
                    loading.close();
                    $('#qr-scan-modal').modal('hide');

                    Swal.fire({
                        title: response.responseJSON.status,
                        text: response.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });

                }
            })
        })

    };
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    function scanQr() {
        $('#qr-scan-modal').modal('show');

        html5QrCode.start({ facingMode: { exact: "environment"} }, config, qrCodeSuccessCallback).catch(() => {
            html5QrCode.start({ facingMode: { exact: "user"} }, config, qrCodeSuccessCallback).catch((err) => {
                alert('No camera found');
            })
        });
    }

    $('#qr-scan-modal').on('hidden.bs.modal', function() {
        html5QrCode.stop();
    })

</script>
@endsection