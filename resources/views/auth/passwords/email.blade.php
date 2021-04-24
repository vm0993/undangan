@extends('layouts.app')

@section('head')
	@include('layouts.head')
@stop

@section('content')
<div class="row h-100">
    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">

            <div class="text-center mt-4">
                <h1 class="h2">Reset password</h1>
                <p class="lead">
                    Enter your email to reset your password.
                </p>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="m-sm-4">
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-lg btn-primary">Reset password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@stop

@section('footer')
    @push('scripts')
    <script type="text/javascript">
        var uri = "{{ url()->current() }}";
        
    </script>
    <script src="{{ asset('js/vimajs.js') }}"></script>
    @endpush
@stop

