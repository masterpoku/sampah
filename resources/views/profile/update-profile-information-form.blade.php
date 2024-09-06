<form action="{{ route('user-profile-information.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <div class="card-body">
                    @if (Storage::disk('public')->exists(auth()->user()->profile_photo_path))
                     <img src="{{ url('storage',auth()->user()->profile_photo_path ?? '') }}" alt="" class="img-thumbnail preview-path_image mb-2" width="300">
                    @else
                    <img src="{{ asset('template/dist/img/user1-128x128.jpg') }}" alt="" class="img-thumbnail preview-path_image mb-2" width="300">
                    @endif
                     <div class="custom-file">
                        <input type="file" class="custom-file-input" id="profile_photo_path" name="profile_photo_path"
                            onchange="preview('.preview-path_image', this.files[0])">
                        <label class="custom-file-label" for="profile_photo_path">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Update Data</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                    value="{{ old('name') ?? auth()->user()->name }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                             <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" readonly
                                    value="{{ old('email') ?? auth()->user()->email }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
