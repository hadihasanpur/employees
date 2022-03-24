<?php

namespace App\Http\Livewire;

use App\Models\Upload;
use Livewire\Component;
use Livewire\WithFileUploads;

class Uploads extends Component
{
    use WithFileUploads;
    public $title;
    public $filename;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'title' => 'required',
            'filename' => 'required'
        ]);
    }
    public function fileUpload()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'filename' => 'required'
        ]);

        $filename = $this->filename->store('files', 'public');
        $validatedData['filename'] = $filename;
        Upload::create($validatedData);
        session()->flash('message', 'File successfully uploaded');
        $this->emit('fileUploaded');
    }
    public function render()
    {
        $uploads = Upload::paginate(5);
       
        return view(
            'livewire.uploads',
            ['uploads' => $uploads]
        )
            ->layout('layouts.main');
    }

}
