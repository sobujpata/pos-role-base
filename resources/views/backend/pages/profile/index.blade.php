@extends('backend.layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-4">
                <div class="breadcrumb-title pe-3">Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert border-0 bg-success-subtle text-success px-3 py-2 mb-4 rounded-3">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm overflow-hidden">
                            <div class="card-body p-4 text-center">
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="{{ $user->profile && $user->profile->image ? asset('storage/' . $user->profile->image) : asset('assets/images/avatars/avatar-2.png') }}"
                                        alt="Profile image"
                                        class="rounded-circle border border-4 border-white shadow" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-3">{{ $user->email }}</p>
                                <div class="d-grid gap-2">
                                    <label for="image" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-camera me-1"></i> Change Photo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div>
                                        <h5 class="mb-1">Profile Information</h5>
                                        <p class="text-muted mb-0">Update your personal information and password</p>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">Active</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                                        @error('phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="nid_no" class="form-label">NID Number</label>
                                        <input type="text" name="nid_no" class="form-control @error('nid_no') is-invalid @enderror" id="nid_no" value="{{ old('nid_no', $user->profile->nid_no ?? '') }}">
                                        @error('nid_no')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="3">{{ old('address', $user->profile->address ?? '') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="image" class="form-label">Profile Image</label>
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" autocomplete="new-password">
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bx bx-save me-1"></i> Update Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
