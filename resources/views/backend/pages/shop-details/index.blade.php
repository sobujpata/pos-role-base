@extends('backend.layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-4">
                <div class="breadcrumb-title pe-3">Shop Details</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shop Information</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if (session('success'))
                <div class="alert border-0 bg-success-subtle text-success px-3 py-2 mb-4 rounded-3">
                    <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert border-0 bg-danger-subtle text-danger px-3 py-2 mb-4 rounded-3">
                    <i class="bx bx-x-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('shop-details.update', ['shop' => $shop?->id ?? 1]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm overflow-hidden">
                            <div class="card-body p-4 text-center">
                                <div class="position-relative d-inline-block mb-3">
                                    <img id="logoPreview" 
                                        src="{{ $shop && $shop->logo ? asset('storage/' . $shop->logo) : asset('assets/images/logo-placeholder.png') }}"
                                        alt="Shop Logo"
                                        class="rounded border border-4 border-light shadow" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <h4 class="mb-1">{{ $shop->shop_name ?? 'Shop Name' }}</h4>
                                <p class="text-muted mb-3">{{ $shop->logo_text ?? 'Shop Logo Text' }}</p>
                                <div class="d-grid gap-2">
                                    <label for="logo" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-image me-1"></i> Change Logo
                                    </label>
                                    <input type="file" id="logo" name="logo" class="d-none" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div>
                                        <h5 class="mb-1">Shop Information</h5>
                                        <p class="text-muted mb-0">Update your shop details and branding</p>
                                    </div>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Active</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="shop_name" class="form-label">Shop Name</label>
                                        <input type="text" name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" id="shop_name" value="{{ old('shop_name', $shop->shop_name ?? '') }}" required>
                                        @error('shop_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="logo_text" class="form-label">Logo Text</label>
                                        <input type="text" name="logo_text" class="form-control @error('logo_text') is-invalid @enderror" id="logo_text" value="{{ old('logo_text', $shop->logo_text ?? '') }}" required>
                                        @error('logo_text')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="shop_email" class="form-label">Shop Email</label>
                                        <input type="email" name="shop_email" class="form-control @error('shop_email') is-invalid @enderror" id="shop_email" value="{{ old('shop_email', $shop->shop_email ?? '') }}">
                                        @error('shop_email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="shop_phone" class="form-label">Shop Phone</label>
                                        <input type="tel" name="shop_phone" class="form-control @error('shop_phone') is-invalid @enderror" id="shop_phone" value="{{ old('shop_phone', $shop->shop_phone ?? '') }}">
                                        @error('shop_phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="shop_address" class="form-label">Shop Address</label>
                                        <textarea name="shop_address" class="form-control @error('shop_address') is-invalid @enderror" id="shop_address" rows="3">{{ old('shop_address', $shop->shop_address ?? '') }}</textarea>
                                        @error('shop_address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="logo" class="form-label">Shop Logo</label>
                                        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" id="logo" accept="image/*">
                                        <small class="text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                                        @error('logo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bx bx-trash me-1"></i> Delete Shop
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="bx bx-save me-1"></i> Update Shop Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel">
                        <i class="bx bx-error-circle me-2"></i> Delete Shop Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this shop? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('shop-details.destroy', ['shop' => $shop?->id ?? 1]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('logoPreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
