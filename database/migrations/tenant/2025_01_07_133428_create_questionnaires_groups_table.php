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
        Schema::create('questionnaires_groups', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->userActions();
        });

        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('questionnaires_group_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->json('elements');
            $table->integer('version')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userActions();
        });

        Schema::create('questionnaire_responses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('questionnaire_id')->constrained();
            $table->integer('version');
            $table->json('answers');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userActions();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires_groups');
        Schema::dropIfExists('questionnaires');
        Schema::dropIfExists('questionnaires_responses');
    }
};
