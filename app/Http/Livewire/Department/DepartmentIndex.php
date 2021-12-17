<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Department;



class DepartmentIndex extends Component
{

    public $search = '';
    public $name;
    public $editMode = false;
    public $departmentId;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name'          => 'required',
    ];

    public function loaddepartment()
    {
        $department = Department::find($this->departmentId);//////
        $this->name = $department->name;
    }

    public function showEditModal($id)
    {
        $this->reset();
        $this->departmentId = $id;

        $this->loaddepartment();
        $this->editMode = true;
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departmentModal', 'actionModal' => 'show']);
    }

    public function showDepartmentModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departmentModal', 'actionModal' => 'show']);
    }

    public function closeModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departmentModal', 'actionModal' => 'hide']);
    }

    public function storeDepartment()
    {
        $this->validate();
        Department::create([
            'name'       => $this->name,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departmentModal', 'actionModal' => 'hide']);
        session()->flash('department_message', 'A department successfully created.');
    }

    public function updateDepartment()
    {
        $validated = $this->validate([
            'departmentId'  => 'required',
            'name'     => 'required',
        ]);
        $department = Department::find($this->departmentId);
        $department->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#departmentModal', 'actionModal' => 'hide']);
        session()->flash('department_message', 'Department successfully updated.');
    }

    public function deleteDepartments($id)
    {
        $department = Department::find($id);
        $department->delete();
        session()->flash('department_message', 'Department successfully deleted.');
    }
    public function render()
    {
        $department=Department::paginate();
        if (strlen($this->search) > 2) {

            $states = Department::where('name', 'like', "%{$this->search}%")->paginate(5);
        }

        return view('livewire.department.department-index',[
            'departments'=> $department
        ])->layout('layouts.main');
    }
}
