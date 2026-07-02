@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center">
        <i class="bi bi-x-circle-fill me-3" style="font-size: 1.5rem;"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;"></i>
        <div>{{ session('warning') }}</div>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center">
        <i class="bi bi-info-circle-fill me-3" style="font-size: 1.5rem;"></i>
        <div>{{ session('info') }}</div>
    </div>
@endif