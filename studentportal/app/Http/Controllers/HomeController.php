<?php

namespace App\Http\Controllers;

class HomeController
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function renderView($view, $data = [])
    {
        extract($data);

        // Render the view content
        ob_start();
        $viewFile = __DIR__ . "/../../../resources/views/{$view}.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "<h1>View not found: {$view}</h1>";
        }
        $content = ob_get_clean();

        // Render the layout
        ob_start();
        $layoutFile = __DIR__ . "/../../../resources/views/layouts/app.php";
        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            echo $content; // Fallback if layout doesn't exist
        }

        return ob_get_clean();
    }

    public function index()
    {
        // Mock data for dashboard
        $student = [
            'name' => 'Reynante',
            'id' => '2023-00123',
            'program' => 'Bachelor of Science in Computer Science',
            'year_level' => '3rd Year',
            'section' => 'CS-3A'
        ];

        $summary = [
            'gpa' => 1.75,
            'next_class' => [
                'subject' => 'Web Development',
                'time' => '10:00 AM',
                'room' => 'Lab 204',
                'instructor' => 'Prof. Johnson'
            ],
            'announcements' => [
                [
                    'title' => 'Midterm Exam Schedule',
                    'date' => '2024-03-15',
                    'content' => 'Midterm exams will be from March 20-25. Please check your schedule.'
                ],
                [
                    'title' => 'Enrollment Extension',
                    'date' => '2024-03-10',
                    'content' => 'Enrollment period extended until March 18.'
                ]
            ],
            'pending_tasks' => [
                ['task' => 'Submit thesis proposal', 'deadline' => '2024-03-20'],
                ['task' => 'Pay tuition fee', 'deadline' => '2024-03-18'],
                ['task' => 'Complete clearance form', 'deadline' => '2024-03-22']
            ]
        ];

        $quickActions = [
            ['icon' => 'bi-bar-chart', 'label' => 'View Grades', 'url' => '/grades', 'color' => 'primary'],
            ['icon' => 'bi-calendar-week', 'label' => 'View Schedule', 'url' => '/schedule', 'color' => 'success'],
            ['icon' => 'bi-clipboard-check', 'label' => 'Enroll Now', 'url' => '/enrollment', 'color' => 'warning'],
            ['icon' => 'bi-download', 'label' => 'Download Forms', 'url' => '/downloads', 'color' => 'info']
        ];

        $recentActivity = [
            ['type' => 'grade_view', 'subject' => 'Mathematics 101', 'time' => '2 hours ago'],
            ['type' => 'file_download', 'file' => 'Clearance Form.pdf', 'time' => '1 day ago'],
            ['type' => 'enrollment', 'action' => 'Added Web Development', 'time' => '2 days ago']
        ];

        echo $this->renderView('pages/dashboard', compact('student', 'summary', 'quickActions', 'recentActivity'));
    }

    public function grades()
    {
        $grades = [
            [
                'subject' => 'Mathematics 101',
                'code' => 'MATH101',
                'units' => 3,
                'grade' => 1.75,
                'equivalent' => 'Excellent',
                'remarks' => 'Passed'
            ],
            [
                'subject' => 'English Composition',
                'code' => 'ENG101',
                'units' => 3,
                'grade' => 2.00,
                'equivalent' => 'Very Good',
                'remarks' => 'Passed'
            ],
            [
                'subject' => 'Programming Fundamentals',
                'code' => 'CS101',
                'units' => 3,
                'grade' => 1.50,
                'equivalent' => 'Excellent',
                'remarks' => 'Passed'
            ],
            [
                'subject' => 'Data Structures',
                'code' => 'CS201',
                'units' => 3,
                'grade' => 2.25,
                'equivalent' => 'Good',
                'remarks' => 'Passed'
            ],
            [
                'subject' => 'Database Management',
                'code' => 'CS202',
                'units' => 3,
                'grade' => 1.75,
                'equivalent' => 'Excellent',
                'remarks' => 'Passed'
            ],
            [
                'subject' => 'Web Development',
                'code' => 'CS301',
                'units' => 3,
                'grade' => 2.00,
                'equivalent' => 'Very Good',
                'remarks' => 'Passed'
            ]
        ];

        $gpa = 1.85;
        $totalUnits = 18;
        $semester = '2nd Semester AY 2023-2024';

        echo $this->renderView('pages.grades', compact('grades', 'gpa', 'totalUnits', 'semester'));
    }

    public function schedule()
    {
        $currentWeek = [
            'monday' => [
                ['time' => '08:00-09:30', 'subject' => 'Mathematics 101', 'room' => '301', 'type' => 'Lecture'],
                ['time' => '10:00-11:30', 'subject' => 'Web Development', 'room' => 'Lab 204', 'type' => 'Laboratory']
            ],
            'tuesday' => [
                ['time' => '09:00-10:30', 'subject' => 'Data Structures', 'room' => '302', 'type' => 'Lecture'],
                ['time' => '13:00-14:30', 'subject' => 'English Composition', 'room' => '105', 'type' => 'Lecture']
            ],
            'wednesday' => [
                ['time' => '08:00-11:00', 'subject' => 'Programming Lab', 'room' => 'Lab 205', 'type' => 'Laboratory']
            ],
            'thursday' => [
                ['time' => '10:00-11:30', 'subject' => 'Database Management', 'room' => '303', 'type' => 'Lecture'],
                ['time' => '14:00-15:30', 'subject' => 'Mathematics 101', 'room' => '301', 'type' => 'Recitation']
            ],
            'friday' => [
                ['time' => '09:00-12:00', 'subject' => 'Thesis Consultation', 'room' => 'Faculty Room', 'type' => 'Consultation']
            ]
        ];

        $nextClass = [
            'subject' => 'Web Development',
            'time' => '10:00 AM',
            'room' => 'Lab 204',
            'instructor' => 'Prof. Johnson',
            'starts_in' => '30 minutes'
        ];

        echo $this->renderView('pages.schedule', compact('currentWeek', 'nextClass'));
    }

    public function enrollment()
    {
        $availableSubjects = [
            ['code' => 'CS401', 'name' => 'Software Engineering', 'units' => 3, 'schedule' => 'MWF 10:00-11:30'],
            ['code' => 'CS402', 'name' => 'Mobile Development', 'units' => 3, 'schedule' => 'TTH 13:00-14:30'],
            ['code' => 'CS403', 'name' => 'Networking', 'units' => 3, 'schedule' => 'MWF 08:00-09:30'],
            ['code' => 'CS404', 'name' => 'AI Fundamentals', 'units' => 3, 'schedule' => 'TTH 10:00-11:30'],
            ['code' => 'MATH201', 'name' => 'Calculus II', 'units' => 3, 'schedule' => 'MWF 13:00-14:30'],
            ['code' => 'ENG201', 'name' => 'Technical Writing', 'units' => 3, 'schedule' => 'TTH 08:00-09:30']
        ];

        $selectedSubjects = [];
        $enrollmentDeadline = '2024-03-20';

        echo $this->renderView('pages.enrollment', compact('availableSubjects', 'selectedSubjects', 'enrollmentDeadline'));
    }

    public function services()
    {
        $categories = [
            'Academic Requests' => [
                ['name' => 'Request TOR', 'description' => 'Transcript of Records', 'processing_time' => '3-5 working days'],
                ['name' => 'Request Diploma', 'description' => 'Official Diploma', 'processing_time' => '5-7 working days'],
                ['name' => 'Request Certificate', 'description' => 'Various certificates', 'processing_time' => '2-3 working days'],
                ['name' => 'Change of Schedule', 'description' => 'Modify class schedule', 'processing_time' => '1-2 working days']
            ],
            'Financial' => [
                ['name' => 'Pay Tuition', 'description' => 'Tuition fee payment', 'processing_time' => 'Immediate'],
                ['name' => 'View Balance', 'description' => 'Check account balance', 'processing_time' => 'Immediate'],
                ['name' => 'Request Refund', 'description' => 'Tuition refund', 'processing_time' => '7-10 working days'],
                ['name' => 'Scholarship Application', 'description' => 'Apply for scholarship', 'processing_time' => '10-15 working days']
            ],
            'Documents' => [
                ['name' => 'Apply Clearance', 'description' => 'Student clearance', 'processing_time' => '2-3 working days'],
                ['name' => 'Request ID', 'description' => 'Student ID replacement', 'processing_time' => '3-5 working days'],
                ['name' => 'Library Clearance', 'description' => 'Library account clearance', 'processing_time' => '1 working day'],
                ['name' => 'Laboratory Clearance', 'description' => 'Lab equipment clearance', 'processing_time' => '1 working day']
            ]
        ];

        echo $this->renderView('pages.services', compact('categories'));
    }

    public function profile()
    {
        $student = [
            'name' => 'Reynante Dela Cruz',
            'student_id' => '2023-00123',
            'email' => 'reynante.delacruz@student.edu',
            'phone' => '+63 912 345 6789',
            'program' => 'Bachelor of Science in Computer Science',
            'year_level' => '3rd Year',
            'section' => 'CS-3A',
            'admission_date' => '2023-08-15',
            'status' => 'Regular',
            'address' => '123 Main Street, City, Province 1234'
        ];

        echo $this->renderView('pages.profile', compact('student'));
    }

    public function downloads()
    {
        $documents = [
            ['name' => 'Clearance Form', 'type' => 'PDF', 'size' => '245 KB', 'date' => '2024-03-01'],
            ['name' => 'Enrollment Form', 'type' => 'PDF', 'size' => '312 KB', 'date' => '2024-02-28'],
            ['name' => 'Grade Slip Template', 'type' => 'Excel', 'size' => '45 KB', 'date' => '2024-02-25'],
            ['name' => 'Thesis Guidelines', 'type' => 'PDF', 'size' => '1.2 MB', 'date' => '2024-02-20'],
            ['name' => 'Student Handbook', 'type' => 'PDF', 'size' => '3.5 MB', 'date' => '2024-02-15'],
            ['name' => 'Course Syllabus', 'type' => 'PDF', 'size' => '890 KB', 'date' => '2024-02-10']
        ];

        echo $this->renderView('pages.downloads', compact('documents'));
    }
}