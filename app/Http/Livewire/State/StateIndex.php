<?php

namespace App\Http\Livewire\State;

use App\Models\State;

use Livewire\Component;
use Livewire\WithPagination;


class StateIndex extends Component
{
    public $search = '';
    public $countryId;
    public $name;
    public $editMode = false;
    public $stateId;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    protected $rules = [
        'countryId'  => 'required',
        'name'          => 'required',
    ];

    public function loadStates()
    {
        $state = State::find($this->stateId);
        $this->countryId = $state->country_id;
        $this->name = $state->name;
    }

    public function showEditModal($id)
    {
        $this->reset();
        $this->stateId=$id;
        $this->loadStates();
        $this->editMode=true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#stateModal', 'actionModal' => 'show']);
    }

    public function showstateModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#stateModal', 'actionModal' => 'show']);
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#stateModal', 'actionModal' => 'hide']);
    }

    public function storeState()
    {
        $this->validate();
        State::create([
            'country_id'  => $this->countryId,
            'name'=> $this->name,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId'=>'#stateModal','actionModal'=>'hide']);
        session()->flash('state_message', 'A state successfully created.');
    }

    public function updateState()
    {
        $validated = $this->validate([
            'countryId'  => 'required',
            'name' => 'required',
        ]);
        $state=State::find($this->stateId);
        $state->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#stateModal', 'actionModal' => 'hide']);
        session()->flash('state_message', 'State successfully updated.');
    }

    public function deleteState($id)
    {
        $state = State::find($id);
        $state->delete();
        session()->flash('state_message', 'State successfully deleted.');
    }



    public function render()
    {
        $states = State::paginate(5);
        if (strlen($this->search) > 2) {

            $states = State::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.State.State-index',
            ['states' => $states])
            ->layout('layouts.main');
    }

}
