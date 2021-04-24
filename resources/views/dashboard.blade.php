@extends('layouts.master')

@section('head')
	@include('layouts.head')
@stop

@section('content')
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3>Dashboard</h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            <div class="dropdown me-2 d-inline-block">
                <a class="btn btn-light bg-white shadow-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-display="static">
                    <i class="align-middle mt-n1" data-feather="calendar"></i> Today
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <h6 class="dropdown-header">Settings</h6>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
            <button class="btn btn-primary shadow-sm">
                <i class="align-middle" data-feather="filter">&nbsp;</i>
            </button>
            <button class="btn btn-primary shadow-sm">
                <i class="align-middle" data-feather="refresh-cw">&nbsp;</i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card illustration flex-fill">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">Welcome Back, {{ ucfirst(auth()->user()->name) }}!</h4>
                                <p class="mb-0">Digi Invitation Dashboard</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="{{ asset('images/customer-support.png') }}" alt="Customer Support" class="img-fluid illustration-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">24.300</h3>
                            <p class="mb-2">Jumlah Tamu Undangan</p>
                            <div class="mb-0">
                                <span class="badge badge-soft-success me-2"> <i class="mdi mdi-arrow-bottom-right"></i> +5.35% </span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i class="align-middle text-success" data-feather="aperture"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">43</h3>
                            <p class="mb-2">Belum Datang</p>
                            <div class="mb-0">
                                <span class="badge badge-soft-danger me-2"> <i class="mdi mdi-arrow-bottom-right"></i> -4.25% </span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i class="align-middle text-danger" data-feather="cloud-lightning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">18.700</h3>
                            <p class="mb-2">Sudah Datang</p>
                            <div class="mb-0">
                                <span class="badge badge-soft-success me-2"> <i class="mdi mdi-arrow-bottom-right"></i> +8.65% </span>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i class="align-middle text-info" data-feather="camera"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card flex-fill">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Undangan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table dt-responsive nowrap my-0 dataUndangan">
                    <thead>
                        <tr>
                            <th width="20%">Nama Tamu</th>
                            <th width="33%">Title Acara</th>
                            <th width="20%">Konfirmasi</th>
                            <th width="13%">Status</th>
                            <th width="12%" class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('partials.modals.template')
@stop

@section('footer')
    @include('layouts.foot-js')
    @push('scripts')
    <script type="text/javascript">
        var uri = "{{ url()->current() }}";
        
        var table = $('.dataUndangan').DataTable({
            processing:true,
            serverSide:true,
            bLengthChange :true,
            ajax: {
                url: uri
            },
            columns: [
                {data: 'gabungan', name: 'gabungan'},
                {data: 'judulundangan', name: 'judulundangan'},
                {data: 'konfirmasi', name: 'konfirmasi'},
                {data: 'status', name: 'status',className:'text-center'},
                {data: 'action', name: 'action',className:'text-center',orderable: false, searchable: false},
            ],
            order: [[0, 'asc']]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
    </script>
    <script src="{{ asset('js/vimajs.js') }}"></script>
    @endpush
@stop