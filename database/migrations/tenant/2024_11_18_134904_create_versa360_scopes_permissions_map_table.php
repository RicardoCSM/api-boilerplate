<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('versa360_scopes_permissions_map', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('scope_id')->unique();
            $table->json('permissions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versa360_scopes_permissions_map');
    }
};
