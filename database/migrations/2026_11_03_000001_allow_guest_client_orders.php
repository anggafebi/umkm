<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('client_orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('guest_name', 120)->nullable()->after('user_id');
            $table->string('guest_email', 160)->nullable()->after('guest_name')->index();
            $table->string('guest_phone', 40)->nullable()->after('guest_email');
        });
    }

    public function down(): void
    {
        Schema::table('client_orders', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_email', 'guest_phone']);
            // user_id tetap nullable agar rollback tidak gagal jika masih ada pesanan guest.
        });
    }
};
