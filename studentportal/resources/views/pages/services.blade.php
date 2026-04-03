@extends('layouts.app')

@section('title', 'Online Services')

@section('content')
<div class="container">
    <!-- Services Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #f59e0b, #ec4899);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h2 mb-1">Online Services</h1>
                            <p class="mb-0 opacity-75">Request documents, pay fees, and access academic services</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="alert alert-light d-inline-flex align-items-center mb-0">
                                <i class="bi bi-lightning-charge me-2 text-warning"></i>
                                <div>
                                    <strong>Quick Services</strong><br>
                                    <small>Most requested services</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Services -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Quick Access</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-outline-primary service-request-btn w-100 h-100 py-3" data-service="Request TOR">
                                <i class="bi bi-file-text fs-1 mb-2"></i>
                                <div>Request TOR</div>
                                <small class="text-muted">Transcript of Records</small>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-outline-success service-request-btn w-100 h-100 py-3" data-service="Pay Tuition">
                                <i class="bi bi-credit-card fs-1 mb-2"></i>
                                <div>Pay Tuition</div>
                                <small class="text-muted">Online payment</small>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-outline-info service-request-btn w-100 h-100 py-3" data-service="Apply Clearance">
                                <i class="bi bi-clipboard-check fs-1 mb-2"></i>
                                <div>Apply Clearance</div>
                                <small class="text-muted">Student clearance</small>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-outline-warning service-request-btn w-100 h-100 py-3" data-service="Request ID">
                                <i class="bi bi-person-badge fs-1 mb-2"></i>
                                <div>Request ID</div>
                                <small class="text-muted">Student ID replacement</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Categories -->
    @foreach($categories as $categoryName => $services)
    <div class="row mb-4">
        <div class="col-12">
            <div class="service-category">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0">{{ $categoryName }}</h4>
                    <span class="badge bg-primary">{{ count($services) }} services</span>
                </div>
                
                <div class="row">
                    @foreach($services as $service)
                    <div class="col-md-6 mb-3">
                        <div class="service-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $service['name'] }}</h6>
                                    <p class="text-muted small mb-2">{{ $service['description'] }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $service['processing_time'] }}
                                        </small>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary service-request-btn" data-service="{{ $service['name'] }}">
                                                <i class="bi bi-send me-1"></i> Request
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#infoModal{{ $loop->index }}{{ $loop->parent->index }}">
                                                <i class="bi bi-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Service Status Tracking -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">My Service Requests</h4>
                        <span class="badge bg-secondary">3 pending</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Request ID</th>
                                    <th>Date Requested</th>
                                    <th>Status</th>
                                    <th>Estimated Completion</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Request TOR</td>
                                    <td>REQ-2024-00123</td>
                                    <td>2024-03-01</td>
                                    <td>
                                        <span class="badge bg-warning">Processing</span>
                                    </td>
                                    <td>2024-03-08</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Track
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pay Tuition</td>
                                    <td>PAY-2024-00456</td>
                                    <td>2024-03-05</td>
                                    <td>
                                        <span class="badge bg-success">Completed</span>
                                    </td>
                                    <td>2024-03-05</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-download"></i> Receipt
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apply Clearance</td>
                                    <td>CLEAR-2024-00789</td>
                                    <td>2024-03-10</td>
                                    <td>
                                        <span class="badge bg-info">Pending Review</span>
                                    </td>
                                    <td>2024-03-15</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-clock"></i> Check
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Information & FAQs -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Service Information</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="serviceInfoAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#info1">
                                    How long does processing take?
                                </button>
                            </h2>
                            <div id="info1" class="accordion-collapse collapse show" data-bs-parent="#serviceInfoAccordion">
                                <div class="accordion-body">
                                    Processing times vary by service. Document requests typically take 3-5 working days, while online payments are processed immediately. You can track the status of your request in the "My Service Requests" section.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#info2">
                                    What payment methods are accepted?
                                </button>
                            </h2>
                            <div id="info2" class="accordion-collapse collapse" data-bs-parent="#serviceInfoAccordion">
                                <div class="accordion-body">
                                    We accept online payments via credit/debit cards, bank transfers, and e-wallets. For cash payments, please visit the cashier's office during business hours.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#info3">
                                    How do I track my request?
                                </button>
                            </h2>
                            <div id="info3" class="accordion-collapse collapse" data-bs-parent="#serviceInfoAccordion">
                                <div class="accordion-body">
                                    All service requests are assigned a unique Request ID. You can track the status using this ID in the "My Service Requests" section. You will also receive email notifications at each stage of processing.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Contact Support</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="mb-2"><i class="bi bi-telephone text-primary me-2"></i> Phone Support</h6>
                        <p class="mb-0">(02) 123-4567</p>
                        <small class="text-muted">Monday to Friday, 8:00 AM - 5:00 PM</small>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="mb-2"><i class="bi bi-envelope text-success me-2"></i> Email Support</h6>
                        <p class="mb-0">registrar@university.edu</p>
                        <small class="text-muted">Response within 24 hours</small>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="mb-2"><i class="bi bi-chat-dots text-info me-2"></i> Live Chat</h6>
                        <p class="mb-0">Available during office hours</p>
                        <button class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-chat-left me-1"></i> Start Chat
                        </button>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="mb-2"><i class="bi bi-clock-history text-warning me-2"></i> Office Hours</h6>
                        <p class="mb-0">Monday to Friday: 8:00 AM - 5:00 PM</p>
                        <p class="mb-0">Saturday: 8:00 AM - 12:00 PM</p>
                        <small class="text-muted">Closed on Sundays and holidays</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Modals -->
    @foreach($categories as $categoryIndex => $services)
        @foreach($services as $serviceIndex => $service)
        <div class="modal fade" id="infoModal{{ $serviceIndex }}{{ $categoryIndex }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $service['name'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Description</h6>
                        <p>{{ $service['description'] }}</p>
                        
                        <h6>Processing Time</h6>
                        <p>{{ $service['processing_time'] }}</p>
                        
                        <h6>Requirements</h6>
                        <ul>
                            <li>Valid student ID</li>
                            <li>Clearance from all departments</li>
                            <li>No outstanding balances</li>
                        </ul>
                        
                        <h6>Fees</h6>
                        <p>₱500.00 (standard processing fee)</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary service-request-btn" data-service="{{ $service['name'] }}" data-bs-dismiss="modal">
                            <i class="bi bi-send me-1"></i> Request Service
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Service request functionality is already initialized in app.js
        
        // Initialize tooltips for info buttons
        const infoButtons = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        infoButtons.forEach(button => {
            new bootstrap.Tooltip(button);
        });
        
        // Track service button clicks
        const trackButtons = document.querySelectorAll('.btn-outline-primary');
        trackButtons.forEach(button => {
            button.addEventListener('click', function() {
                const service = this.closest('tr').querySelector('td:first-child').textContent;
                showNotification(`Tracking details for ${service} will be displayed here.`, 'info');
            });
        });
    });
</script>
@endsection