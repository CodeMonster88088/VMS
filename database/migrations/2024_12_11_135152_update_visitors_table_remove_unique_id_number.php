<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateVisitorsTableRemoveUniqueIdNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Check if the unique index exists before attempting to drop it
            $indexes = DB::select("SHOW INDEX FROM visitors WHERE Key_name = 'visitors_id_number_unique'");
            if (!empty($indexes)) {
                $table->dropUnique('visitors_id_number_unique');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Re-add the unique constraint only if it doesn't already exist
            $indexes = DB::select("SHOW INDEX FROM visitors WHERE Key_name = 'visitors_id_number_unique'");
            if (empty($indexes)) {
                $table->unique('id_number');
            }
        });
    }
}
