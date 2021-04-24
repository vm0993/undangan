@extends('layouts.app')

@section('head')
	@include('layouts.head')
@stop

@section('content')
<div class="row h-100">
    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
                <h1 class="h2">Welcome back</h1>
                <p class="lead">
                    Sign in to your account to continue
                </p>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="m-sm-4">
                        <div class="text-center">
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Chris Wood" class="img-fluid rounded-circle" width="132" height="132" />
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Username/Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Username or Email">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small>
                                    <a href="{{ url('password/reset') }}">Lupa Password?</a>
                                </small>
                            </div>
                            <div>
                                <div class="form-check align-items-center">
                                    <input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
                                    <label class="form-check-label text-small" for="customControlInline">Remember me next time</label>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
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