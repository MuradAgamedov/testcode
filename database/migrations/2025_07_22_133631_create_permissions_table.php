<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // İcazənin adı, məsələn: 'edit-posts'
            $table->string('guard_name'); // Guard adı, məsələn: 'web' və ya 'api'
            $table->timestamps(); // Yaradılma və yenilənmə tarixləri

            $table->unique(['name', 'guard_name']); // İcazələr unikaldır
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
