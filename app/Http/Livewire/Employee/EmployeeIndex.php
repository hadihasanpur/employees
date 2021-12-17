<?php

namespace App\Http\Livewire\Employee;

use App\Models\Employee;

use Livewire\Component;
use Livewire\WithPagination;


class EmployeeIndex extends Component
{
    public $search = '';
    public $countryId;
    public $name;
    public $editMode = false;
    public $employeeId;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'countryId'  => 'required',
        'name'          => 'required',
    ];

    public function loadEmployee()
    {
        $employee = Employee::find($this->employeeId);
        $this->countryId = $employee->country_id;
        $this->name = $employee->name;
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
            'country_id'  => $this->countryId,
            'name' => $this->name,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#employeeModal', 'actionModal' => 'hide']);
        session()->flash('employee_message', 'A employee successfully created.');
    }

    public function updateEmployee()
    {
        $validated = $this->validate([
            'countryId'  => 'required',
            'name' => 'required',
        ]);
        $employee = Employee::find($this->employeeId);
        $employee->update($validated);
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
        $states = Employee::paginate(5);
        if (strlen($this->search) > 2) {

            $employees = Employee::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.employee.employee-index',[
            'employees'=> $employees

        ])->layout('layouts.main');
    }
}
