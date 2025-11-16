<form  method="PUT" id="editUserForm">
    @csrf
    <input type="hidden" id="editUserId" value="{{ $user->id }}">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" value="{{ $user->phone }}" class="form-control" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Company</label>
            <input type="text" class="form-control" name="company" value="{{ $user->compyany }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
        <div class="col-md-6 mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-end">
        <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
