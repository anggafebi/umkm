<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 40)->nullable();
            $table->boolean('is_active')->default(true);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('price_is_starting_at')->default(true);
        });

        Schema::table('consultations', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_name_snapshot')->nullable();
            $table->string('reference_code')->nullable()->unique();
            $table->uuid('submission_token')->nullable()->unique();
            $table->index(['user_id', 'created_at']);
            $table->index(['product_id', 'status']);
        });

        Schema::create('client_registration_counters', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('used')->default(0);
        });
        DB::table('client_registration_counters')->insert(['id' => 1, 'used' => DB::table('users')->where('role', 'client')->count()]);

        Schema::create('consultation_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sender_role', 20);
            $table->text('body');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('consultation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 50);
            $table->string('title');
            $table->text('body')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'read_at']);
        });
        Schema::create('consultation_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_status_logs');
        Schema::dropIfExists('system_notifications');
        Schema::dropIfExists('consultation_messages');
        Schema::dropIfExists('client_registration_counters');
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('product_id');
            $table->dropUnique(['reference_code']);
            $table->dropUnique(['submission_token']);
            $table->dropColumn(['product_name_snapshot', 'reference_code', 'submission_token']);
        });
        Schema::table('products', fn (Blueprint $table) => $table->dropColumn('price_is_starting_at'));
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn(['phone', 'is_active']));
    }
};
