@if(!$guests->id)
{!! Form::open(['id'=>'frm','enctype'=>'multipart/form-data']) !!}
@else
{!! Form::model($guests, ['method'=>'put','id'=>'frm','enctype'=>'multipart/form-data']) !!}
@endif
    <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" id="data-body">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <fieldset class="form-group">
                  <label for="basicInputFile">Lokasi File</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="lokasi_file" id="lokasi_file">
                    <label class="custom-file-label" for="inputGroupFile01">File Data Tamu</label>
                  </div>
                </fieldset>
              </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Close</button>
        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Import</button>
    </div>
{!! Form::close() !!}