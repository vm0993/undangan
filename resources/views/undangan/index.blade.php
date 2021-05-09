@extends('layouts.master')

@section('head')
    @include('layouts.head')
@stop

@section('content')
    <h1 class="h3 mb-3">Daftar Undangan</h1>
    <div class="card flex-fill">
        <div class="card-header">
            <a data-bs-target="#modalForm" data-href="{{ url()->current() }}/1/tamu" data-bs-toggle="modal" class="btn btn-primary my-1" role="button" aria-pressed="true">Undangan Baru</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table dt-responsive nowrap my-0 dataUndangan">
                    <thead>
                        <tr>
                            <th width="20%">Nama Tamu</th>
                            <th width="33%">Title Acara</th>
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
