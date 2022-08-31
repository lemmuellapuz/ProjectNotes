<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notes\CreateNoteRequest;
use App\Http\Requests\Notes\SearchQrRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Models\Note;
use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Carbon;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class NotesController extends Controller
{

    public function index()
    {
        return view('contents.notes.dashboard');
    }

    public function table() 
    {
        $notes = Note::where('user_id', Auth::user()->id);

        return DataTables::of($notes)
        ->addColumn('note_id', function($row){
            return $row->id;
        })
        ->addColumn('actions', function($row){

            $showqr_btn = '<a onclick="showQr(\''.$row->qr_code.'\')" class="btn btn-primary">Show Qr</a>';

            $update_btn = '<a href="'. route('notes.edit', ['note' => $row]) .'" class="btn btn-secondary">Edit</a>';
            
            $delete_btn = '
                <form action="'. route('notes.destroy', ['note' => $row]) .'" method="POST">
                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            ';

            return $update_btn . $showqr_btn . $delete_btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function create()
    {
        return view('contents.notes.create');
    }

    public function store(CreateNoteRequest $request)
    {
        try {

            $lastId = Note::orderBy('created_at', 'DESC')->limit(1)->first();

            if($lastId) $lastId = $lastId->id;
            else $lastId = 1;

            $qr_code = base64_encode(uniqid($lastId, true));
            
            $note = Auth::user()->notes()->create([
                'qr_code' => $qr_code,
                'title' => $request->title,
                'content' => $request->content
            ]);

            $this->storeAttachment($request, $note);
    
            return redirect()->route('notes.index')->with('success', 'Note added');
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show(Note $note)
    {
        return view('contents.notes.show')->with('note', $note);
    }

    public function searchQr(SearchQrRequest $request) {
        
        try {

            $note = Note::where('qr_code', $request->qr)->first();

            if ($note) {
                return [
                    'data' => $note->id,
                    'status' => 'Success'
                ];
            }

            return response()->json([
                'message' => 'Data not found!',
                'status' => 'Error'
            ], 500);
            

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'Error'
            ], 500);
        }

    }

    public function edit(Note $note)
    {   

        $attachment = $note->attachment()->first();

        return view('contents.notes.edit', compact(['note', 'attachment']));
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        try {

            $note->update([
                'title' => $request->title,
                'content' => $request->content
            ]);

            $this->storeAttachment($request, $note);
    
            return redirect()->back()->with('success', 'Note updated.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Note $note)
    {
        try {

            $note->delete();

            return redirect()->back()->with('success', 'Note deleted.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    private function storeAttachment($request, $note){
        
        if($request->attachment) {

            $attachment = TemporaryFile::where('path', $request->attachment)->first();

            $path = $attachment->path;
            $filename = $attachment->filename;
            $extension = $attachment->extension;

            $new_filename = Uuid::uuid4() . '.' . $extension;

            Storage::move('temp/'.$path.'/'.$filename, 'attachments/'.$new_filename);
            Storage::deleteDirectory('temp/'.$path);

            $attachment->delete();

            $note->attachment()->create([
                'filename' => $filename,
                'path' => $new_filename
            ]);

        }

    }
}
