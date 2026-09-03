<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('service_interest')->nullable();
            $table->string('budget')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('consultations');
    }
};