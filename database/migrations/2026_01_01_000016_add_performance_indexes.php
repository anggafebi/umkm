<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('consultations', function (Blueprint $table) {
            $table->index(['status','created_at'], 'consultations_status_created_idx');
            $table->index('source', 'consultations_source_idx');
        });
        Schema::table('services', fn (Blueprint $table) => $table->index('service_category_id', 'services_category_idx'));
        Schema::table('blog_posts', fn (Blueprint $table) => $table->index(['status','published_at'], 'blog_status_published_idx'));
        Schema::table('newsletter_subscribers', fn (Blueprint $table) => $table->index('status', 'newsletter_status_idx'));
    }
    public function down(): void {
        Schema::table('consultations', function (Blueprint $table) { $table->dropIndex('consultations_status_created_idx'); $table->dropIndex('consultations_source_idx'); });
        Schema::table('services', fn (Blueprint $table) => $table->dropIndex('services_category_idx'));
        Schema::table('blog_posts', fn (Blueprint $table) => $table->dropIndex('blog_status_published_idx'));
        Schema::table('newsletter_subscribers', fn (Blueprint $table) => $table->dropIndex('newsletter_status_idx'));
    }
};
