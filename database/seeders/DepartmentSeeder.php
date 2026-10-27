<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'dept_id' => 1,
                'dept_name' => 'Computer Science & Information Technology',
                'manager_id' => 'MGR-CS-001',
                'location_id' => 'Building A, Floor 3 (Room 301)',
            ],
            [
                'dept_id' => 2,
                'dept_name' => 'Software Engineering',
                'manager_id' => 'MGR-SE-002',
                'location_id' => 'Building B, Floor 2 (Lab 204)',
            ],
            [
                'dept_id' => 3,
                'dept_name' => 'Business Administration & Management',
                'manager_id' => 'MGR-BA-003',
                'location_id' => 'Building C, Floor 1 (Room 102)',
            ],
            [
                'dept_id' => 4,
                'dept_name' => 'Electrical & Electronics Engineering',
                'manager_id' => 'MGR-EE-004',
                'location_id' => 'Building A, Floor 1 (Lab 105)',
            ],
            [
                'dept_id' => 5,
                'dept_name' => 'Civil & Environmental Engineering',
                'manager_id' => 'MGR-CE-005',
                'location_id' => 'Building D, Floor 4 (Studio 401)',
            ],
            [
                'dept_id' => 6,
                'dept_name' => 'Digital Arts & Media Technology',
                'manager_id' => 'MGR-DA-006',
                'location_id' => 'Building E, Floor 2 (Media Lab 202)',
            ],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(['dept_id' => $dept['dept_id']], $dept);
        }
    }
}
