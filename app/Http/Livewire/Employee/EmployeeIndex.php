<?php

namespace App\Http\Livewire\Employee;

use App\Models\Employee;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;


class EmployeeIndex extends Component
{
    public $search = '';
    public $lastName;
    public $firstName;
    public $middleName;
    public $address;
    public $countryId;
    public $employeeId;
    public $departmentId;
    public $stateId;
    public $cityId;
    public $zipCode;
    public $birthDate;
    public $dateHired;
    public $editMode = false;
    
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
    'lastName' => 'required',
    'firstName' => 'required',
    'middleName' => 'required',
    'address' => 'required',
    'departmentId' => 'required',
    'countryId' => 'required',
    'stateId' => 'required',
    'cityId' => 'required',
    'zipCode' => 'required',
    'birthDate' => 'required',
    'dateHired' => 'required',
    ];

    public function loadEmployee()
    {
        $employee = Employee::find($this->employeeId);
        $this->lastName = $employee->last_name;
        $this->firstName = $employee->first_name;
        $this->middleName = $employee->middle_name;
        $this->address = $employee->address;
        $this->departmentId = $employee->department_id;
        $this->countryId = $employee->country_id;
        $this->stateId = $employee->state_id;
        $this->cityId = $employee->city_id;
        $this->zipCode = $employee->zip_code;
        $this->birthDate = $employee->birthdate;
        $this->dateHired = $employee->date_hired;
        }

    public function showEditModal($id)
    {
        $this->reset();
        $this->employeeId = $id;
        $this->loadEmployee();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }

    public function showEmployeeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'show']);
    }
    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
    }
    
    public function storeEmployee()
    {
        $this->validate();
        Employee::create([
            'last_name' => $this->lastName,
            'first_name' => $this->firstName,
            'middle_name' => $this->middleName,
            'address' => $this->address,
            'country_id' => $this->countryId,
            'department_id' => $this->departmentId,
            'state_id' => $this->stateId,
            'city_id' => $this->cityId,
            'zip_code' => $this->zipCode,
            'birthdate' => Carbon::parse($this->birthDate)->format('Y-m-d H:i:s'),
            'date_hired' => Carbon::parse($this->dateHired)->format('Y-m-d H:i:s'),
        
            ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('employee_message', 'A employee successfully created.');
    }

    public function updateEmployee()
    {
        $this->validate();
                $employee = Employee::find($this->employeeId);

    
        $employee->update([
            'last_name' => $this->lastName,
            'first_name' => $this->firstName,
            'middle_name' => $this->middleName,
            'address' => $this->address,
            'country_id' => $this->countryId,
            'department_id' => $this->departmentId,
            'state_id' => $this->stateId,
            'city_id' => $this->cityId,
            'zip_code' => $this->zipCode,
            'birthdate' => Carbon::parse($this->birthDate)->format('Y-m-d H:i:s'),
            'date_hired' => Carbon::parse($this->dateHired)->format('Y-m-d H:i:s'),
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('employee_message', 'Employee successfully updated.');
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        session()->flash('employee_message', 'Employee successfully deleted.');
    }
    public function render()
    {
        $employees = Employee::paginate(5);
        if (strlen($this->search) > 2) {

            $employees = Employee::where('first_name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.employee.employee-index',[
            'employees'=> $employees
        ])->layout('layouts.main');
    }
}
