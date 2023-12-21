<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('menu_id')->index();
            $table->uuid('role_id')->index();
            $table->boolean('is_create')->default(0);
            $table->boolean('is_read')->default(1);
            $table->boolean('is_update')->default(0);
            $table->boolean('is_delete')->default(0);
            $table->boolean('is_validate')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_menus');
    }
};
