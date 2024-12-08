<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyPhotoColumnInCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use raw SQL to modify the column type
        DB::statement('ALTER TABLE checkins MODIFY photo LONGTEXT NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert back to the previous column type, assuming it was TEXT
        DB::statement('ALTER TABLE checkins MODIFY photo TEXT NOT NULL');
    }
}
