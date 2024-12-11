<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('checkout');
    }

    public function down()
    {
        // Optionally, you can define the rollback for this migration,
        // which would recreate the table if needed. However, it's not mandatory.
    }

};
