@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row align-items-center justify-content-center min-vh-75 py-5">
        <div class="col-lg-7 col-md-9">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle border border-2 border-secondary-subtle" style="width:72px;height:72px;">
                    <i class="fas fa-headset text-secondary" style="font-size:28px;"></i>
                </div>
            </div>

            <div class="text-center mb-4">
                <h1 class="fw-semibold mb-2">SmartDesk</h1>
                <p class="text-muted mb-0">Internal IT Support Portal</p>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    <p class="mb-4 text-muted text-center">
                        Submit and track IT support tickets. Use your company credentials to continue.
                    </p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-3 text-center text-md-start">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100">
                        <div class="small text-uppercase text-muted mb-1">Support Hours</div>
                        <div class="fw-medium">Mon–Fri, 8:00 – 18:00</div>
                        <div class="text-muted small">Emergency on-call after hours</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 h-100">
                        <div class="small text-uppercase text-muted mb-1">Contact IT</div>
                        <div class="fw-medium">
                            <i class="fas fa-envelope me-2"></i>it-support@company.com
                        </div>
                        <div class="text-muted small">
                            <i class="fas fa-phone me-2"></i>+1 (555) 123-4567
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center text-muted small mt-4">
                For authorized company users only. Activity may be monitored.
            </div>
        </div>
    </div>
</div>
@endsection