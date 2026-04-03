@extends('layouts.app')

@section('title', 'Enrollment')

@section('content')
<div class="container">
    <!-- Enrollment Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #8b5cf6, #ec4899);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h2 mb-1">Enrollment Wizard</h1>
                            <p class="mb-0 opacity-75">2nd Semester AY 2023-2024</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="alert alert-light d-inline-flex align-items-center mb-0">
                                <i class="bi bi-clock me-2 text-danger"></i>
                                <div>
                                    <strong>Deadline: {{ $enrollmentDeadline }}</strong><br>
                                    <small class="countdown-timer" data-deadline="{{ $enrollmentDeadline }}"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step Indicator -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="step-indicator">
                        <div class="step active">1</div>
                        <div class="step">2</div>
                        <div class="step">3</div>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6 class="mb-0">Select Subjects</h6>
                            <small class="text-muted">Choose your courses</small>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-0">Review & Confirm</h6>
                            <small class="text-muted">Check your selection</small>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-0">Complete Enrollment</h6>
                            <small class="text-muted">Finalize registration</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 1: Select Subjects -->
    <div class="enrollment-step active" id="step-1">
        <h3 class="mb-4">Step 1: Select Subjects</h3>
        
        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search subjects by name or code..." id="subject-search">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="subject-filter">
                    <option value="all">All Subjects</option>
                    <option value="core">Core Subjects</option>
                    <option value="elective">Electives</option>
                    <option value="major">Major Subjects</option>
                </select>
            </div>
        </div>

        <!-- Available Subjects -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">Available Subjects</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th style="width: 15%">Code</th>
                                <th style="width: 35%">Subject Name</th>
                                <th style="width: 10%">Units</th>
                                <th style="width: 25%">Schedule</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($availableSubjects as $subject)
                            <tr class="subject-row">
                                <td>
                                    <input type="checkbox" class="subject-checkbox" data-code="{{ $subject['code'] }}">
                                </td>
                                <td class="fw-semibold">{{ $subject['code'] }}</td>
                                <td>{{ $subject['name'] }}</td>
                                <td>{{ $subject['units'] }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $subject['schedule'] }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary add-subject" data-code="{{ $subject['code'] }}">
                                        <i class="bi bi-plus"></i> Add
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Selected Subjects Preview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Selected Subjects (0)</h5>
                    </div>
                    <div class="card-body">
                        <div id="selected-subjects-list" class="mb-3">
                            <p class="text-muted text-center py-3">No subjects selected yet</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Total Units:</strong> <span id="total-units">0</span>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-next-step" data-next="step-2" disabled>
                                    Continue to Review <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 2: Review & Confirm -->
    <div class="enrollment-step" id="step-2" style="display: none;">
        <h3 class="mb-4">Step 2: Review & Confirm</h3>
        
        <!-- Enrollment Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Enrollment Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Subject Code</th>
                                        <th>Subject Name</th>
                                        <th>Units</th>
                                        <th>Schedule</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="review-subjects-list">
                                    <!-- Filled by JavaScript -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="fw-semibold">Total</td>
                                        <td class="fw-semibold" id="review-total-units">0</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- Requirements Checklist -->
                        <div class="mb-4">
                            <h6 class="mb-3">Requirements Checklist</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check1">
                                <label class="form-check-label" for="check1">
                                    I have reviewed my selected subjects
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check2">
                                <label class="form-check-label" for="check2">
                                    I have no schedule conflicts
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check3">
                                <label class="form-check-label" for="check3">
                                    I understand the tuition fees
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="check4">
                                <label class="form-check-label" for="check4">
                                    I agree to the terms and conditions
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-secondary btn-prev-step" data-prev="step-1">
                                <i class="bi bi-arrow-left me-2"></i> Back
                            </button>
                            <button class="btn btn-primary btn-next-step" data-next="step-3" disabled>
                                Confirm & Proceed <i class="bi bi-check-circle ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3: Complete Enrollment -->
    <div class="enrollment-step" id="step-3" style="display: none;">
        <h3 class="mb-4">Step 3: Complete Enrollment</h3>
        
        <!-- Confirmation -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="mb-3">Enrollment Complete!</h3>
                        <p class="text-muted mb-4">
                            Your enrollment for the 2nd Semester AY 2023-2024 has been successfully processed.
                        </p>
                        
                        <!-- Enrollment Details -->
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-8">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="mb-3">Enrollment Details</h6>
                                        <div class="row text-start">
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted">Enrollment ID</small>
                                                <p class="mb-0 fw-semibold">ENR-2024-00123</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted">Date & Time</small>
                                                <p class="mb-0 fw-semibold">{{ date('Y-m-d H:i:s') }}</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted">Total Subjects</small>
                                                <p class="mb-0 fw-semibold" id="final-subject-count">0</p>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <small class="text-muted">Total Units</small>
                                                <p class="mb-0 fw-semibold" id="final-total-units">0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Next Steps -->
                        <div class="mb-4">
                            <h6 class="mb-3">Next Steps</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded">
                                        <i class="bi bi-printer fs-4 text-primary mb-2"></i>
                                        <p class="mb-0 small">Print enrollment form</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded">
                                        <i class="bi bi-credit-card fs-4 text-success mb-2"></i>
                                        <p class="mb-0 small">Pay tuition fees</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 border rounded">
                                        <i class="bi bi-calendar-check fs-4 text-info mb-2"></i>
                                        <p class="mb-0 small">View your schedule</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-download me-2"></i> Download PDF
                            </button>
                            <button class="btn btn-primary">
                                <i class="bi bi-printer me-2"></i> Print Form
                            </button>
                            <a href="/schedule" class="btn btn-success">
                                <i class="bi bi-calendar-week me-2"></i> View Schedule
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Need Help?</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-question-circle fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Enrollment Guidelines</h6>
                                    <p class="small text-muted mb-0">Read the enrollment guidelines and policies</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-telephone fs-4 text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Contact Registrar</h6>
                                    <p class="small text-muted mb-0">Call (02) 123-4567 or email registrar@university.edu</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-chat-dots fs-4 text-warning"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Live Chat Support</h6>
                                    <p class="small text-muted mb-0">Get instant help from our support team</p>
                                </div>
                            </div>
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
        let selectedSubjects = [];
        
        // Subject selection functionality
        const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');
        const selectAllCheckbox = document.getElementById('select-all');
        const addSubjectButtons = document.querySelectorAll('.add-subject');
        const selectedSubjectsList = document.getElementById('selected-subjects-list');
        const totalUnitsElement = document.getElementById('total-units');
        const continueButton = document.querySelector('#step-1 .btn-next-step');
        
        // Search functionality
        const searchInput = document.getElementById('subject-search');
        const filterSelect = document.getElementById('subject-filter');
        
        // Step 2 elements
        const reviewSubjectsList = document.getElementById('review-subjects-list');
        const reviewTotalUnits = document.getElementById('review-total-units');
        const step2ContinueButton = document.querySelector('#step-2 .btn-next-step');
        
        // Step 3 elements
        const finalSubjectCount = document.getElementById('final-subject-count');
        const finalTotalUnits = document.getElementById('final-total-units');
        
        // Initialize enrollment wizard
        initializeEnrollmentWizard();
        
        // Subject search and filter
        searchInput.addEventListener('input', filterSubjects);
        filterSelect.addEventListener('change', filterSubjects);
        
        // Select all checkbox
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            subjectCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
                if (isChecked) {
                    addSubject(checkbox.dataset.code);
                } else {
                    removeSubject(checkbox.dataset.code);
                }
            });
            updateSelectedSubjectsDisplay();
        });
        
        // Individual subject checkboxes
        subjectCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    addSubject(this.dataset.code);
                } else {
                    removeSubject(this.dataset.code);
                }
                updateSelectedSubjectsDisplay();
            });
        });
        
        // Add subject buttons
        addSubjectButtons.forEach(button => {
            button.addEventListener('click', function() {
                const subjectCode = this.dataset.code;
                const checkbox = document.querySelector(`.subject-checkbox[data-code="${subjectCode}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                    addSubject(subjectCode);
                    updateSelectedSubjectsDisplay();
                }
            });
        });
        
        // Step 2 checklist validation
        const checkboxes = document.querySelectorAll('#step-2 .form-check-input');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', validateStep2);
        });
        
        function filterSubjects() {
            const searchTerm = searchInput.value.toLowerCase();
            const filterValue = filterSelect.value;
            
            subjectCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const subjectCode = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const subjectName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                
                let matchesSearch = subjectCode.includes(searchTerm) || subjectName.includes(searchTerm);
                let matchesFilter = true;
                
                // Simple filter logic (in real app, this would check subject metadata)
                if (filterValue === 'core' && !subjectCode.startsWith('cs')) {
                    matchesFilter = false;
                } else if (filterValue === 'elective' && !subjectCode.includes('elective')) {
                    matchesFilter = false;
                } else if (filterValue === 'major' && !subjectCode.startsWith('cs3')) {
                    matchesFilter = false;
                }
                
                row.style.display = matchesSearch && matchesFilter ? '' : 'none';
            });
        }
        
        function addSubject(subjectCode) {
            if (!selectedSubjects.includes(subjectCode)) {
                selectedSubjects.push(subjectCode);
            }
        }
        
        function removeSubject(subjectCode) {
            const index = selectedSubjects.indexOf(subjectCode);
            if (index > -1) {
                selectedSubjects.splice(index, 1);
            }
        }
        
        function updateSelectedSubjectsDisplay() {
            // Update selected subjects list
            if (selectedSubjects.length === 0) {
                selectedSubjectsList.innerHTML = '<p class="text-muted text-center py-3">No subjects selected yet</p>';
                totalUnitsElement.textContent = '0';
                continueButton.disabled = true;
                return;
            }
            
            let html = '';
            let totalUnits = 0;
            
            selectedSubjects.forEach(subjectCode => {
                // Find subject details from available subjects
                const subject = availableSubjects.find(s => s.code === subjectCode);
                if (subject) {
                    totalUnits += subject.units;
                    html += `
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                            <div>
                                <strong>${subject.code}</strong> - ${subject.name}<br>
                                <small class="text-muted">${subject.schedule} • ${subject.units} units</small>
                            </div>
                            <button class="btn btn-sm btn-outline-danger remove-subject" data-code="${subject.code}">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    `;
                }
            });
            
            selectedSubjectsList.innerHTML = html;
            totalUnitsElement.textContent = totalUnits;
            continueButton.disabled = false;
            
            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-subject').forEach(button => {
                button.addEventListener('click', function() {
                    const subjectCode = this.dataset.code;
                    const checkbox = document.querySelector(`.subject-checkbox[data-code="${subjectCode}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    removeSubject(subjectCode);
                    updateSelectedSubjectsDisplay();
                });
            });
        }
        
        function updateReviewStep() {
            if (selectedSubjects.length === 0) {
                reviewSubjectsList.innerHTML = '<tr><td colspan="5" class="text-center py-3">No subjects selected</td></tr>';
                reviewTotalUnits.textContent = '0';
                return;
            }
            
            let html = '';
            let totalUnits = 0;
            
            selectedSubjects.forEach(subjectCode => {
                const subject = availableSubjects.find(s => s.code === subjectCode);
                if (subject) {
                    totalUnits += subject.units;
                    html += `
                        <tr>
                            <td>${subject.code}</td>
                            <td>${subject.name}</td>
                            <td>${subject.units}</td>
                            <td>${subject.schedule}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger remove-review-subject" data-code="${subject.code}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }
            });
            
            reviewSubjectsList.innerHTML = html;
            reviewTotalUnits.textContent = totalUnits;
            
            // Add event listeners to remove buttons in review
            document.querySelectorAll('.remove-review-subject').forEach(button => {
                button.addEventListener('click', function() {
                    const subjectCode = this.dataset.code;
                    const checkbox = document.querySelector(`.subject-checkbox[data-code="${subjectCode}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                    }
                    removeSubject(subjectCode);
                    updateSelectedSubjectsDisplay();
                    updateReviewStep();
                });
            });
        }
        
        function validateStep2() {
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            step2ContinueButton.disabled = !allChecked;
        }
        
        function updateFinalStep() {
            finalSubjectCount.textContent = selectedSubjects.length;
            finalTotalUnits.textContent = selectedSubjects.reduce((total, subjectCode) => {
                const subject = availableSubjects.find(s => s.code === subjectCode);
                return total + (subject ? subject.units : 0);
            }, 0);
        }
        
        // Available subjects data (from PHP)
        const availableSubjects = <?php echo json_encode($availableSubjects); ?>;
        
        // Update steps when navigating
        document.querySelectorAll('.btn-next-step').forEach(button => {
            button.addEventListener('click', function() {
                const nextStepId = this.dataset.next;
                
                if (nextStepId === 'step-2') {
                    updateReviewStep();
                } else if (nextStepId === 'step-3') {
                    updateFinalStep();
                }
            });
        });
    });
</script>
@endsection