<?php

namespace Database\Seeders;

use App\Models\RepairCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'คอมพิวเตอร์', 'description' => 'คอมพิวเตอร์ตั้งโต๊ะ โน้ตบุ๊ก และอุปกรณ์ต่อพ่วง'],
            ['name' => 'เครือข่ายอินเทอร์เน็ต', 'description' => 'อินเทอร์เน็ต Wi-Fi LAN และอุปกรณ์เครือข่าย'],
            ['name' => 'เครื่องพิมพ์', 'description' => 'เครื่องพิมพ์ หมึกพิมพ์ และการเชื่อมต่อ'],
            ['name' => 'โปรเจกเตอร์และจอภาพ', 'description' => 'โปรเจกเตอร์ จอแสดงผล และสายสัญญาณ'],
            ['name' => 'ไฟฟ้าและอุปกรณ์ทั่วไป', 'description' => 'ปลั๊กไฟ ไฟส่องสว่าง และอุปกรณ์สำนักงาน'],
            ['name' => 'อื่น ๆ', 'description' => 'ปัญหาอื่นที่ไม่ตรงกับหมวดหมู่ข้างต้น'],
        ];

        foreach ($categories as $category) {
            RepairCategory::updateOrCreate(['name' => $category['name']], $category + ['is_active' => true]);
        }

        // Demo administrator account for local coursework only. Change this password before deployment.
        User::updateOrCreate(
            ['email' => 'admin@repair.local'],
            [
                'name' => 'ผู้ดูแลระบบ',
                'password' => 'Admin@12345',
                'role' => 'admin',
            ]
        );
    }
}
