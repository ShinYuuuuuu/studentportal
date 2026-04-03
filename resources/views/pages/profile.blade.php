@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-white p-3 me-4">
                                    <i class="bi bi-person-circle fs-1 text-primary"></i>
                                </div>
                                <div>
                                    <h1 class="h2 mb-1">{{ $student['name'] }}</h1>
                                    <p class="mb-0 opacity-75">{{ $student['program'] }} • {{ $student['year_level'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="badge bg-white text-primary fs-6 px-3 py-2">ID: {{ $student['student_id'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="row">
        <!-- Personal Information -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Personal Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Full Name</label>
                            <p class="fs-5">{{ $student['name'] }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Student ID</label>
                            <p class="fs-5">{{ $student['student_id'] }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Email Address</label>
                            <p class="fs-5">{{ $student['email'] }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Phone Number</label>
                            <p class="fs-5">{{ $student['phone'] }}</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted">Address</label>
                            <p class="fs-5">{{ $student['address'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Academic Information</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Program</label>
                        <p class="fs-5">{{ $student['program'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Year Level</label>
                        <p class="fs-5">{{ $student['year_level'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Section</label>
                        <p class="fs-5">{{ $student['section'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Admission Date</label>
                        <p class="fs-5">{{ $student['admission_date'] }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Status</label>
                        <p class="fs-5">
                            <span class="badge bg-success">{{ $student['status'] }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Performance -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Academic Performance</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <div class="display-4 fw-bold text-primary">1.85</div>
                                <p class="text-muted mb-0">Current GPA</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <div class="display-4 fw-bold text-success">18</div>
                                <p class="text-muted mb-0">Total Units</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <div class="display-4 fw-bold text-info">85%</div>
                                <p class="text-muted mb-0">Attendance Rate</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <div class="display-4 fw-bold text-warning">6</div>
                                <p class="text-muted mb-0">Current Subjects</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        <button class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i> Edit Profile
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-key me-2"></i> Change Password
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="bi bi-download me-2"></i> Download Profile
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="bi bi-printer me-2"></i> Print Profile
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="bi bi-shield-check me-2"></i> Privacy Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Recent Activity</h4>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center">
                            <i class="bi bi-bar-chart text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Viewed Grades</h6>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <i class="bi bi-download text-success me-3"></i>
                            <div>
                                <h6 class="mb-0">Downloaded Clearance Form</h6>
                                <small class="text-muted">1 day ago</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <i class="bi bi-calendar-check text-info me-3"></i>
                            <div>
                                <h6 class="mb-0">Updated Schedule</h6>
                                <small class="text-muted">2 days ago</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <i class="bi bi-credit-card text-warning me-3"></i>
                            <div>
                                <h6 class="mb-0">Paid Tuition Fees</h6>
                                <small class="text-muted">3 days ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Security -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Account Security</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Password Strength</span>
                            <span class="badge bg-success">Strong</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Two-Factor Authentication</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <small class="text-muted">Adds an extra layer of security to your account</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Login Activity</span>
                            <span class="badge bg-info">Active</span>
                        </div>
                        <small class="text-muted">Last login: Today, 09:15 AM from Chrome on Windows</small>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn btn-outline-danger w-100">
                            <i class="bi bi-shield-exclamation me-2"></i> View Security Log
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection