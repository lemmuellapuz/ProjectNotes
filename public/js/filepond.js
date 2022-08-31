FilePond.registerPlugin(
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType
);

$('#attachment').filepond({
    maxFileSize: '2MB',
    acceptedFileType: ['image/png', 'image/jpeg'],
    server: {
        process: '/notes/file/process',
        revert: '/notes/file/revert',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
});