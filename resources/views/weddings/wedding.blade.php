@if(!$invite->id)
{!! Form::open(['id'=>'frm']) !!}
@else
{!! Form::model($invite,['method'=>'put','id'=>'frm']) !!}
@endif
    <div class="modal-header">
        <h5 class="modal-title">{{!$invite->id ? $title : $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body m-2">
        <div class="row">
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('pengantin_pria',null, ['id'=>'pengantin_pria', 'class'=>'form-control','placeholder'=>'Pengantin Pria'] ) }}
                    <label for="pengantin_pria">Pengantin Pria</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    {{ Form::text('pengantin_wanita',null, ['id'=>'pengantin_wanita', 'class'=>'form-control','placeholder'=>'Pengantin Wanita'] ) }}
                    <label for="pengantin_wanita">Pengantin Wanita</label>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-4">
                <div class="form-floating">
                    {{ Form::date('wedding_date',null, ['id'=>'wedding_date', 'class'=>'form-control','placeholder'=>'Tangggal Undangan'] ) }}
                    <label for="wedding_date">Tanggal Acara</label>
                </div>
            </div>
            
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="form-floating">
                    {{ Form::text('wedding_theme',null, ['id'=>'wedding_theme', 'class'=>'form-control','placeholder'=>'Tema Acara'] ) }}
                    <label for="wedding_theme">Tema Acara</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Tutup</button>
        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Simpan</button>
    </div>
{!! Form::close() !!}