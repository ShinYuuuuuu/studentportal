<?php
$title = 'Dashboard';
ob_start();
?>
<div class="container">
    <!-- Hero Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h2 mb-1">Good morning, <?php echo $student['name']; ?> 👋</h1>
                            <p class="mb-0 opacity-75"><?php echo $student['program']; ?> • <?php echo $student['year_level']; ?> • <?php echo $student['section']; ?></p>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-white text-primary fs-6 px-3 py-2">ID: <?php echo $student['id']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="summary-card gpa">
                <div class="card-icon">
                    <i class="bi bi-graph-up fs-3"></i>
                </div>
                <h5 class="card-title mb-1">GPA</h5>
                <h2 class="mb-0"><?php echo $summary['gpa']; ?></h2>
                <p class="text-muted mb-0">Current Average</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="summary-card schedule">
                <div class="card-icon">
                    <i class="bi bi-clock fs-3"></i>
                </div>
                <h5 class="card-title mb-1">Next Class</h5>
                <h6 class="mb-1"><?php echo $summary['next_class']['subject']; ?></h6>
                <p class="text-muted mb-0"><?php echo $summary['next_class']['time']; ?> • <?php echo $summary['next_class']['room']; ?></p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="summary-card announcement">
                <div class="card-icon">
                    <i class="bi bi-megaphone fs-3"></i>
                </div>
                <h5 class="card-title mb-1">Announcements</h5>
                <h6 class="mb-1"><?php echo count($summary['announcements']); ?> New</h6>
                <p class="text-muted mb-0">Latest updates</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="summary-card tasks">
                <div class="card-icon">
                    <i class="bi bi-list-check fs-3"></i>
                </div>
                <h5 class="card-title mb-1">Pending Tasks</h5>
                <h6 class="mb-1"><?php echo count($summary['pending_tasks']); ?> Tasks</h6>
                <p class="text-muted mb-0">Deadlines approaching</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-3">Quick Actions</h3>
        </div>
        <?php foreach($quickActions as $action): ?>
        <div class="col-md-3 col-sm-6 mb-3">
            <a href="<?php echo $action['url']; ?>" class="quick-action-btn">
                <i class="bi <?php echo $action['icon']; ?>"></i>
                <span class="fs-5 fw-semibold"><?php echo $action['label']; ?></span>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Recent Activity & Notifications -->
    <div class="row">
        <!-- Recent Activity -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Recent Activity</h4>
                </div>
                <div class="card-body">
                    <?php foreach($recentActivity as $activity): ?>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-light p-2 me-3">
                            <?php if($activity['type'] == 'grade_view'): ?>
                            <i class="bi bi-bar-chart text-primary"></i>
                            <?php elseif($activity['type'] == 'file_download'): ?>
                            <i class="bi bi-download text-success"></i>
                            <?php else: ?>
                            <i class="bi bi-clipboard-check text-warning"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">
                                <?php if($activity['type'] == 'grade_view'): ?>
                                Viewed <?php echo $activity['subject']; ?> grades
                                <?php elseif($activity['type'] == 'file_download'): ?>
                                Downloaded <?php echo $activity['file']; ?>
                                <?php else: ?>
                                <?php echo $activity['action']; ?>
                                <?php endif; ?>
                            </h6>
                            <small class="text-muted"><?php echo $activity['time']; ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Notifications & Deadlines -->
        <div class="col-lg-4 mb-4">
            <!-- Announcements -->
            <div class="card mb-3">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Latest Announcements</h5>
                </div>
                <div class="card-body">
                    <?php foreach($summary['announcements'] as $announcement): ?>
                    <div class="alert-notification alert-info mb-2">
                        <h6 class="mb-1"><?php echo $announcement['title']; ?></h6>
                        <p class="mb-1 small"><?php echo $announcement['content']; ?></p>
                        <small class="text-muted"><?php echo $announcement['date']; ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Pending Tasks</h5>
                </div>
                <div class="card-body">
                    <?php foreach($summary['pending_tasks'] as $task): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <h6 class="mb-0"><?php echo $task['task']; ?></h6>
                            <small class="text-muted">Due: <?php echo $task['deadline']; ?></small>
                        </div>
                        <span class="badge bg-danger countdown-timer" data-deadline="<?php echo $task['deadline']; ?>"></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Indicators -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Academic Performance</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="text-center">
                                <h1 class="display-4 text-primary"><?php echo $summary['gpa']; ?></h1>
                                <p class="text-muted">Current GPA</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="mb-2">Progress this semester</h6>
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: 75%"></div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="text-center">
                                        <h5 class="mb-0">18</h5>
                                        <small class="text-muted">Units</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center">
                                        <h5 class="mb-0">6</h5>
                                        <small class="text-muted">Subjects</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center">
                                        <h5 class="mb-0">85%</h5>
                                        <small class="text-muted">Attendance</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$scripts = '<script>
    document.addEventListener(\'DOMContentLoaded\', function() {
        // Initialize countdown timers
        initializeDeadlineCountdowns();

        // Update greeting based on time of day
        updateGreeting();
    });

    function updateGreeting() {
        const hour = new Date().getHours();
        const greetingElement = document.querySelector(\'.h2\');
        if (greetingElement) {
            let greeting = \'Good \';
            if (hour < 12) greeting += \'morning\';
            else if (hour < 18) greeting += \'afternoon\';
            else greeting += \'evening\';

            greetingElement.innerHTML = greeting + \', ' . $student['name'] . ' 👋\';
        }
    }
</script>';
?>