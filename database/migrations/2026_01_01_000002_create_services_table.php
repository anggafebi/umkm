<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('slug')
                ->unique();

            $table->text('short_description')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->text('target_user')
                ->nullable();

            $table->text('problem')
                ->nullable();

            $table->text('features')
                ->nullable();

            $table->string('image')
                ->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};