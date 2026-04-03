<?php
// Simplified dashboard without database queries
?>
<div class="row mb-4">
    <div class="col-md-3 col-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-graph-up fs-1 text-success"></i>
                <h4 class="mt-2">1.85</h4>
                <small class="text-muted">Current GPA</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-clock fs-1 text-primary"></i>
                <h4 class="mt-2">Web Dev</h4>
                <small class="text-muted">Next Class</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-megaphone fs-1 text-warning"></i>
                <h4 class="mt-2">2</h4>
                <small class="text-muted">Announcements</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-list-check fs-1 text-danger"></i>
                <h4 class="mt-2">3</h4>
                <small class="text-muted">Pending Tasks</small>
            </div>
        </div>
    </div>
</div>

<h5 class="mb-3">Quick Actions</h5>
<div class="row mb-4">
    <div class="col-md-3 col-6 mb-3">
        <a href="?page=grades" class="quick-action-btn text-center py-4">
            <i class="bi bi-bar-chart fs-2 d-block mb-2"></i>View Grades
        </a>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <a href="?page=schedule" class="quick-action-btn text-center py-4">
            <i class="bi bi-calendar fs-2 d-block mb-2"></i>View Schedule
        </a>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <a href="?page=enrollment" class="quick-action-btn text-center py-4">
            <i class="bi bi-clipboard-check fs-2 d-block mb-2"></i>Enroll Now
        </a>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <a href="?page=downloads" class="quick-action-btn text-center py-4">
            <i class="bi bi-download fs-2 d-block mb-2"></i>Downloads
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Recent Activity</h5></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-bar-chart text-primary me-3"></i>
                    <div><h6 class="mb-0">Viewed Math 101 Grades</h6><small class="text-muted">2 hours ago</small></div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-download text-success me-3"></i>
                    <div><h6 class="mb-0">Downloaded Clearance Form</h6><small class="text-muted">1 day ago</small></div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-clipboard-check text-warning me-3"></i>
                    <div><h6 class="mb-0">Completed Enrollment</h6><small class="text-muted">2 days ago</small></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Pending Tasks</h5></div>
            <div class="card-body">
                <div class="mb-2"><span class="badge bg-danger me-2">!</span>Submit thesis proposal</div>
                <div class="mb-2"><span class="badge bg-warning me-2">!</span>Pay tuition fee</div>
                <div><span class="badge bg-info me-2">!</span>Complete clearance</div>
            </div>
        </div>
    </div>
</div>