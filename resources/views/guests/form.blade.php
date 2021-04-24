@if(!$tamu->id)
{!! Form::open(['id'=>'frm']) !!}
@else
{!! Form::model($tamu,['method'=>'put','id'=>'frm']) !!}
@endif
    <div class="modal-header">
        <h5 class="modal-title">{{!$tamu->id ? $title : $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body m-2">
        <div class="row">
            <div class="col-md-12">
                <div class="form-floating">
                    {{ Form::text('name',null, ['id'=>'name', 'class'=>'form-control','placeholder'=>'Nama Tamu/Peserta Undangan'] ) }}
                    <label for="name">Nama</label>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="form-floating">
                    {{ Form::text('alamat1',null, ['id'=>'alamat1', 'class'=>'form-control','placeholder'=>'Alamat'] ) }}
                    <label for="alamat1">Alamat 1</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-floating">
                    {{ Form::text('alamat2',null, ['id'=>'alamat2', 'class'=>'form-control','placeholder'=>'Alamat'] ) }}
                    <label for="alamat2">Alamat 2</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-floating">
                    {{ Form::text('alamat3',null, ['id'=>'alamat3', 'class'=>'form-control','placeholder'=>'Alamat'] ) }}
                    <label for="alamat3">Alamat 3</label>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('no_telp',null, ['id'=>'no_telp', 'class'=>'form-control','placeholder'=>'0813 xxxx xxxx'] ) }}
                    <label for="no_telp">No Telepon</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('email',null, ['id'=>'email', 'class'=>'form-control','placeholder'=>'name@example.com'] ) }}
                    <label for="email">Email</label>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="form-floating">
                    {{ Form::text('keterangan',null, ['id'=>'keterangan', 'class'=>'form-control','placeholder'=>'Keterangan lainnya'] ) }}
                    <label for="keterangan">Keterangan</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Tutup</button>
        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Simpan Data</button>
    </div>
{!! Form::close() !!}