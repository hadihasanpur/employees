<?php

namespace App\Http\Livewire\City;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\City;


class CityIndex extends Component
{
    public $search = '';
    public $stateId;
    public $name;
    public $editMode = false;
    public $cityId;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'stateId'       => 'required',
        'name'          => 'required',
    ];

    public function loadCity()
    {
        $city = City::find($this->stateId);
        $this->stateId = $city->state_id;
        $this->name = $city->name;
    }

    public function showEditModal($id)
    {
        $this->reset();
        $this->cityId=$id;
        $this->loadcity();
        $this->editMode=true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'show']);
    }

    public function showCityModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'show']);
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'hide']);
    }

    public function storeCity()
    {
        $this->validate();
        City::create([
            'state_id'   => $this->stateId,
            'name'       => $this->name   ,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId'=>'#cityModal','actionModal'=>'hide']);
        session()->flash('city_message', 'A city successfully created.');
    }

    public function updateCity()
    {
        $validated = $this->validate([
            'stateId'  => 'required',
            'name'     => 'required',
        ]);
        $city=City::find($this->cityId);
        $city->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#cityModal', 'actionModal' => 'hide']);
        session()->flash('city_message', 'City successfully updated.');
    }

    public function deleteState($id)
    {
        $state = City::find($id);
        $state->delete();
        session()->flash('city_message', 'City successfully deleted.');
    }
    public function render()
    {
        $cities = City::paginate(5);
        if (strlen($this->search) > 2) {

            $cities = City::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.City.city-index',[
            'cities'=>$cities
        ])->layout('layouts.main');
    }
}
