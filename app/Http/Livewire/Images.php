<?php

namespace App\Http\Livewire;

use App\Models\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Images extends Component
{
    use WithFileUploads;
    public $images;

    public function uploadImages()
    {
        foreach ($this->images as $key => $image) {
            $this->images[$key] = $image->store('images', 'public');
        }
        $this->images = json_encode($this->images);
        Image::create(['filename' => $this->images]);
        session()->flash('message', 'Images successfully uploaded');
        $this->emit('imageUploaded');
    }
}
