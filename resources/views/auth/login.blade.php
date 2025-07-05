@extends('layouts.app')
@section('container')
    <div class="card">
        <div class="card-body">
                <a href="{{ route('fe') }}" class="app-brand-link gap-2">
                    <img src="{{ asset('assets/bahanSertifikat/logo.png') }}" width="70%">
                </a>
            <!-- /Logo -->
            <div class="card-body p-3">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="needs-validation" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label class="mb-2 text-muted" for="username">{{ __('Username') }}</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="mb-2 w-100">
                            <label class="text-muted" for="password">{{ __('Password') }}</label>
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" autocomplete="current-password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary d-grid w-100 text-white"
                            style="background-color: rgb(65, 115, 241);">
                            {{ __('Masuk') }}
                        </button>
                    </div>
                    <a href="{{route('daftarInternship')}}"><i>Belum memiliki akun?</i></a>
                </form>
            </div>
        </div>
    </div>
@endsection
