-- Database: class_management_db

CREATE DATABASE IF NOT EXISTS class_management_db;
USE class_management_db;

-- 1. Announcements Table
CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date_posted DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2. LMS Reminders Table (Quizzes/Assignments)
CREATE TABLE IF NOT EXISTS reminders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type ENUM('Quiz', 'Assignment') NOT NULL,
    due_date DATETIME NOT NULL,
    description TEXT
);

-- 3. Class Resources Table
CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    category ENUM('PDF', 'Slides', 'Past Papers') NOT NULL,
    upload_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. Faculty Information Table
CREATE TABLE IF NOT EXISTS faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    profile_pic VARCHAR(255) DEFAULT 'default_faculty.png'
);

-- 5. Lecture Schedule Table
CREATE TABLE IF NOT EXISTS schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    subject VARCHAR(100) NOT NULL,
    teacher VARCHAR(100) NOT NULL,
    room VARCHAR(100),
    start_time TIME NOT NULL,
    end_time TIME NOT NULL
);

-- 6. Gallery Table
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    image_path VARCHAR(255) NOT NULL,
    event_date DATE
);

-- 7. Feedback Table
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT NOT NULL,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 8. Users Table for Authentication & RBAC
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'CR/GR', 'Teacher', 'Student') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert Specific Users (Passwords are '1234')
-- Admin: admin12 / 1234
-- CR: crhuzaifa21 / 1234
-- GR: grkhizra20 / 1234
INSERT INTO users (username, password, role, full_name, email) VALUES 
('admin12', '1234', 'Admin', 'Chief Administrator', 'admin@classhub.edu'),
('crhuzaifa21', '1234', 'CR/GR', 'Huzaifa (CR)', 'huzaifa@classhub.edu'),
('grkhizra20', '1234', 'CR/GR', 'Khizra (GR)', 'khizra@classhub.edu'),
('student1', '1234', 'Student', 'Sample Student', 'student@classhub.edu');

INSERT INTO schedule (day, subject, teacher, room, start_time, end_time) VALUES
-- Monday
('Monday', 'AINT-2101-Knowledge Representation and Reasoning', 'Mr. Muhammad Adeel Abid', 'TB.1.10L-Class Room', '09:00:00', '10:30:00'),
('Monday', 'AINT-2201-Knowledge Representation and Reasoning-Lab (B)', 'Mr. Inzimam Shahid', 'TB.1.10L-Class Room', '10:30:00', '12:00:00'),
('Monday', 'SSCI-2131-Civics and Community Engagement', 'Ms. LARAIB MARYAM', 'TB.1.01L-Class Room', '12:00:00', '13:30:00'),

-- Tuesday
('Tuesday', 'COSC-2112-Artificial Intelligence', 'Dr. Muhammad Shadab Alam Hashmi', 'TB.1.10L-Class Room', '09:00:00', '10:30:00'),
('Tuesday', 'INFT-4126-Professional Practices', 'Mr. Hassan Saleem', 'TB.1.10L-Class Room', '10:30:00', '12:00:00'),
('Tuesday', 'COSC-1104-Software Engineering', 'Ms. Rida Fatima', 'TB.1.10L-Class Room', '12:00:00', '13:30:00'),
('Tuesday', 'COSC-2212-Artificial Intelligence-Lab', 'Mr. Usman Shafeeq', 'COSC.1.06R-CS Lab', '13:30:00', '15:00:00'),
('Tuesday', 'COSC-2203-Database Systems-Lab', 'Ms. Maria Mansab', 'ELEN.1.04R-Engineering Computer Lab', '15:00:00', '16:30:00'),

-- Wednesday
('Wednesday', 'COSC-2212-Artificial Intelligence-Lab (B)', 'Mr. Usman Shafeeq', 'TB.1.10L-Class Room', '13:30:00', '15:00:00'),
('Wednesday', 'COSC-2103-Database Systems', 'Ms. Maria Mansab', 'TB.1.10L-Class Room', '15:00:00', '16:30:00'),

-- Thursday
('Thursday', 'COSC-1104-Software Engineering', 'Ms. Rida Fatima', 'CSIT.1.03L-Lecture Theater', '09:00:00', '10:30:00'),
('Thursday', 'COSC-2103-Database Systems', 'Ms. Maria Mansab', 'TB.2.01L-Class Room', '10:30:00', '12:00:00'),
('Thursday', 'AINT-2201-Knowledge Representation and Reasoning-Lab', 'Mr. Inzimam Shahid', 'COSC.2.05L-Microprocessor Lab', '12:00:00', '13:30:00'),
('Thursday', 'ISLS-1140-Seerat of Holy Prophet Muhammad (SAW)', 'Mr. Muhammad Sohaib Aslam', 'TB.1.10L-Class Room', '13:30:00', '15:00:00'),
('Thursday', 'COSC-2203-Database Systems-Lab (B)', 'Ms. Maria Mansab', 'TB.1.10L-Class Room', '15:00:00', '16:30:00'),

-- Friday
('Friday', 'Friday Prayer', '-', '-', '13:30:00', '14:00:00');
