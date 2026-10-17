# ระบบแจ้งซ่อม (Repair Request System) — Laravel + MySQL

โปรเจกต์สำหรับงานเรียน มีระบบสมาชิก ผู้ใช้งานแจ้งซ่อม ติดตามประวัติ และผู้ดูแลอัปเดตสถานะงานซ่อม

## ฟังก์ชันหลัก

- สมัครสมาชิก เข้าสู่ระบบ และออกจากระบบ
- แยกสิทธิ์ `user` และ `admin` โดยผู้สมัครใหม่จะเป็น `user` เสมอ
- สร้างคำขอแจ้งซ่อม พร้อมประเภทงาน รายละเอียด สถานที่ ระดับความเร่งด่วน และแนบรูปภาพ JPG/PNG/WEBP ได้ไม่เกิน 4 MB
- สร้างเลขที่คำขออัตโนมัติ เช่น `RR-261017-ABCDE`
- ผู้ใช้ค้นหา/กรองรายการของตนเอง ดูรายละเอียด และยกเลิกคำขอที่ยังรอดำเนินการได้
- ผู้ดูแลดูคำขอทั้งหมด ค้นหาคำขอและผู้แจ้ง เปลี่ยนสถานะ เพิ่มบันทึก และดูประวัติสถานะ
- หน้า Dashboard พร้อมจำนวนงานตามสถานะ
- ใช้ MySQL/MariaDB ผ่าน Eloquent ORM และ Laravel migrations
- UI ภาษาไทย ปรับตามขนาดหน้าจอ ไม่ต้องติดตั้ง npm หรือ build frontend

## สิ่งที่ต้องติดตั้ง

1. PHP 8.2 ขึ้นไป พร้อมส่วนขยาย `OpenSSL`, `PDO`, `pdo_mysql`, `Mbstring`, `Tokenizer`, `XML`, `Ctype`, `JSON`, `BCMath`, `Fileinfo` และ `cURL`
2. Composer
3. MySQL หรือ MariaDB (เช่น XAMPP)

## วิธีติดตั้งบน Windows / VS Code

1. แตก ZIP แล้วเปิดโฟลเดอร์ `repair-request-system` ใน VS Code
2. เปิด MySQL ใน XAMPP แล้วเข้า phpMyAdmin (`http://localhost/phpmyadmin`)
3. สร้างฐานข้อมูลชื่อ **`repair_request_system`** โดยเลือก Collation `utf8mb4_unicode_ci`
4. เปิด Terminal ในโฟลเดอร์โปรเจกต์ แล้วรันคำสั่งทีละบรรทัด:

```bash
composer install
```

ถ้ายังไม่มีไฟล์ `.env` ให้คัดลอก `.env.example` แล้วเปลี่ยนชื่อสำเนาเป็น `.env` จากนั้นตรวจค่าเชื่อมต่อฐานข้อมูลใน `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=repair_request_system
DB_USERNAME=root
DB_PASSWORD=
```

ตั้งค่า key สร้างตารางและข้อมูลเริ่มต้น:

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

5. เปิดเว็บที่ `http://127.0.0.1:8000`

> ถ้าฐานข้อมูล MySQL ของเครื่องมีรหัสผ่าน ให้ใส่ใน `DB_PASSWORD` ก่อนสั่ง `php artisan migrate --seed`

## บัญชีเริ่มต้นสำหรับทดสอบ

- **ผู้ดูแลระบบ:** `admin@repair.local`
- **รหัสผ่าน:** `Admin@12345`

บัญชีนี้สร้างไว้สำหรับทดสอบในเครื่องเรียนเท่านั้น เปลี่ยนรหัสผ่านก่อนนำระบบขึ้นใช้งานจริง ห้ามเปิดเผยบัญชีนี้ต่อสาธารณะ

## วิธีใช้งาน

1. ผู้ใช้สมัครสมาชิกหรือเข้าสู่ระบบ
2. กด **แจ้งซ่อมใหม่** กรอกข้อมูลและส่งคำขอ
3. เปิดรายการเพื่อดูเลขที่คำขอ สถานะ และประวัติการดำเนินงาน
4. ผู้ดูแลเข้าสู่ระบบด้วยบัญชีแอดมิน แล้วไปที่ **จัดการงานซ่อม** เพื่อค้นหารายการ เปิดรายละเอียด ปรับสถานะ และใส่บันทึก
5. ผู้แจ้งซ่อมกลับมาดูการเปลี่ยนแปลงได้ที่รายละเอียดคำขอ

## ตารางฐานข้อมูล

- `users` — ข้อมูลสมาชิกและสิทธิ์
- `repair_categories` — หมวดหมู่งานซ่อม
- `repair_requests` — รายละเอียดคำขอแจ้งซ่อมและสถานะล่าสุด
- `repair_updates` — ประวัติการเปลี่ยนสถานะ/บันทึกของแต่ละคำขอ
- `sessions`, `password_reset_tokens` — ตารางประกอบของ Laravel

## คำสั่งที่ใช้บ่อย

```bash
php artisan migrate:status
php artisan migrate:fresh --seed
php artisan route:list
php artisan test
```

**คำเตือน:** `php artisan migrate:fresh --seed` จะลบตารางเดิมทั้งหมดในฐานข้อมูลที่กำลังเชื่อมต่อ แล้วสร้างใหม่ เหมาะสำหรับข้อมูลทดสอบเท่านั้น
