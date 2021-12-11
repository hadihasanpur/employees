<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class CountryIndex extends Component
{
    public $search = '';
    public $country_code;
    public $name;
    public $editMode = false;
    public $countryId;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    protected $rules = [
        'country_code'  => 'required',
        'name'          => 'required',
    ];
    public function showEditModal($id)
    {
        $this->reset();
        $this->countryId=$id;
        $this->loadCountries();
        $this->editMode=true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#countryModal', 'actionModal' => 'show']);    
    }
    public function showCountryModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#countryModal', 'actionModal' => 'show']);
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#countryModal', 'actionModal' => 'hide']);
    }

    public function storeCountry()
    {
        $this->validate();
        Country::create([
            'country_code'  => $this->country_code,
            'name'=> $this->name,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId'=>'#countryModal','actionModal'=>'hide']);
        session()->flash('country_message', 'A country successfully created.');
    }

    public function updateCountry()
    {
        $validated = $this->validate([
            'country_code'  => 'required',
            'name' => 'required',
        ]);
        $country=Country::find($this->countryId);
        $country->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#countryModal', 'actionModal' => 'hide']);
        session()->flash('country_message', 'Country successfully updated.');
    }

    public function deleteCountry($id)
    {
        $country = Country::find($id);
        $country->delete();
        session()->flash('country_message', 'country successfully deleted.');
    }

    public function loadCountries()
    {
        $country = Country::find($this->countryId);
        $this->country_code = $country->country_code;
        $this->name = $country->name;
    }

    public function render()
    {
        $countries = Country::paginate(5);
        if (strlen($this->search) > 2) {

            $countries = Country::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.country.Country-index',
        ['countries' => $countries])
        ->layout('layouts.main');
    }

}
