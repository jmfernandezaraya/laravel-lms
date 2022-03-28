<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSchoolEdit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_admin_course_edit_permissions', function (Blueprint $table) {
            $table->dropColumn('is_true');
            $table->boolean('add')->default(0)->after('user_id');
            $table->boolean('edit')->default(0)->after('user_id');
            $table->boolean('delete')->default(0)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_admin_course_edit_permissions', function (Blueprint $table) {
            //
        });
    }
}
