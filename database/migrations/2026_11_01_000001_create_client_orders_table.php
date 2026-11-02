<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('client_registration_counters');
        Schema::create('client_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 32)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->string('order_type', 20)->default('fixed');
            $table->string('project_name')->nullable();
            $table->string('service_type')->nullable();
            $table->text('description')->nullable();
            $table->text('requested_features')->nullable();
            $table->string('budget')->nullable();
            $table->text('client_notes')->nullable();
            $table->decimal('price', 14, 2)->nullable();
            $table->decimal('offer_price', 14, 2)->nullable();
            $table->text('offer_details')->nullable();
            $table->string('status', 32)->default('pending');
            $table->timestamp('offer_responded_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_orders');
    }
};
