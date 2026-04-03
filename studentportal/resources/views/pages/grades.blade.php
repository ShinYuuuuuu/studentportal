@extends('layouts.app')

@section('title', 'My Grades')

@section('content')
<div class="container">
    <!-- Header with GPA -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h2 mb-1">My Grades</h1>
                            <p class="mb-0 opacity-75">{{ $semester }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="display-1 fw-bold">{{ $gpa }}</div>
                            <p class="mb-0">Overall GPA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary grade-filter active" data-filter="all">All Grades</button>
                        <button class="btn btn-outline-success grade-filter" data-filter="excellent">Excellent (≤ 1.5)</button>
                        <button class="btn btn-outline-info grade-filter" data-filter="good">Good (1.6-2.0)</button>
                        <button class="btn btn-outline-warning grade-filter" data-filter="average">Average (2.1-2.5)</button>
                        <button class="btn btn-outline-danger grade-filter" data-filter="poor">Needs Improvement (> 2.5)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Cards -->
    <div class="row mb-4">
        @foreach($grades as $grade)
        @php
            $gradeClass = 'grade-average';
            if ($grade['grade'] <= 1.5) {
                $gradeClass = 'grade-excellent';
            } elseif ($grade['grade'] <= 2.0) {
                $gradeClass = 'grade-good';
            } elseif ($grade['grade'] <= 2.5) {
                $gradeClass = 'grade-average';
            } else {
                $gradeClass = 'grade-poor';
            }
        @endphp
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card grade-card {{ $gradeClass }}" data-grade="{{ $grade['grade'] }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="card-title mb-1">{{ $grade['subject'] }}</h5>
                            <small class="text-muted">{{ $grade['code'] }} • {{ $grade['units'] }} units</small>
                        </div>
                        <div class="text-end">
                            <h2 class="mb-0">{{ $grade['grade'] }}</h2>
                            <small class="text-muted">{{ $grade['equivalent'] }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-light text-dark">{{ $grade['remarks'] }}</span>
                        <div class="small">
                            @if($grade['grade'] <= 1.5)
                            <i class="bi bi-fire text-danger"></i> Excellent
                            @elseif($grade['grade'] <= 2.0)
                            <i class="bi bi-check-circle text-success"></i> Very Good
                            @elseif($grade['grade'] <= 2.5)
                            <i class="bi bi-info-circle text-info"></i> Good
                            @else
                            <i class="bi bi-exclamation-triangle text-warning"></i> Needs Work
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Grade Summary -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Grade Distribution</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Excellent (≤ 1.5)</span>
                            <span>2 subjects</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 33%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Very Good (1.6-2.0)</span>
                            <span>2 subjects</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: 33%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Good (2.1-2.5)</span>
                            <span>1 subject</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 17%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Needs Work (> 2.5)</span>
                            <span>1 subject</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: 17%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Academic Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="display-4 fw-bold text-primary">{{ $gpa }}</div>
                            <p class="text-muted mb-0">Current GPA</p>
                        </div>
                        <div class="col-6">
                            <div class="display-4 fw-bold text-success">{{ $totalUnits }}</div>
                            <p class="text-muted mb-0">Total Units</p>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-4">
                            <h5 class="mb-0">6</h5>
                            <small class="text-muted">Subjects</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">100%</h5>
                            <small class="text-muted">Pass Rate</small>
                        </div>
                        <div class="col-4">
                            <h5 class="mb-0">↑ 0.15</h5>
                            <small class="text-muted">GPA Trend</small>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <h6 class="mb-2">Recommendations</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <span>Excellent performance in Programming and Database</span>
                            </li>
                            <li class="mb-1">
                                <i class="bi bi-lightbulb text-warning me-2"></i>
                                <span>Consider tutoring for Data Structures</span>
                            </li>
                            <li>
                                <i class="bi bi-graph-up text-info me-2"></i>
                                <span>Maintain current study habits for next semester</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-outline-primary btn-lg w-100">
                                <i class="bi bi-download me-2"></i> Download Grade Slip
                            </button>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-outline-success btn-lg w-100">
                                <i class="bi bi-printer me-2"></i> Print Grades
                            </button>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-outline-info btn-lg w-100">
                                <i class="bi bi-bar-chart me-2"></i> View Analytics
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Grade filtering functionality is already initialized in app.js
    });
</script>
@endsection