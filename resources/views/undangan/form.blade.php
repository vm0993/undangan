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
                <div class="form-floating mb-3">
                    {{ Form::select('guest_id', \App\Helpers\Helper::getDaftarTamu(), $invite->guest_id , ['id'=>'guest_id', 'class'=>'form-control select2','data-toggle'=>'select2','placeholder'=>'Pilih Tamu/Peserta']) }}
                    <label for="guest_id">Nama</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    {{ Form::select('wedding_id', \App\Helpers\Helper::getDaftarPernikahan(), $invite->wedding_id , ['id'=>'wedding_id', 'class'=>'form-control select2','data-toggle'=>'select2','placeholder'=>'Pilih Acara']) }}
                    <label for="wedding_id">Acara Pernikahan</label>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-8">
                <div class="form-floating">
                    {{ Form::text('time_start',null, ['id'=>'time_start', 'class'=>'form-control','data-mask'=>'00:00:00','placeholder'=>'HH:MM:SS'] ) }}
                    <label for="time_start">Jam Mulai Acara [HH:MM:SS]</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Tutup</button>
        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Simpan</button>
    </div>
{!! Form::close() !!}
<script src="{{ asset('js/select2.min.jssss') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(".select2").each(function() {
            $(this)
                .wrap("<div class=\"position-relative\"></div>")
                .select2({
                    placeholder: "Select value",
                    dropdownParent: $(this).parent()
                });
        })
    });
</script>