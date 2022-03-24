<div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            File Upload
                        </div>
                        <div class="card-body">
                            <form id="form-upload" wire:submit.prevent="fileUpload" enctype="multipart/form-data">
                                <div class="form-group">
                                    <lable for="title">Ttile</lable>
                                    <input type="text" name="title" class="form-control" wire:model="title" />
                                    @error('title') <p class="text-danger">{{$message}}</p> @enderror
                                </div>

                                <div class="form-group">
                                    <lable for="filename">File</lable>
                                    <input type="file" name="filename" class="form-control" wire:model="filename" multiple / >
                                    @error('filename') <p class="text-danger">{{$message}}</p> @enderror
                                </div>

                                <button type="submit" class="btn btn-success">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table"  wire:loading.remove >
                    <thead>
                    <tr>
                        <th scope="col">#Id     </th>
                        <th scope="col">filename</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- @forelse ($countries as $country) --}}
                        <tr>
                            {{-- <th scope="row">{{ $country->id }}</th> --}}
                            {{-- <td>{{ $country->country_code }}</td> --}}
                            {{-- <td>{{ $country->name }}</td> --}}
                            <td>
                                {{-- <button wire:click="showEditModal({{$country->id}})"
                                        class="btn btn-success">Edit</button>
                                <button wire:click="deleteCountry({{$country->id}})"
                                        class="btn btn-danger">Delete</button> --}}
                            </td>
                        </tr>
                        {{-- @empty --}}
                        <tr>
                            <th> No results</th>
                        </tr>
                    {{-- @endforelse --}}

                    </tbody>
                </table>
    </section>
</div>