// Student Portal JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Mobile navigation active state
    updateMobileNavActiveState();
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Enrollment wizard navigation
    const enrollmentSteps = document.querySelectorAll('.enrollment-step');
    if (enrollmentSteps.length > 0) {
        initializeEnrollmentWizard();
    }

    // Schedule calendar navigation
    const calendarDays = document.querySelectorAll('.calendar-day');
    calendarDays.forEach(function(day) {
        day.addEventListener('click', function() {
            const date = this.getAttribute('data-date');
            if (date) {
                loadScheduleForDate(date);
            }
        });
    });

    // Grade filter functionality
    const gradeFilters = document.querySelectorAll('.grade-filter');
    gradeFilters.forEach(function(filter) {
        filter.addEventListener('click', function(e) {
            e.preventDefault();
            const filterType = this.getAttribute('data-filter');
            filterGrades(filterType);
        });
    });

    // Service request buttons
    const serviceButtons = document.querySelectorAll('.service-request-btn');
    serviceButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const serviceName = this.getAttribute('data-service');
            requestService(serviceName);
        });
    });

    // Countdown timer for deadlines
    initializeDeadlineCountdowns();
    
    // Conversion features - show important notifications
    showImportantNotifications();
    
    // Check for pending tasks and show reminders
    checkPendingTasks();
    
    // Session timeout warning
    initializeSessionTimeoutWarning();
    
    // Performance tracking
    trackUserEngagement();
});

function updateMobileNavActiveState() {
    const currentPath = window.location.pathname;
    const mobileNavLinks = document.querySelectorAll('.fixed-bottom a');
    
    mobileNavLinks.forEach(function(link) {
        const linkPath = link.getAttribute('href');
        if (linkPath === currentPath) {
            link.classList.add('text-primary');
        } else {
            link.classList.remove('text-primary');
        }
    });
}

function initializeEnrollmentWizard() {
    const nextButtons = document.querySelectorAll('.btn-next-step');
    const prevButtons = document.querySelectorAll('.btn-prev-step');
    const steps = document.querySelectorAll('.step');
    
    nextButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const currentStep = this.closest('.enrollment-step');
            const nextStepId = this.getAttribute('data-next');
            const nextStep = document.getElementById(nextStepId);
            
            if (validateStep(currentStep)) {
                currentStep.classList.remove('active');
                nextStep.classList.add('active');
                
                // Update step indicators
                const stepNumber = parseInt(nextStepId.replace('step-', ''));
                updateStepIndicators(stepNumber);
                
                // Scroll to top of step
                nextStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    
    prevButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const currentStep = this.closest('.enrollment-step');
            const prevStepId = this.getAttribute('data-prev');
            const prevStep = document.getElementById(prevStepId);
            
            currentStep.classList.remove('active');
            prevStep.classList.add('active');
            
            // Update step indicators
            const stepNumber = parseInt(prevStepId.replace('step-', ''));
            updateStepIndicators(stepNumber);
            
            // Scroll to top of step
            prevStep.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
}

function updateStepIndicators(currentStep) {
    const steps = document.querySelectorAll('.step');
    steps.forEach(function(step, index) {
        const stepNumber = parseInt(step.textContent);
        
        if (stepNumber < currentStep) {
            step.classList.remove('active');
            step.classList.add('completed');
        } else if (stepNumber === currentStep) {
            step.classList.add('active');
            step.classList.remove('completed');
        } else {
            step.classList.remove('active', 'completed');
        }
    });
}

function validateStep(stepElement) {
    const requiredFields = stepElement.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
            
            // Show error message
            const errorDiv = field.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.style.display = 'block';
            }
        } else {
            field.classList.remove('is-invalid');
            
            // Hide error message
            const errorDiv = field.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.style.display = 'none';
            }
        }
    });
    
    if (!isValid) {
        showNotification('Please fill in all required fields.', 'danger');
    }
    
    return isValid;
}

function loadScheduleForDate(date) {
    // In a real application, this would make an AJAX request
    console.log('Loading schedule for date:', date);
    
    // Show loading state
    const scheduleContent = document.getElementById('schedule-content');
    if (scheduleContent) {
        scheduleContent.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading schedule for ${date}...</p>
            </div>
        `;
        
        // Simulate API call
        setTimeout(() => {
            // This would be replaced with actual data from server
            const mockSchedule = [
                { time: '08:00 AM', subject: 'Mathematics 101', room: 'Room 301', instructor: 'Dr. Smith' },
                { time: '10:00 AM', subject: 'Computer Science', room: 'Lab 204', instructor: 'Prof. Johnson' },
                { time: '01:00 PM', subject: 'English Literature', room: 'Room 105', instructor: 'Ms. Davis' }
            ];
            
            let scheduleHTML = '<div class="list-group">';
            mockSchedule.forEach(item => {
                scheduleHTML += `
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${item.subject}</h6>
                            <small>${item.time}</small>
                        </div>
                        <p class="mb-1">${item.instructor}</p>
                        <small>${item.room}</small>
                    </div>
                `;
            });
            scheduleHTML += '</div>';
            
            scheduleContent.innerHTML = scheduleHTML;
        }, 500);
    }
}

function filterGrades(filterType) {
    const gradeCards = document.querySelectorAll('.grade-card');
    
    gradeCards.forEach(function(card) {
        if (filterType === 'all') {
            card.style.display = 'block';
        } else {
            const grade = parseFloat(card.getAttribute('data-grade'));
            
            if (filterType === 'excellent' && grade <= 1.5) {
                card.style.display = 'block';
            } else if (filterType === 'good' && grade > 1.5 && grade <= 2.0) {
                card.style.display = 'block';
            } else if (filterType === 'average' && grade > 2.0 && grade <= 2.5) {
                card.style.display = 'block';
            } else if (filterType === 'poor' && grade > 2.5) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        }
    });
    
    // Update active filter button
    const filterButtons = document.querySelectorAll('.grade-filter');
    filterButtons.forEach(function(button) {
        if (button.getAttribute('data-filter') === filterType) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });
}

function requestService(serviceName) {
    console.log('Requesting service:', serviceName);
    
    // Show confirmation modal or notification
    showNotification(`Request submitted for ${serviceName}. You will receive a confirmation email shortly.`, 'success');
    
    // In a real application, this would make an AJAX request
    // fetch('/api/services/request', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //     },
    //     body: JSON.stringify({ service: serviceName })
    // })
    // .then(response => response.json())
    // .then(data => {
    //     showNotification(data.message, 'success');
    // })
    // .catch(error => {
    //     showNotification('Failed to submit request. Please try again.', 'danger');
    // });
}

function initializeDeadlineCountdowns() {
    const countdownElements = document.querySelectorAll('.countdown-timer');
    
    countdownElements.forEach(function(element) {
        const deadline = new Date(element.getAttribute('data-deadline')).getTime();
        
        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = deadline - now;
            
            if (timeLeft < 0) {
                element.innerHTML = '<span class="text-danger">Deadline passed</span>';
                return;
            }
            
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            
            element.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            
            // Update urgency color
            if (days < 1) {
                element.classList.add('text-danger');
                element.classList.remove('text-warning');
            } else if (days < 3) {
                element.classList.add('text-warning');
                element.classList.remove('text-danger');
            } else {
                element.classList.remove('text-danger', 'text-warning');
            }
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
}

function showNotification(message, type = 'info') {
    const notificationContainer = document.getElementById('notification-container');
    
    if (!notificationContainer) {
        // Create notification container if it doesn't exist
        const container = document.createElement('div');
        container.id = 'notification-container';
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.right = '20px';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    const alertTypes = {
        'success': 'alert-success',
        'danger': 'alert-danger',
        'warning': 'alert-warning',
        'info': 'alert-info'
    };
    
    const alertClass = alertTypes[type] || 'alert-info';
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${alertClass} alert-dismissible fade show`;
    alertDiv.style.maxWidth = '350px';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.getElementById('notification-container').appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }
    }, 5000);
}

// GPA Calculator
function calculateGPA(grades) {
    if (!grades || grades.length === 0) return 0;
    
    const totalPoints = grades.reduce((sum, grade) => sum + grade.points * grade.units, 0);
    const totalUnits = grades.reduce((sum, grade) => sum + grade.units, 0);
    
    return totalUnits > 0 ? (totalPoints / totalUnits).toFixed(2) : 0;
}

// Format date for display
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Format time for display
function formatTime(timeString) {
    const [hours, minutes] = timeString.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour % 12 || 12;
    return `${displayHour}:${minutes} ${ampm}`;
}

// Conversion Features
function showImportantNotifications() {
    // Check for important deadlines and show notifications
    const today = new Date();
    const enrollmentDeadline = new Date('2024-03-20');
    const daysUntilDeadline = Math.ceil((enrollmentDeadline - today) / (1000 * 60 * 60 * 24));
    
    if (daysUntilDeadline <= 3 && daysUntilDeadline > 0) {
        showNotification(
            `⚠️ Enrollment deadline in ${daysUntilDeadline} day${daysUntilDeadline > 1 ? 's' : ''}! Complete your enrollment now.`,
            'warning'
        );
    }
    
    // Show welcome notification for first visit
    const firstVisit = !localStorage.getItem('student_portal_visited');
    if (firstVisit) {
        showNotification(
            '👋 Welcome to Student Portal! Find your grades, schedule, and services in ≤ 3 clicks.',
            'info'
        );
        localStorage.setItem('student_portal_visited', 'true');
    }
    
    // Show next class reminder
    const nextClassTime = new Date();
    nextClassTime.setHours(10, 0, 0); // 10:00 AM for demo
    const timeUntilClass = nextClassTime - new Date();
    const hoursUntilClass = Math.floor(timeUntilClass / (1000 * 60 * 60));
    
    if (hoursUntilClass === 1) {
        showNotification('⏰ Next class (Web Development) starts in 1 hour!', 'info');
    }
}

function checkPendingTasks() {
    // In a real app, this would fetch from API
    const pendingTasks = [
        { task: 'Submit thesis proposal', deadline: '2024-03-20', priority: 'high' },
        { task: 'Pay tuition fee', deadline: '2024-03-18', priority: 'high' },
        { task: 'Complete clearance form', deadline: '2024-03-22', priority: 'medium' }
    ];
    
    const today = new Date().toISOString().split('T')[0];
    const urgentTasks = pendingTasks.filter(task => {
        const taskDate = new Date(task.deadline);
        const todayDate = new Date(today);
        const daysUntilDeadline = Math.ceil((taskDate - todayDate) / (1000 * 60 * 60 * 24));
        return daysUntilDeadline <= 2 && task.priority === 'high';
    });
    
    if (urgentTasks.length > 0) {
        setTimeout(() => {
            showNotification(
                `🚨 You have ${urgentTasks.length} urgent task${urgentTasks.length > 1 ? 's' : ''} due soon! Check your dashboard.`,
                'danger'
            );
        }, 2000);
    }
}

function initializeSessionTimeoutWarning() {
    // Show warning 1 minute before session timeout (demo: 5 minutes)
    const timeoutMinutes = 5;
    const warningMinutes = 1;
    
    setTimeout(() => {
        showNotification(
            `⏳ Your session will expire in ${warningMinutes} minute${warningMinutes > 1 ? 's' : ''}. Save your work.`,
            'warning'
        );
    }, (timeoutMinutes - warningMinutes) * 60 * 1000);
}

function trackUserEngagement() {
    // Track page views and important actions
    const startTime = new Date();
    
    // Track clicks on important conversion elements
    const conversionElements = document.querySelectorAll(
        '.quick-action-btn, .btn-primary, .btn-success, .service-request-btn, .download-btn'
    );
    
    conversionElements.forEach(element => {
        element.addEventListener('click', function() {
            const action = this.textContent.trim() || this.getAttribute('data-service') || 'Unknown Action';
            console.log(`Conversion tracked: ${action}`);
            
            // In a real app, send to analytics
            // trackConversion(action);
        });
    });
    
    // Track time on page
    window.addEventListener('beforeunload', function() {
        const endTime = new Date();
        const timeSpent = Math.round((endTime - startTime) / 1000);
        console.log(`Time spent on page: ${timeSpent} seconds`);
        
        // In a real app, send to analytics
        // trackTimeSpent(timeSpent);
    });
}

// Prompt user to complete profile if incomplete
function checkProfileCompletion() {
    const profileCompletion = localStorage.getItem('profile_completion') || '0%';
    
    if (profileCompletion !== '100%') {
        setTimeout(() => {
            const completeProfile = confirm('📝 Your profile is incomplete! Complete it now to access all features.');
            if (completeProfile) {
                window.location.href = '/profile';
            }
        }, 5000);
    }
}

// Show achievement notifications
function showAchievementNotifications() {
    const achievements = localStorage.getItem('achievements') ? JSON.parse(localStorage.getItem('achievements')) : [];
    
    // Demo achievements
    const possibleAchievements = [
        { id: 'first_login', title: 'Welcome!', message: 'You successfully logged in for the first time!' },
        { id: 'view_grades', title: 'Grade Viewer', message: 'You viewed your grades 5 times!' },
        { id: 'complete_enrollment', title: 'Enrollment Pro', message: 'You completed enrollment successfully!' }
    ];
    
    possibleAchievements.forEach(achievement => {
        if (!achievements.includes(achievement.id)) {
            // In a real app, check if achievement conditions are met
            // For demo, show random achievement
            if (Math.random() > 0.7) {
                showNotification(`🏆 Achievement unlocked: ${achievement.title} - ${achievement.message}`, 'success');
                achievements.push(achievement.id);
                localStorage.setItem('achievements', JSON.stringify(achievements));
            }
        }
    });
}

// Initialize conversion features on page load
window.addEventListener('load', function() {
    // Wait a bit for page to fully load
    setTimeout(() => {
        checkProfileCompletion();
        showAchievementNotifications();
        
        // Show survey prompt after 30 seconds
        setTimeout(() => {
            if (Math.random() > 0.5) { // 50% chance to show survey
                showNotification(
                    '📋 Help us improve! Take a 1-minute survey about your experience.',
                    'info',
                    10000 // Show for 10 seconds
                );
            }
        }, 30000);
    }, 1000);
});