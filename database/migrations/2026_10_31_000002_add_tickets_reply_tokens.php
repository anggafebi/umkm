<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('consultation_messages', function (Blueprint $table) {
            $table->uuid('submission_token')->nullable()->unique();
            $table->index(['consultation_id', 'created_at'], 'consultation_messages_timeline_idx');
        });
    }
    public function down(): void {
        Schema::table('consultation_messages', function (Blueprint $table) {
            $table->dropIndex('consultation_messages_timeline_idx');
            $table->dropUnique(['submission_token']);
            $table->dropColumn('submission_token');
        });
    }
};
