<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3">Countries</h1>
    </div>
    <div class="row">
        <div class="mx-auto card">
            <div>
                @if (session()->has('country_message'))
                    <div class="alert alert-success">
                        {{ session('country_message') }}
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
                        <button wire:click="showCountryModal" class="btn btn-primary">
                            Create Country
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table"  wire:loading.remove >
                    <thead>
                    <tr>
                        <th scope="col">#Id     </th>
                        <th scope="col">Country_code</th>
                        <th scope="col">Name   </th>
                        <th scope="col">Manage  </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($countries as $country)
                        <tr>
                            <th scope="row">{{ $country->id }}</th>
                            <td>{{ $country->country_code }}</td>
                            <td>{{ $country->name }}</td>
                            <td>
                                <button wire:click="showEditModal({{$country->id}})"
                                        class="btn btn-success">Edit</button>
                                <button wire:click="deleteUser({{$country->id}})"
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
            {{ $countries->links() }}
        </div>
        <!-- Modal -->
        <div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    @if ($editMode)
                        <h5 class="modal-title" id="countryModalLabel">Edit Country</h5>
                        @else
                       <h5 class="modal-title" id="countryModalLabel">Create Country</h5>
                    @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="country_code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Country Code') }}</label>

                                <div class="col-md-6">
                                    <input id="country_code" type="text"
                                           class="form-control @error('name') is-invalid @enderror" wire:model.defer="country_code"
                                           value="{{ old('country_code') }}">

                                    @error('country_code')
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
                            <button type="button" class="btn btn-primary" wire:click="updateCountry()">Update Country</button>
                            @else
                            <button type="button" class="btn btn-primary" wire:click="storeCountry()">Store Country</button>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

