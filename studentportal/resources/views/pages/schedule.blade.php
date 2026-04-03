@extends('layouts.app')

@section('title', 'Schedule')

@section('content')
<div class="container">
    <!-- Header with Next Class Alert -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h2 mb-1">My Schedule</h1>
                            <p class="mb-0 opacity-75">2nd Semester AY 2023-2024</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="alert alert-warning d-inline-flex align-items-center mb-0">
                                <i class="bi bi-clock me-2"></i>
                                <div>
                                    <strong>Next class in {{ $nextClass['starts_in'] }}</strong><br>
                                    <small>{{ $nextClass['subject'] }} at {{ $nextClass['time'] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Schedule -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Weekly Schedule</h4>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-sm">Week View</button>
                            <button class="btn btn-outline-secondary btn-sm">Day View</button>
                            <button class="btn btn-outline-secondary btn-sm">Month View</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 15%">Time</th>
                                    <th style="width: 17%">Monday</th>
                                    <th style="width: 17%">Tuesday</th>
                                    <th style="width: 17%">Wednesday</th>
                                    <th style="width: 17%">Thursday</th>
                                    <th style="width: 17%">Friday</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $timeSlots = [
                                        '08:00-09:30',
                                        '09:30-11:00', 
                                        '11:00-12:30',
                                        '13:00-14:30',
                                        '14:30-16:00',
                                        '16:00-17:30'
                                    ];
                                @endphp
                                
                                @foreach($timeSlots as $timeSlot)
                                <tr>
                                    <td class="fw-semibold">{{ $timeSlot }}</td>
                                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                    <td>
                                        @if(isset($currentWeek[$day]))
                                            @foreach($currentWeek[$day] as $class)
                                                @if($class['time'] == $timeSlot)
                                                <div class="schedule-class p-2 mb-1 rounded" style="background-color: rgba(59, 130, 246, 0.1); border-left: 3px solid #3b82f6;">
                                                    <div class="fw-semibold">{{ $class['subject'] }}</div>
                                                    <small class="text-muted">{{ $class['room'] }} • {{ $class['type'] }}</small>
                                                </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Classes -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Today's Classes</h4>
                </div>
                <div class="card-body">
                    <div id="schedule-content">
                        @php
                            $todayClasses = $currentWeek['monday']; // For demo, using Monday as today
                        @endphp
                        
                        @if(count($todayClasses) > 0)
                        <div class="list-group">
                            @foreach($todayClasses as $class)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $class['subject'] }}</h6>
                                        <p class="mb-1">{{ $class['type'] }}</p>
                                        <small>{{ $class['room'] }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-semibold">{{ $class['time'] }}</div>
                                        <div class="badge bg-primary">{{ $class['type'] }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                            <h5>No classes today</h5>
                            <p class="text-muted">Enjoy your day off!</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">March 2024</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <span class="fw-semibold">March 2024</span>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                        <div class="col text-center fw-semibold text-muted">{{ $day }}</div>
                        @endforeach
                    </div>
                    
                    <div class="row">
                        @for($i = 1; $i <= 31; $i++)
                        <div class="col p-1">
                            <div class="calendar-day 
                                @if($i == 15) today @endif
                                @if(in_array($i, [11, 12, 13, 14, 15, 18, 19, 20])) has-class @endif
                                " data-date="2024-03-{{ sprintf('%02d', $i) }}">
                                {{ $i }}
                            </div>
                        </div>
                        @if($i % 7 == 0)
                    </div>
                    <div class="row">
                        @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Details -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Class Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($currentWeek as $day => $classes)
                        @if(count($classes) > 0)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 text-capitalize">{{ $day }}</h6>
                                </div>
                                <div class="card-body">
                                    @foreach($classes as $class)
                                    <div class="mb-2 pb-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $class['subject'] }}</strong><br>
                                                <small class="text-muted">{{ $class['time'] }}</small>
                                            </div>
                                            <span class="badge bg-primary">{{ $class['type'] }}</span>
                                        </div>
                                        <small class="text-muted">{{ $class['room'] }}</small>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-primary w-100">
                                <i class="bi bi-printer me-2"></i> Print Schedule
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-success w-100">
                                <i class="bi bi-calendar-plus me-2"></i> Add to Calendar
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-info w-100">
                                <i class="bi bi-download me-2"></i> Export as PDF
                            </button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-warning w-100">
                                <i class="bi bi-clock-history me-2"></i> Request Change
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
        // Calendar day click functionality is already initialized in app.js
    });
</script>
@endsection