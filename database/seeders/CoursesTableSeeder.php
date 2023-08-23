<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إدراج بيانات البذور (Seeding Data) في جدول "courses"
        DB::table('courses')->insert([
            [
                'title' => 'HTML',
                'description' => 'هذه دورة تدريبية رقم 1',
                'start_date' => '2023-07-25',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'CSS',
                'description' => 'هذه دورة تدريبية رقم 2',
                'start_date' => '2023-08-01',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Laravel ',
                'description' => 'Front-end',
                'start_date' => '2023-08-01',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // قم بإضافة المزيد من البيانات هنا إذا لزم الأمر...
        ]);
    }
}
