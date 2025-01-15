<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP DATABASE IF EXISTS `ELDB`;");
        DB::unprepared("CREATE DATABASE `ELDB`;");
        DB::unprepared("USE `ELDB`;");

        Schema::create('migrations', function (Blueprint $table) {
            $table->id();
            $table->string('migration');
            $table->integer('batch');
        });

        /** 1. Authorizations Table */
        Schema::create('authorizations', function (Blueprint $table) {
            $table->unsignedBigInteger('authorization_id', true);
            $table->string('authorization_role', 16)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        /** 2. Authentications Table */
        Schema::create('authentications', function (Blueprint $table) {
            $table->unsignedBigInteger('authentication_id', true);
            $table->binary('account', 1000)->unique();
            $table->binary('password', 1000);
            $table->binary('indentifer_email', 1000)->unique();
            $table->boolean('authentication_state')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->unsignedBigInteger('authorization_id');
            $table->foreign('authorization_id')
                ->references('authorization_id')
                ->on('authorizations')
                ->onUpdate('cascade');
        });

        /** 3. Users Table */
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id', true);
            $table->string('user_first_name', 100);
            $table->string('user_last_name', 100);
            $table->string('user_alias', 100)->unique();
            $table->boolean('user_gender')->default(false);
            $table->string('user_email', 100);
            $table->string('user_phone_number', 20);
            $table->string('user_address', 100);
            $table->boolean('user_state')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->unsignedBigInteger('authentication_id')->unique();
            $table->foreign('authentication_id')
                ->references('authentication_id')
                ->on('authentications')
                ->onUpdate('cascade');
        });

        /** 4. Tags Table */
        Schema::create('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id', true);
            $table->string('tag_description', 100)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
        });

        /** 5. Courses Table */
        Schema::create('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id', true);
            $table->string('course_name', 100);
            $table->string('short_description', 1000);
            $table->text('long_description');
            $table->integer('course_price')->check('course_price > 0 AND course_price < 100000000');
            $table->boolean('course_state')->default(true);
            $table->string('course_duration', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade');
        });

        /** 6. CourseTag Table */
        Schema::create('course_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('course_tag_id', true);
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->onUpdate('cascade');
            $table->foreign('tag_id')
                ->references('tag_id')
                ->on('tags')
                ->onUpdate('cascade');
        });

        /** 7. Lessons Table */
        Schema::create('lessons', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson_id', true);
            $table->string('lesson_name', 100);
            $table->unsignedBigInteger('course_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->onUpdate('cascade');
        });

        /** 8. MaterialTypes Table */
        Schema::create('material_types', function (Blueprint $table) {
            $table->unsignedBigInteger('m_type_id', true);
            $table->string('m_type_description', 50)->unique();
        });

        /** 9. Materials Table */
        Schema::create('materials', function (Blueprint $table) {
            $table->unsignedBigInteger('material_id', true);
            $table->text('material_content');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('lesson_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('type_id')
                ->references('m_type_id')
                ->on('material_types')
                ->onUpdate('cascade');
            $table->foreign('lesson_id')
                ->references('lesson_id')
                ->on('lessons')
                ->onUpdate('cascade');
        });

        /** 10. Enrollments Table */
        Schema::create('enrollments', function (Blueprint $table) {
            $table->unsignedBigInteger('enrollment_id', true);
            $table->timestamp('enrollment_date')->useCurrent();
            $table->boolean('enrollment_is_complete')->default(false);
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('course_id')
                ->references('course_id')
                ->on('courses')
                ->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade');
        });

        /** 11. Grades Table */
        Schema::create('grades', function (Blueprint $table) {
            $table->unsignedBigInteger('grade_id', true);
            $table->integer('grade_number')->check('grade_number >= 0 AND grade_number <= 100');
            $table->unsignedBigInteger('enrollment_id');
            $table->unsignedBigInteger('lesson_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('enrollment_id')
                ->references('enrollment_id')
                ->on('enrollments')
                ->onUpdate('cascade');
            $table->foreign('lesson_id')
                ->references('lesson_id')
                ->on('lessons')
                ->onUpdate('cascade');
        });

        /** 12. CourseFeedback Table */
        Schema::create('course_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('course_feedback_id', true);
            $table->text('course_feedback_description');
            $table->unsignedBigInteger('enrollment_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('enrollment_id')
                ->references('enrollment_id')
                ->on('enrollments')
                ->onUpdate('cascade');
        });

        /** 13. SystemFeedback Table */
        Schema::create('system_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('system_feedback_id', true);
            $table->text('system_feedback_description');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade');
        });

        /** 14. Payments Table */
        Schema::create('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id', true);
            $table->text('payment_description');
            $table->integer('payment_amount')->check('payment_amount > 0 AND payment_amount <= 999999999');
            $table->string('transaction_id', 100)->unique();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('deleted_flag')->default(false);
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('system_feedback');
        Schema::dropIfExists('course_feedback');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('material_types');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('course_tag');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('users');
        Schema::dropIfExists('authentications');
        Schema::dropIfExists('authorizations');
    }
};
