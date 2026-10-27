<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'student_name' => 'Alexander Hayes',
                'gender' => 'Male',
                'dob' => '2003-04-15',
                'enrollment' => 'Active',
                'enrollment_date' => '2022-09-01',
                'description' => 'Specializing in Artificial Intelligence and Machine Learning research.',
                'dept_id' => 1,
            ],
            [
                'student_name' => 'Sophia Williams',
                'gender' => 'Female',
                'dob' => '2004-01-22',
                'enrollment' => 'Active',
                'enrollment_date' => '2023-01-15',
                'description' => 'Dean’s Honor List. President of the University Coding Club.',
                'dept_id' => 2,
            ],
            [
                'student_name' => 'Marcus Chen',
                'gender' => 'Male',
                'dob' => '2002-11-08',
                'enrollment' => 'Active',
                'enrollment_date' => '2021-09-01',
                'description' => 'Focusing on Enterprise Cloud Architecture and DevOps pipelines.',
                'dept_id' => 2,
            ],
            [
                'student_name' => 'Emily Johnson',
                'gender' => 'Female',
                'dob' => '2003-08-30',
                'enrollment' => 'Active',
                'enrollment_date' => '2022-09-01',
                'description' => 'Majoring in Financial Analytics & Strategic Marketing.',
                'dept_id' => 3,
            ],
            [
                'student_name' => 'David Kim',
                'gender' => 'Male',
                'dob' => '2002-05-19',
                'enrollment' => 'Active',
                'enrollment_date' => '2021-09-01',
                'description' => 'Embedded systems enthusiast and IoT robotics competition winner.',
                'dept_id' => 4,
            ],
            [
                'student_name' => 'Olivia Taylor',
                'gender' => 'Female',
                'dob' => '2004-07-12',
                'enrollment' => 'Active',
                'enrollment_date' => '2023-09-01',
                'description' => 'Specializing in Structural Analysis and Green Building Design.',
                'dept_id' => 5,
            ],
            [
                'student_name' => 'Liam Martinez',
                'gender' => 'Male',
                'dob' => '2003-12-05',
                'enrollment' => 'Active',
                'enrollment_date' => '2022-09-01',
                'description' => '3D Animation and UI/UX Interactive Media specialist.',
                'dept_id' => 6,
            ],
            [
                'student_name' => 'Ava Robinson',
                'gender' => 'Female',
                'dob' => '2001-03-18',
                'enrollment' => 'Graduated',
                'enrollment_date' => '2020-09-01',
                'description' => 'Graduated Summa Cum Laude with First Class Honors.',
                'dept_id' => 1,
            ],
            [
                'student_name' => 'Lucas Anderson',
                'gender' => 'Male',
                'dob' => '2004-09-25',
                'enrollment' => 'Active',
                'enrollment_date' => '2023-09-01',
                'description' => 'Interested in Cybersecurity and Penetration Testing.',
                'dept_id' => 1,
            ],
            [
                'student_name' => 'Isabella Davis',
                'gender' => 'Female',
                'dob' => '2003-02-14',
                'enrollment' => 'Active',
                'enrollment_date' => '2022-01-10',
                'description' => 'Leading student delegate at International Business Summit.',
                'dept_id' => 3,
            ],
            [
                'student_name' => 'Noah Wilson',
                'gender' => 'Male',
                'dob' => '2002-10-31',
                'enrollment' => 'Suspended',
                'enrollment_date' => '2021-09-01',
                'description' => 'Leave of absence for 1 academic semester due to medical reasons.',
                'dept_id' => 4,
            ],
            [
                'student_name' => 'Mia Garcia',
                'gender' => 'Female',
                'dob' => '2004-06-20',
                'enrollment' => 'Active',
                'enrollment_date' => '2023-09-01',
                'description' => 'Full-stack web developer and open source contributor.',
                'dept_id' => 2,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
