<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP USER IF EXISTS 'el_admin'@'localhost';");
        DB::unprepared("DROP USER IF EXISTS 'el_teacher'@'localhost';");
        DB::unprepared("DROP USER IF EXISTS 'el_student'@'localhost';");
        DB::unprepared("DROP USER IF EXISTS 'el_guest'@'localhost';");

        DB::unprepared("CREATE USER 'el_admin'@'localhost' IDENTIFIED BY 'aL2!xF7@zS8?dV1eT';");
        DB::unprepared("CREATE USER 'el_teacher'@'localhost' IDENTIFIED BY 'gD1*eQ9vL5sW@zI7yJ';");
        DB::unprepared("CREATE USER 'el_student'@'localhost' IDENTIFIED BY 'jH8gkQ3lR2tBv@P0iV';");
        DB::unprepared("CREATE USER 'el_guest'@'localhost' IDENTIFIED BY 'nA4gpF9dWzG2tB1mJv';");
        
        // Insert fake data for Authorizations
        DB::table('authorizations')->insert([
            ['authorization_role' => 'ADMIN'],
            ['authorization_role' => 'TEACHER'],
            ['authorization_role' => 'STUDENT']
        ]);

        // Insert fake data for Authentications
        DB::table('authentications')->insert([
            [
                'account' => DB::raw("AES_ENCRYPT('admin_account', 'encryption_key')"),
                'password' => DB::raw("AES_ENCRYPT('admin_password', 'encryption_key')"),
                'indentifer_email' => DB::raw("AES_ENCRYPT('admin@example.com', 'encryption_key')"),
                'authentication_state' => true,
                'authorization_id' => 1
            ],
            [
                'account' => DB::raw("AES_ENCRYPT('teacher_account', 'encryption_key')"),
                'password' => DB::raw("AES_ENCRYPT('teacher_password', 'encryption_key')"),
                'indentifer_email' => DB::raw("AES_ENCRYPT('teacher@example.com', 'encryption_key')"),
                'authentication_state' => true,
                'authorization_id' => 2
            ],
            [
                'account' => DB::raw("AES_ENCRYPT('student_account', 'encryption_key')"),
                'password' => DB::raw("AES_ENCRYPT('student_password', 'encryption_key')"),
                'indentifer_email' => DB::raw("AES_ENCRYPT('student@example.com', 'encryption_key')"),
                'authentication_state' => true,
                'authorization_id' => 3
            ]
        ]);

        // Insert fake data for Users
        DB::table('users')->insert([
            [
                'user_first_name' => 'John',
                'user_last_name' => 'Doe',
                'user_alias' => 'johndoe',
                'user_gender' => true,
                'user_email' => 'john@example.com',
                'user_phone_number' => '1234567890',
                'user_address' => '123 Main St',
                'user_state' => true,
                'authentication_id' => 1
            ],
            [
                'user_first_name' => 'Jane',
                'user_last_name' => 'Smith',
                'user_alias' => 'janesmith',
                'user_gender' => false,
                'user_email' => 'jane@example.com',
                'user_phone_number' => '2345678901',
                'user_address' => '456 Oak St',
                'user_state' => true,
                'authentication_id' => 2
            ],
            [
                'user_first_name' => 'Alice',
                'user_last_name' => 'Johnson',
                'user_alias' => 'alicejohnson',
                'user_gender' => false,
                'user_email' => 'alice@example.com',
                'user_phone_number' => '3456789012',
                'user_address' => '789 Pine St',
                'user_state' => true,
                'authentication_id' => 3
            ]
        ]);

        // Insert fake data for Tags
        DB::table('tags')->insert([
            ['tag_description' => 'Technology'],
            ['tag_description' => 'Science'],
            ['tag_description' => 'Health'],
            ['tag_description' => 'Education'],
            ['tag_description' => 'Business']
        ]);

        // Insert fake data for Courses
        DB::table('courses')->insert([
            [
                'course_name' => 'Intro to Technology',
                'course_description' => 'Learn the basics of technology.',
                'course_price' => 100,
                'course_state' => true,
                'user_id' => 2
            ],
            [
                'course_name' => 'Advanced Science',
                'course_description' => 'Explore advanced scientific concepts.',
                'course_price' => 200,
                'course_state' => true,
                'user_id' => 2
            ],
            [
                'course_name' => 'Health and Wellness',
                'course_description' => 'Tips for maintaining good health.',
                'course_price' => 300,
                'course_state' => true,
                'user_id' => 2
            ]
        ]);

        // Insert fake data for CourseTag
        DB::table('course_tag')->insert([
            ['course_id' => 1, 'tag_id' => 1],
            ['course_id' => 1, 'tag_id' => 2],
            ['course_id' => 2, 'tag_id' => 3],
            ['course_id' => 3, 'tag_id' => 4]
        ]);

        // Insert fake data for Lessons
        DB::table('lessons')->insert([
            ['lesson_name' => 'Lesson 1', 'course_id' => 1],
            ['lesson_name' => 'Lesson 2', 'course_id' => 2],
            ['lesson_name' => 'Lesson 3', 'course_id' => 3]
        ]);

        // Insert fake data for MaterialTypes
        DB::table('material_types')->insert([
            ['m_type_description' => 'Video'],
            ['m_type_description' => 'Text'],
            ['m_type_description' => 'PDF']
        ]);

        // Insert fake data for Materials
        DB::table('materials')->insert([
            ['material_content' => 'Video Content 1', 'type_id' => 1, 'lesson_id' => 1],
            ['material_content' => 'Text Content 1', 'type_id' => 2, 'lesson_id' => 2],
            ['material_content' => 'PDF Content 1', 'type_id' => 3, 'lesson_id' => 3]
        ]);

        // Insert fake data for Enrollments
        DB::table('enrollments')->insert([
            ['enrollment_date' => now(), 'enrollment_is_complete' => true, 'course_id' => 1, 'user_id' => 1],
            ['enrollment_date' => now(), 'enrollment_is_complete' => false, 'course_id' => 2, 'user_id' => 2],
            ['enrollment_date' => now(), 'enrollment_is_complete' => true, 'course_id' => 3, 'user_id' => 3]
        ]);

        // Insert fake data for Grades
        DB::table('grades')->insert([
            ['grade_number' => 85, 'enrollment_id' => 1, 'lesson_id' => 1],
            ['grade_number' => 90, 'enrollment_id' => 2, 'lesson_id' => 2],
            ['grade_number' => 95, 'enrollment_id' => 3, 'lesson_id' => 3]
        ]);

        // Insert fake data for CourseFeedback
        DB::table('course_feedback')->insert([
            ['course_feedback_description' => 'Great course!', 'enrollment_id' => 1],
            ['course_feedback_description' => 'Very informative.', 'enrollment_id' => 2],
            ['course_feedback_description' => 'Loved the lessons.', 'enrollment_id' => 3]
        ]);

        // Insert fake data for SystemFeedback
        DB::table('system_feedback')->insert([
            ['system_feedback_description' => 'System is easy to use.', 'user_id' => 1],
            ['system_feedback_description' => 'Great UI!', 'user_id' => 2],
            ['system_feedback_description' => 'Highly responsive.', 'user_id' => 3]
        ]);

        // Insert fake data for Payments
        DB::table('payments')->insert([
            ['payment_description' => 'Payment for Course 1', 'payment_amount' => 100, 'transaction_id' => 'txn_001', 'user_id' => 1],
            ['payment_description' => 'Payment for Course 2', 'payment_amount' => 200, 'transaction_id' => 'txn_002', 'user_id' => 2],
            ['payment_description' => 'Payment for Course 3', 'payment_amount' => 300, 'transaction_id' => 'txn_003', 'user_id' => 3]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('payments')->delete(); // Deletes all data in the table
        DB::table('system_feedback')->delete();
        DB::table('course_feedback')->delete();
        DB::table('grades')->delete();
        DB::table('enrollments')->delete();
        DB::table('materials')->delete();
        DB::table('material_types')->delete();
        DB::table('lessons')->delete();
        DB::table('course_tag')->delete();
        DB::table('courses')->delete();
        DB::table('tags')->delete();
        DB::table('users')->delete();
        DB::table('authentications')->delete();
        DB::table('authorizations')->delete();
    }
};
