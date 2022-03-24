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
                            Upload Images
                        </div>
                        <div class="card-body">
                            <form id="form-upload" wire:submit.prevent="uploadImages" enctype="multipart/form-data">
                                <div class="form-group">
                                    <lable for="images">File</lable>
                                    <input type="file" name="images" class="form-control" wire:model="images"
                                        multiple />
                                </div>

                                <button type="submit" class="btn btn-success">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>