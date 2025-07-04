<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS get_company_attendance_history_by_employee');

        DB::unprepared('
            CREATE PROCEDURE get_company_attendance_history_by_employee(IN emp_id INT)
            BEGIN
                SELECT 
                    e.nickname AS nama,
                    DATE(ca.checked_in_at) AS tanggal,
                    ca.status,
                    cp.name AS lokasi,
                    csh.name AS shift,
                    ca.photo_path AS foto
                FROM company_attendances ca
                JOIN employees e ON e.id = ca.employee_id
                LEFT JOIN company_places cp ON cp.id = ca.company_place_id
                LEFT JOIN company_schedules cs ON cs.employee_id = ca.employee_id AND cs.date = DATE(ca.checked_in_at)
                LEFT JOIN company_shifts csh ON csh.id = cs.company_shift_id
                WHERE ca.employee_id = emp_id
                ORDER BY ca.checked_in_at DESC;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS get_company_attendance_history_by_employee');
    }
};