<form action="{{route('user-password.update')}}" method="post">
    @csrf
    @method('put')
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="current-password">Password Aktif</label>
                <input type="password" name="current_password" id="current_password" class="form-control  @error('current_password') is_invalid @enderror">
                @error('current_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                @error('password_confirmation')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="reset" class="btn btn-dark">Reset</button>
            <button class="btn btn-primary">Simpan</button>
        </div>
        </div>
    </div>
</form>
