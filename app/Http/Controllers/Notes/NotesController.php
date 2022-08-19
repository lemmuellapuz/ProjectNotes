<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notes\CreateNoteRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

            $update_btn = '<a href="'. route('notes.edit', ['note' => $row]) .'" class="btn btn-secondary">Edit</a>';

            $delete_btn = '
                <form action="'. route('notes.destroy', ['note' => $row]) .'" method="POST">
                    '.csrf_field().'
                    '.method_field("DELETE").'
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            ';

            return $update_btn . $delete_btn;
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
            
            Auth::user()->notes()->create([
                'title' => $request->title,
                'content' => $request->content
            ]);
    
            return redirect()->route('notes.index')->with('success', 'Note added');
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Note $note)
    {
        return view('contents.notes.edit')->with('note', $note);
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        try {

            $note->update([
                'title' => $request->title,
                'content' => $request->content
            ]);
    
            return redirect()->route('notes.index')->with('success', 'Note updated.');

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
}
