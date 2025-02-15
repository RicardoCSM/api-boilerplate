<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Stancl\Tenancy\Tenancy;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('versa360_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 255);
            $table->string('client_secret', 255);
            $table->string('workspace_id', 255);
            $table->string(Tenancy::tenantKeyColumn())->comment('no-rls');

            $table->timestamps();
            $table->foreign(Tenancy::tenantKeyColumn())->references('id')->on('tenants')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versa360_credentials');
    }
};
