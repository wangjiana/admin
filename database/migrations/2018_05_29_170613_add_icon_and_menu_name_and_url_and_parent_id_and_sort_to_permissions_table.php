<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIconAndMenuNameAndUrlAndParentIdAndSortToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->string('icon')->nullable()->comment('图标');
            $table->string('menu_name')->default('')->comment('菜单名称');
            $table->string('url')->nullable()->comment('路径');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父级路径');
            $table->integer('sort')->unsigned()->default(0)->comment('排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('icon');
            $table->dropColumn('menu_name');
            $table->dropColumn('url');
            $table->dropColumn('sort');
        });
    }
}
