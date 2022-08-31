<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\NoteAttachment;
use Illuminate\Http\Request;
use Storage;

class NotesAttachmentController extends Controller
{
    public function download(NoteAttachment $noteAttachment){

        try {
            
            return Storage::download('attachments/'.$noteAttachment->path, $noteAttachment->filename);


        } catch (\Throwable $th) {
            abort(401);
        }

    }

    public function get(NoteAttachment $noteAttachment) {
        return response()->file(storage_path('app/attachments/'.$noteAttachment->path));
    }

    public function destroy(NoteAttachment $noteAttachment){
        Storage::delete('attachments/'.$noteAttachment->path);
        $noteAttachment->delete();

        return response()->json([
            'message'=> 'Attachment deleted',
            'status'=> 'Success'
        ], 200);
    }
}
