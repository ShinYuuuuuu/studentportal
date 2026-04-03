-- Student Portal Database Schema
-- Created: 2024-03-15

-- Users/Students table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    program VARCHAR(100),
    year_level VARCHAR(20),
    section VARCHAR(20),
    status ENUM('active', 'inactive', 'graduated') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_student_id (student_id),
    INDEX idx_email (email)
);

-- User sessions for security
CREATE TABLE IF NOT EXISTS user_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_session_token (session_token),
    INDEX idx_user_id (user_id)
);

-- Courses/Subjects table
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    units INT NOT NULL,
    description TEXT,
    semester VARCHAR(20),
    academic_year VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_course_code (course_code)
);

-- Student grades table
CREATE TABLE IF NOT EXISTS grades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    grade DECIMAL(3,2) NOT NULL,
    equivalent VARCHAR(20),
    remarks VARCHAR(50),
    semester VARCHAR(20),
    academic_year VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_grade_entry (student_id, course_id, semester, academic_year),
    INDEX idx_student_course (student_id, course_id)
);

-- Schedule/Class schedule table
CREATE TABLE IF NOT EXISTS schedule (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    day_of_week ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    room VARCHAR(50),
    instructor VARCHAR(100),
    schedule_type ENUM('lecture', 'laboratory', 'recitation', 'consultation') DEFAULT 'lecture',
    semester VARCHAR(20),
    academic_year VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    INDEX idx_course_schedule (course_id, day_of_week)
);

-- Student enrollment table
CREATE TABLE IF NOT EXISTS enrollment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'completed') DEFAULT 'pending',
    semester VARCHAR(20),
    academic_year VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, course_id, semester, academic_year),
    INDEX idx_student_enrollment (student_id, status)
);

-- Service requests table
CREATE TABLE IF NOT EXISTS service_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    service_name VARCHAR(100) NOT NULL,
    request_details TEXT,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    estimated_completion DATE,
    actual_completion DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_student_services (student_id, status)
);

-- Announcements table
CREATE TABLE IF NOT EXISTS announcements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    announcement_type ENUM('general', 'academic', 'financial', 'event') DEFAULT 'general',
    start_date DATE NOT NULL,
    end_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_active_announcements (is_active, start_date)
);

-- Documents/Files table
CREATE TABLE IF NOT EXISTS documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    document_name VARCHAR(200) NOT NULL,
    document_type VARCHAR(50) NOT NULL,
    file_path VARCHAR(500),
    file_size VARCHAR(20),
    category VARCHAR(50),
    downloads_count INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    uploaded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_document_category (category, is_active)
);

-- User activity log
CREATE TABLE IF NOT EXISTS activity_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    activity_type VARCHAR(50) NOT NULL,
    activity_details TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_activity (user_id, created_at)
);

-- Insert sample data for testing

-- Sample user
INSERT INTO users (student_id, first_name, last_name, email, password_hash, phone, program, year_level, section) VALUES
('2023-00123', 'Reynante', 'Dela Cruz', 'reynante.delacruz@student.edu', '$2y$10$YourHashedPasswordHere', '+63 912 345 6789', 'Bachelor of Science in Computer Science', '3rd Year', 'CS-3A');

-- Sample courses
INSERT INTO courses (course_code, course_name, units, semester, academic_year) VALUES
('MATH101', 'Mathematics 101', 3, '2nd', '2023-2024'),
('ENG101', 'English Composition', 3, '2nd', '2023-2024'),
('CS101', 'Programming Fundamentals', 3, '2nd', '2023-2024'),
('CS201', 'Data Structures', 3, '2nd', '2023-2024'),
('CS202', 'Database Management', 3, '2nd', '2023-2024'),
('CS301', 'Web Development', 3, '2nd', '2023-2024');

-- Sample grades
INSERT INTO grades (student_id, course_id, grade, equivalent, remarks, semester, academic_year) VALUES
(1, 1, 1.75, 'Excellent', 'Passed', '2nd', '2023-2024'),
(1, 2, 2.00, 'Very Good', 'Passed', '2nd', '2023-2024'),
(1, 3, 1.50, 'Excellent', 'Passed', '2nd', '2023-2024'),
(1, 4, 2.25, 'Good', 'Passed', '2nd', '2023-2024'),
(1, 5, 1.75, 'Excellent', 'Passed', '2nd', '2023-2024'),
(1, 6, 2.00, 'Very Good', 'Passed', '2nd', '2023-2024');

-- Sample schedule
INSERT INTO schedule (course_id, day_of_week, start_time, end_time, room, instructor, schedule_type, semester, academic_year) VALUES
(1, 'monday', '08:00:00', '09:30:00', '301', 'Dr. Smith', 'lecture', '2nd', '2023-2024'),
(6, 'monday', '10:00:00', '11:30:00', 'Lab 204', 'Prof. Johnson', 'laboratory', '2nd', '2023-2024'),
(4, 'tuesday', '09:00:00', '10:30:00', '302', 'Ms. Davis', 'lecture', '2nd', '2023-2024'),
(2, 'tuesday', '13:00:00', '14:30:00', '105', 'Dr. Wilson', 'lecture', '2nd', '2023-2024'),
(3, 'wednesday', '08:00:00', '11:00:00', 'Lab 205', 'Prof. Brown', 'laboratory', '2nd', '2023-2024'),
(5, 'thursday', '10:00:00', '11:30:00', '303', 'Dr. Taylor', 'lecture', '2nd', '2023-2024'),
(1, 'thursday', '14:00:00', '15:30:00', '301', 'Dr. Smith', 'recitation', '2nd', '2023-2024');

-- Sample announcements
INSERT INTO announcements (title, content, announcement_type, start_date, end_date) VALUES
('Midterm Exam Schedule', 'Midterm exams will be from March 20-25. Please check your schedule.', 'academic', '2024-03-15', '2024-03-25'),
('Enrollment Extension', 'Enrollment period extended until March 18.', 'academic', '2024-03-10', '2024-03-18'),
('Tuition Fee Payment', 'Last day for tuition fee payment is March 20.', 'financial', '2024-03-01', '2024-03-20'),
('Career Fair 2024', 'Annual Career Fair will be held on March 25.', 'event', '2024-03-01', '2024-03-25');

-- Sample documents
INSERT INTO documents (document_name, document_type, file_size, category, downloads_count) VALUES
('Clearance Form', 'PDF', '245 KB', 'forms', 8),
('Enrollment Form', 'PDF', '312 KB', 'forms', 6),
('Grade Slip Template', 'Excel', '45 KB', 'academic', 4),
('Thesis Guidelines', 'PDF', '1.2 MB', 'academic', 3),
('Student Handbook', 'PDF', '3.5 MB', 'guides', 5),
('Course Syllabus', 'PDF', '890 KB', 'academic', 2);