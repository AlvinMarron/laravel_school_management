# Student Management System - Laravel 13 Project Final

A modern, relational Student Management System built using **Laravel 13**, **PHP 8.3+**, and **Bootstrap 5**.

---

## 📋 Student & Project Submission Information

- **Full Name:** Alvin Marron
- **GitHub Username:** AlvinMarron
- **Repository URL:** https://github.com/AlvinMarron/laravel_school_management.git
- **Course:** Web Development / Final Project
- **Project Topic:** Option 1 - Student Management System
- **Framework:** Laravel 13
- **Database:** SQLite (default zero-configuration) / MySQL ready
- **Demo Credentials:**
  - **Email:** `admin@example.com`
  - **Password:** `password123`

---

## 🌟 System Requirements & Features Implemented

### 1. Authentication System (Login & Register)
- Custom authentication built with standard Laravel session security and CSRF protection.
- **Login View:** `/login` - with email, password, "remember me", and sample demo login credentials.
- **Register View:** `/register` - with full name, email validation (unique), password confirmation.
- **Protected Routes:** All CRUD and dashboard routes are guarded by the `auth` middleware.
- **Logout:** Secure POST logout with session invalidation and token regeneration.

### 2. Relational Database Migrations & Eloquent Models
Implements the exact relational schema requested:

#### A. Table `departments` (Primary Key: `dept_id`)
| Column | Type | Description |
|---|---|---|
| `dept_id` | BIGINT (PK) | Auto-increment primary key |
| `dept_name` | VARCHAR(255) | Unique name of the academic department |
| `manager_id` | VARCHAR(100) | Head of department / Manager identifier |
| `location_id` | VARCHAR(150) | Office, building, or room location |
| `created_at` | TIMESTAMP | Creation timestamp |
| `updated_at` | TIMESTAMP | Last update timestamp |

#### B. Table `students` (Foreign Key: `dept_id` referencing `departments.dept_id`)
| Column | Type | Description |
|---|---|---|
| `student_id` | BIGINT (PK) | Auto-increment primary key |
| `student_name` | VARCHAR(255) | Full name of the student |
| `gender` | VARCHAR(20) | Male, Female, Other |
| `dob` | DATE | Date of Birth |
| `enrollment` | VARCHAR(50) | Enrollment status (Active, Graduated, Suspended, Pending) |
| `enrollment_date` | DATE | Date of enrollment |
| `description` | TEXT | Detailed background remarks and notes |
| `dept_id` | BIGINT (FK) | References `departments(dept_id)` with `onDelete('cascade')` |
| `created_at` | TIMESTAMP | Creation timestamp |
| `updated_at` | TIMESTAMP | Last update timestamp |

#### Connected Models:
- `App\Models\Department`:
  - Primary key: `dept_id`
  - Relationship: `students()` returns `hasMany(Student::class, 'dept_id', 'dept_id')`
- `App\Models\Student`:
  - Primary key: `student_id`
  - Relationship: `department()` returns `belongsTo(Department::class, 'dept_id', 'dept_id')`

---

### 3. CRUD Operations with Search & Filter
- **Departments CRUD:**
  - **List:** Search by department name, manager, or location with student count badges.
  - **Create:** Form to add a new department with unique validation.
  - **Show:** Detailed view of department profile + HTML Table of all students enrolled in it.
  - **Edit / Update:** Form to modify department name and details.
  - **Delete:** Safe delete with confirmation modal and warning.
- **Students CRUD:**
  - **Search:** Instant query filter by `student_name` or description.
  - **Multi-Filter:** Filter simultaneously by `dept_id` (Department), `gender`, and `enrollment` status.
  - **HTML Table:** Displays `student_id`, `student_name`, `gender`, `dob`, **`dept_name`** (from related departments table), `enrollment`, `enrollment_date`, and `description`.
  - **Create:** Form with department dropdown populated dynamically from the database.
  - **Show:** Detailed profile card with computed age, department location, and timestamps.
  - **Edit / Update:** Pre-populated edit form.
  - **Delete:** Modal confirmation delete.

---

### 4. Database Seeding
Pre-configured with realistic academic seeders:
- `UserSeeder`: Creates default administrator (`admin@example.com` / `password123`) and officer accounts.
- `DepartmentSeeder`: Seeds 6 realistic academic faculties (Computer Science, Software Engineering, Business Administration, Electrical Engineering, Civil Engineering, Digital Arts).
- `StudentSeeder`: Seeds 12 diverse student records properly linked to department IDs.

---

## 🚀 Quick Setup & Run Instructions

### 1. Prerequisites
- PHP 8.2 or 8.3+
- Composer



Open your browser at: **`http://localhost:8000`**

Login with:
- **Email:** `admin@example.com`
- **Password:** `password123`

---


