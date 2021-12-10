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


    public function showEditModal($id)
    {
        $this->reset();
        $this->countryId=$id;
        $this->loadCountries();
        $this->editMode=true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#countryModal', 'actionModal' => 'show']);    
    }
    public function loadCountries()
    {
        $country = Country::find($this->countryId);
        $this->country_code = $country->country_code;
        $this->country_code = $country->name;

    }
    public function showCountryModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#countryModal', 'actionModal' => 'show']);
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#countrymodal', 'actionModal' => 'hide']);
    }

    public function deleteMode($id)
    {
        //code
    }
    
    
    public function updateCountry()
    {
    }
    public function storecountry()
    {
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
