<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Water Supply Department'],
            ['name' => 'Electricity Department'],
            ['name' => 'Sanitation & Waste Management'],
            ['name' => 'Roads & Infrastructure'],
            ['name' => 'Public Health'],
            ['name' => 'Education Department'],
            ['name' => 'Housing Department'],
            ['name' => 'Transport Department'],
            ['name' => 'Revenue Department'],
            ['name' => 'Municipal Corporation'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}