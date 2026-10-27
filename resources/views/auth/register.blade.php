@extends('layouts.app')

@section('title', 'Register Account')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom border-0 shadow-lg overflow-hidden">
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);">
                <div class="d-inline-flex p-3 rounded-circle bg-white bg-opacity-25 mb-3">
                    <i class="bi bi-person-plus-fill fs-2 text-white"></i>
                </div>
                <h4 class="fw-bold mb-1">Create Admin Account</h4>
                <p class="mb-0 text-indigo-100 small" style="opacity: 0.9;">Join the Student Management System portal</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-secondary small">FULL NAME</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="name" id="name" class="form-control border-start-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary small">EMAIL ADDRESS</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="john@example.com" required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-secondary small">PASSWORD</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="Minimum 6 characters" required>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold text-secondary small">CONFIRM PASSWORD</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-check text-muted"></i></span>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0" placeholder="Repeat your password" required>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary-custom py-2 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Register & Log In
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3 border-top">
                <span class="text-muted small">Already registered?</span>
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold ms-1" style="color: var(--sms-primary);">Sign in here</a>
            </div>
        </div>
    </div>
</div>
@endsection
