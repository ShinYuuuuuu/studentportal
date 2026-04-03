@extends('layouts.app')

@section('title', 'Downloads')

@section('content')
<div class="container">
    <!-- Downloads Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h2 mb-1">Downloads</h1>
                            <p class="mb-0 opacity-75">Forms, documents, and resources for students</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="alert alert-light d-inline-flex align-items-center mb-0">
                                <i class="bi bi-cloud-arrow-down me-2 text-primary"></i>
                                <div>
                                    <strong>{{ count($documents) }} Files</strong><br>
                                    <small>Available for download</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Search documents..." id="document-search">
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="document-filter">
                <option value="all">All Documents</option>
                <option value="pdf">PDF Files</option>
                <option value="excel">Excel Files</option>
                <option value="forms">Forms</option>
                <option value="guides">Guides</option>
            </select>
        </div>
    </div>

    <!-- Document Categories -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Document Categories</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card border hover-shadow text-center p-3">
                                    <i class="bi bi-file-text fs-1 text-primary mb-2"></i>
                                    <h6 class="mb-1">Forms</h6>
                                    <small class="text-muted">12 documents</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card border hover-shadow text-center p-3">
                                    <i class="bi bi-journal-text fs-1 text-success mb-2"></i>
                                    <h6 class="mb-1">Academic</h6>
                                    <small class="text-muted">8 documents</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card border hover-shadow text-center p-3">
                                    <i class="bi bi-receipt fs-1 text-info mb-2"></i>
                                    <h6 class="mb-1">Financial</h6>
                                    <small class="text-muted">5 documents</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="card border hover-shadow text-center p-3">
                                    <i class="bi bi-book fs-1 text-warning mb-2"></i>
                                    <h6 class="mb-1">Guides</h6>
                                    <small class="text-muted">10 documents</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Available Documents</h4>
                        <span class="badge bg-primary">{{ count($documents) }} files</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Document Name</th>
                                    <th style="width: 15%">Type</th>
                                    <th style="width: 15%">Size</th>
                                    <th style="width: 15%">Date</th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="documents-list">
                                @foreach($documents as $document)
                                <tr class="document-row" data-type="{{ strtolower($document['type']) }}" data-name="{{ strtolower($document['name']) }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light p-2 me-3">
                                                @if($document['type'] == 'PDF')
                                                <i class="bi bi-file-pdf text-danger"></i>
                                                @elseif($document['type'] == 'Excel')
                                                <i class="bi bi-file-excel text-success"></i>
                                                @else
                                                <i class="bi bi-file-text text-primary"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $document['name'] }}</h6>
                                                <small class="text-muted">{{ $document['type'] }} Document</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($document['type'] == 'PDF') bg-danger
                                            @elseif($document['type'] == 'Excel') bg-success
                                            @else bg-primary @endif">
                                            {{ $document['type'] }}
                                        </span>
                                    </td>
                                    <td>{{ $document['size'] }}</td>
                                    <td>{{ $document['date'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary download-btn" data-file="{{ $document['name'] }}">
                                                <i class="bi bi-download"></i> Download
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#previewModal{{ $loop->index }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Downloads -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Recent Downloads</h4>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Clearance Form.pdf</h6>
                                <small class="text-muted">Downloaded: 2024-03-01</small>
                            </div>
                            <span class="badge bg-success">Completed</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Enrollment Form.pdf</h6>
                                <small class="text-muted">Downloaded: 2024-02-28</small>
                            </div>
                            <span class="badge bg-success">Completed</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Thesis Guidelines.pdf</h6>
                                <small class="text-muted">Downloaded: 2024-02-20</small>
                            </div>
                            <span class="badge bg-success">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Download Statistics -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h4 class="mb-0">Download Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="display-4 fw-bold text-primary">24</div>
                            <p class="text-muted mb-0">Total Downloads</p>
                        </div>
                        <div class="col-6">
                            <div class="display-4 fw-bold text-success">156 MB</div>
                            <p class="text-muted mb-0">Total Size</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="mb-2">Most Downloaded</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Clearance Form.pdf</span>
                            <span class="badge bg-primary">8 downloads</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Enrollment Form.pdf</span>
                            <span class="badge bg-success">6 downloads</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Grade Slip Template.xlsx</span>
                            <span class="badge bg-info">4 downloads</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: 40%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modals -->
    @foreach($documents as $index => $document)
    <div class="modal fade" id="previewModal{{ $index }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $document['name'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="rounded-circle bg-light p-4 d-inline-block mb-3">
                            @if($document['type'] == 'PDF')
                            <i class="bi bi-file-pdf text-danger" style="font-size: 3rem;"></i>
                            @elseif($document['type'] == 'Excel')
                            <i class="bi bi-file-excel text-success" style="font-size: 3rem;"></i>
                            @else
                            <i class="bi bi-file-text text-primary" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                        <h5>{{ $document['name'] }}</h5>
                        <p class="text-muted">{{ $document['type'] }} • {{ $document['size'] }} • {{ $document['date'] }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p>
                            @if(str_contains(strtolower($document['name']), 'clearance'))
                            Official clearance form for student transactions and requirements.
                            @elseif(str_contains(strtolower($document['name']), 'enrollment'))
                            Enrollment form for registering subjects for the semester.
                            @elseif(str_contains(strtolower($document['name']), 'grade'))
                            Template for calculating and recording grades.
                            @elseif(str_contains(strtolower($document['name']), 'thesis'))
                            Guidelines and requirements for thesis submission.
                            @elseif(str_contains(strtolower($document['name']), 'handbook'))
                            Student handbook with policies and regulations.
                            @elseif(str_contains(strtolower($document['name']), 'syllabus'))
                            Course syllabus with learning objectives and schedule.
                            @else
                            Official document from the university.
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Requirements</h6>
                        <ul>
                            <li>Adobe Reader for PDF files</li>
                            <li>Microsoft Excel for .xlsx files</li>
                            <li>Internet connection for download</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary download-btn" data-file="{{ $document['name'] }}" data-bs-dismiss="modal">
                        <i class="bi bi-download me-1"></i> Download Now
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Document search and filter
        const searchInput = document.getElementById('document-search');
        const filterSelect = document.getElementById('document-filter');
        const documentRows = document.querySelectorAll('.document-row');
        
        searchInput.addEventListener('input', filterDocuments);
        filterSelect.addEventListener('change', filterDocuments);
        
        // Download buttons
        const downloadButtons = document.querySelectorAll('.download-btn');
        downloadButtons.forEach(button => {
            button.addEventListener('click', function() {
                const fileName = this.getAttribute('data-file');
                simulateDownload(fileName);
            });
        });
        
        function filterDocuments() {
            const searchTerm = searchInput.value.toLowerCase();
            const filterValue = filterSelect.value;
            
            documentRows.forEach(row => {
                const documentName = row.getAttribute('data-name');
                const documentType = row.getAttribute('data-type');
                
                let matchesSearch = documentName.includes(searchTerm);
                let matchesFilter = filterValue === 'all' || documentType === filterValue;
                
                // Additional filtering logic
                if (filterValue === 'forms' && !documentName.includes('form')) {
                    matchesFilter = false;
                } else if (filterValue === 'guides' && !documentName.includes('guide') && !documentName.includes('handbook')) {
                    matchesFilter = false;
                }
                
                row.style.display = matchesSearch && matchesFilter ? '' : 'none';
            });
        }
        
        function simulateDownload(fileName) {
            showNotification(`Downloading ${fileName}...`, 'info');
            
            // Simulate download delay
            setTimeout(() => {
                showNotification(`${fileName} downloaded successfully!`, 'success');
                
                // Update download statistics (in a real app, this would call an API)
                const totalDownloadsElement = document.querySelector('.display-4.fw-bold.text-primary');
                if (totalDownloadsElement) {
                    const currentCount = parseInt(totalDownloadsElement.textContent);
                    totalDownloadsElement.textContent = (currentCount + 1).toString();
                }
            }, 1500);
        }
    });
</script>
@endsection