<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Citys</h1>
    </div>
    <div class="row">
        <div class="mx-auto card">
            <div>
                @if (session()->has('city_message'))
                    <div class="alert alert-success">
                        {{ session('city_message') }}
                    </div>
                @endif
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <form>
                            <div class="form-row align-items-center">
                                <div class="col">
                                    <input type="search" wire:model.defer="search" class="mb-2 form-control" id="inlineFormInput"
                                           placeholder="Jane Doe">
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
                        <button wire:click="showCityModal" class="btn btn-primary">
                            Create City
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table"  wire:loading.remove >
                    <thead>
                    <tr>
                        <th scope="col">#Id     </th>
                        <th scope="col">Country</th>
                        <th scope="col">Name   </th>
                        <th scope="col">Manage  </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($cities as $city)
                        <tr>
                            <th scope="row">{{ $city->id }}</th>
                            <td>{{ $city->state->name }}</td>
                            <td>{{ $city->name }}</td>
                            <td>
                                <button wire:click="showEditModal({{$city->id}})"
                                        class="btn btn-success">Edit</button>
                                <button wire:click="deleteCity({{$city->id}})"
                                        class="btn btn-danger">Delete</button>
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
            {{ $cities->links() }}
        </div>
        <!-- Modal -->
        <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class ="modal-content">
                    <div class="modal-header">
                        @if ($editMode)
                            <h5 class="modal-title" id="cityModalLabel">Edit City</h5>
                        @else
                            <h5 class="modal-title" id="cityModalLabel">Create City</h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="stateId"
                                       class="col-md-4 col-form-label text-md-right">{{ __('State Code') }}</label>

                                <div class="col-md-6">
                                    <select wire:model.defer="stateId" class="custom-select custom-select-lg mb-3">
                                        <option selected>choose</option>
                                        @foreach(\App\Models\State::all() as $state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('stateId')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

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
                            <button type="button" class="btn btn-primary" wire:click="updateCity()">Update Country</button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="storeCity()">Store Country</button>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

