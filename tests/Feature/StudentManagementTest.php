<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Department $department;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->department = Department::create([
            'dept_name' => 'Computer Science',
            'manager_id' => 'MGR-CS-001',
            'location_id' => 'Room 301',
        ]);
    }

    /** Test 1: Unauthenticated guests are redirected to login */
    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/students');
        $response->assertRedirect('/login');

        $response = $this->get('/departments');
        $response->assertRedirect('/login');
    }

    /** Test 2: User can view login page */
    public function test_user_can_view_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Student Management System');
        $response->assertSee('Sign In');
    }

    /** Test 3: User can register a new account */
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    /** Test 4: User can login */
    public function test_user_can_login_with_valid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->user);
    }

    /** Test 5: User can view dashboard */
    public function test_user_can_view_dashboard()
    {
        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');
        $response->assertSee('Total Students');
    }

    /** Test 6: Create Department (Insert) */
    public function test_user_can_create_department()
    {
        $response = $this->actingAs($this->user)->post('/departments', [
            'dept_name' => 'Electrical Engineering',
            'manager_id' => 'MGR-EE-102',
            'location_id' => 'Building B Lab 4',
        ]);

        $response->assertRedirect('/departments');
        $this->assertDatabaseHas('departments', [
            'dept_name' => 'Electrical Engineering',
            'manager_id' => 'MGR-EE-102',
        ]);
    }

    /** Test 7: Update Department (Update) */
    public function test_user_can_update_department()
    {
        $response = $this->actingAs($this->user)->put("/departments/{$this->department->dept_id}", [
            'dept_name' => 'Computer Science & Software Eng',
            'manager_id' => 'MGR-CS-999',
            'location_id' => 'Tech Tower 5',
        ]);

        $response->assertRedirect('/departments');
        $this->assertDatabaseHas('departments', [
            'dept_id' => $this->department->dept_id,
            'dept_name' => 'Computer Science & Software Eng',
        ]);
    }

    /** Test 8: Delete Department (Delete) */
    public function test_user_can_delete_department()
    {
        $dept = Department::create([
            'dept_name' => 'Temporary Department',
        ]);

        $response = $this->actingAs($this->user)->delete("/departments/{$dept->dept_id}");
        $response->assertRedirect('/departments');
        $this->assertDatabaseMissing('departments', ['dept_id' => $dept->dept_id]);
    }

    /** Test 9: Create Student with Relation to Department (Insert) */
    public function test_user_can_create_student_with_relational_department()
    {
        $response = $this->actingAs($this->user)->post('/students', [
            'student_name' => 'Johnathan Smith',
            'gender' => 'Male',
            'dob' => '2003-05-12',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
            'description' => 'Honors candidate.',
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'student_name' => 'Johnathan Smith',
            'dept_id' => $this->department->dept_id,
            'gender' => 'Male',
        ]);
    }

    /** Test 10: List Students on HTML Table with Department Name */
    public function test_students_index_displays_html_table_with_dept_name()
    {
        $student = Student::create([
            'student_name' => 'Alice Walker',
            'gender' => 'Female',
            'dob' => '2004-02-10',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
            'description' => 'Top student.',
        ]);

        $response = $this->actingAs($this->user)->get('/students');
        $response->assertStatus(200);
        $response->assertSee('Alice Walker');
        $response->assertSee('Computer Science'); // Verifies related Dept_Name on HTML table!
    }

    /** Test 11: Search Students by Name */
    public function test_user_can_search_students_by_name()
    {
        Student::create([
            'student_name' => 'Zachary Taylor',
            'gender' => 'Male',
            'dob' => '2003-01-01',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
        ]);

        Student::create([
            'student_name' => 'Bethany Miller',
            'gender' => 'Female',
            'dob' => '2004-05-05',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
        ]);

        $response = $this->actingAs($this->user)->get('/students?search=Zachary');
        $response->assertStatus(200);
        $response->assertSee('Zachary Taylor');
        $response->assertDontSee('Bethany Miller');
    }

    /** Test 12: Filter Students by Department */
    public function test_user_can_filter_students_by_department()
    {
        $dept2 = Department::create(['dept_name' => 'Mechanical Eng']);

        Student::create([
            'student_name' => 'CS Student',
            'gender' => 'Male',
            'dob' => '2003-01-01',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
        ]);

        Student::create([
            'student_name' => 'Mech Student',
            'gender' => 'Female',
            'dob' => '2004-05-05',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $dept2->dept_id,
        ]);

        $response = $this->actingAs($this->user)->get("/students?dept_id={$dept2->dept_id}");
        $response->assertStatus(200);
        $response->assertSee('Mech Student');
        $response->assertDontSee('CS Student');
    }

    /** Test 13: Update Student (Update) */
    public function test_user_can_update_student()
    {
        $student = Student::create([
            'student_name' => 'Original Name',
            'gender' => 'Male',
            'dob' => '2003-01-01',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
        ]);

        $response = $this->actingAs($this->user)->put("/students/{$student->student_id}", [
            'student_name' => 'Updated Name',
            'gender' => 'Male',
            'dob' => '2003-01-01',
            'enrollment' => 'Graduated',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
            'description' => 'Updated description.',
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'student_id' => $student->student_id,
            'student_name' => 'Updated Name',
            'enrollment' => 'Graduated',
        ]);
    }

    /** Test 14: Delete Student (Delete) */
    public function test_user_can_delete_student()
    {
        $student = Student::create([
            'student_name' => 'To Delete',
            'gender' => 'Female',
            'dob' => '2003-01-01',
            'enrollment' => 'Active',
            'enrollment_date' => '2023-09-01',
            'dept_id' => $this->department->dept_id,
        ]);

        $response = $this->actingAs($this->user)->delete("/students/{$student->student_id}");
        $response->assertRedirect('/students');
        $this->assertDatabaseMissing('students', ['student_id' => $student->student_id]);
    }
}
