@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- start-content -->

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Size Table</li>
                        </ol>
                    </nav>
                </div>
                {{-- @dd('fgdgd') --}}
                @can('color-create')
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="{{ route('sizes.create') }}" class="btn btn-primary">Create size</a>
                        </div>
                    </div>
                @endcan
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">size List</h6>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">Home page popup</h4>
                        </div>
                        <div class="card-body">
                            <img src="" alt="Home Page Popup" id="showImage" class="" style="transform: none; width:100px;">
                            <h3 id="title_popup"></h3>
                            <p id="short_des_popup"></p>
                        </div>
                        <div class="card-footer">
                            {{-- <a href="#" class="btn btn-primary float-end">Edit</a> --}}
                            <button class="btn btn-primary float-end popUpEditBtn" data-id="" data-title="" data-short_des="" data-image="" id="popupEdit">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end-content -->
        </div>
    </div>
    <!-- popup edit model -->
    @include('backend.pages.settings.popup-edit')
@endsection
@push('script')
    <script>
        (async () => {
            try {
                let res = await axios.get('/popup-show');
                // console.log(res.data);
                if (res.status == 200) {
                    if (res.data != '') {
                        document.getElementById('showImage').src = 'storage/' + res.data.image;
                        document.getElementById('title_popup').innerHTML = res.data.title;
                        document.getElementById('short_des_popup').innerHTML = res.data.short_des;
                        document.getElementById('popupEdit').setAttribute('data-id', res.data.id);
                        document.getElementById('popupEdit').setAttribute('data-title', res.data.title);
                        document.getElementById('popupEdit').setAttribute('data-short_des', res.data.short_des);
                        document.getElementById('popupEdit').setAttribute('data-image', res.data.image);
                    }
                }   
            } catch (error) {
                console.log(error);
            }
        })()

    </script>
@endpush