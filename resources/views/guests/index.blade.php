@extends('layouts.master')

@section('head')
    @include('layouts.head')
@stop

@section('content')
    <h1 class="h3 mb-3">Daftar Undangan</h1>
    <div class="card flex-fill">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="download" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-upload"></i>
                        <span>Peserta</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="download">
                        <a href="#modalForm" data-href="{{ url()->current() }}/1/undangan" data-bs-toggle="modal" class="dropdown-item" role="button" aria-pressed="true">Tamu Baru</a>
                        <a href="#modalForm" data-href="{{ url()->current() }}/1/import" data-bs-toggle="modal" class="dropdown-item" aria-pressed="true">Upload Tamu/Peserta</a>
                        <a href="javascript:void(0);" onclick="undangTamu();" class="dropdown-item" aria-pressed="true">Undang Tamu/Peserta</a>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ asset('/uploads/contohFileUpload.xlsx') }}">Download format upload tamu</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table dt-responsive nowrap my-0 dataTamu">
                    <thead>
                        <tr>
                            <th width="20%">Nama Tamu</th>
                            <th width="33%">Alamat</th>
                            <th width="20%">No Telepon</th>
                            <th width="13%">Status</th>
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
        
        var table = $('.dataTamu').DataTable({
            processing:true,
            serverSide:true,
            bLengthChange :true,
            ajax: {
                url: uri
            },
            columns: [
                {data: 'gabungan', name: 'gabungan'},
                {data: 'address', name: 'address'},
                {data: 'phone', name: 'phone'},
                {data: 'status', name: 'status',className:'text-center'},
            ],
            order: [[0, 'asc']]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function undangTamu()
        {
            $.ajax({
                url :  uri + '/undang-tamu',
                type : 'get',
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                success : function(data) {
                    table.draw();
                    toastr.info('Seluruh Tamu sudah di undang', 'info', {timeOut: 5000});
                }
            });
        }
        
    </script>
    <script src="{{ asset('js/vimajs.js') }}"></script>
    @endpush
@stop
