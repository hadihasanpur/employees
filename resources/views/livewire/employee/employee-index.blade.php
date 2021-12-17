<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Employee</h1>
    </div>
    <div class="row">
        <div class="mx-auto card">
            <div>
                @if (session()->has('employee_message'))
                <div class="alert alert-success">
                    {{ session('employee_message') }}
                </div>
                @endif
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <form>
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="search" wire:model.defer="search" class="mb-2 form-control"
                                        id="inlineFormInput" placeholder="Jane Doe">
                                </div>
                                <div class="col" wire:loading>
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <!-- Button trigger modal -->
                        <button wire:click="showEmployeeModal" class="btn btn-primary">
                            Create Employee
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table" wire:loading.remove>
                    <thead>
                        <tr>
                            <th scope="col">#Id </th>
                            <th scope="col">Country</th>
                            <th scope="col">Name </th>
                            <th scope="col">Manage </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                        <tr>
                            <th scope="row">{{ $employee->id }}</th>
                            <td>{{ $employee->country->name }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>
                                <button wire:click="showEditModal({{$employee->id}})" class="btn btn-success">Edit</button>
                                <button wire:click="deleteState({{$employee->id}})" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <th> No results</th>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            {{ $employees->links() }}
        </div>
        <!-- Modal -->
        <div class="modal fade" id="stateModal" tabindex="-1" aria-labelledby="stateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($editMode)
                        <h5 class="modal-title" id="stateModalLabel">Edit Employee</h5>
                        @else
                        <h5 class="modal-title" id="stateModalLabel">Create Employee</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="countryId" class="col-md-4 col-form-label text-md-right">{{ __('Employee Code')
                                    }}</label>

                                <div class="col-md-6">
                                    <select wire:model.defer="countryId" class="custom-select custom-select-lg mb-3">
                                        <option selected>choose</option>
                                        @foreach(\App\Models\Country::all() as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('countryId')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" wire:model.defer="name"
                                        value="{{ old('name') }}">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        @if($editMode)
                        <button type="button" class="btn btn-primary" wire:click="updateState()">Update Country</button>
                        @else
                        <button type="button" class="btn btn-primary" wire:click="storeState()">Store Country</button>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>