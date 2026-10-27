@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5">
        <div class="card card-custom border-0 shadow-lg overflow-hidden">
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);">
                <div class="d-inline-flex p-3 rounded-circle bg-white bg-opacity-25 mb-3">
                    <i class="bi bi-shield-lock-fill fs-2 text-white"></i>
                </div>
                <h4 class="fw-bold mb-1">Student Management System</h4>
                <p class="mb-0 text-indigo-100 small" style="opacity: 0.9;">Sign in to access your administrative dashboard</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary small">EMAIL ADDRESS</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0 @error('email') is-invalid @enderror" value="{{ old('email', 'admin@example.com') }}" placeholder="name@example.com" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold text-secondary small">PASSWORD</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 @error('password') is-invalid @enderror" value="password123" placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" checked>
                        <label for="remember" class="form-check-label small text-muted">Remember my session on this device</label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary-custom py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Account
                        </button>
                    </div>

                    <div class="alert alert-info py-2 small d-flex align-items-center gap-2 mb-0 border-0 bg-info-subtle text-info-emphasis">
                        <i class="bi bi-info-circle-fill"></i>
                        <div>
                            <strong>Demo Admin:</strong> <code>admin@example.com</code> / <code>password123</code>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light text-center py-3 border-top">
                <span class="text-muted small">Don't have an account yet?</span>
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold ms-1" style="color: var(--sms-primary);">Create an account</a>
            </div>
        </div>
    </div>
</div>
@endsection
