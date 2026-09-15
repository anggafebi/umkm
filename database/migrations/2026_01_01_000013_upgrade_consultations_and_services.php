<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('consultations','admin_notes')) Schema::table('consultations',fn(Blueprint $t)=>$t->text('admin_notes')->nullable()->after('status'));
        if (!Schema::hasColumn('consultations','last_contacted_at')) Schema::table('consultations',fn(Blueprint $t)=>$t->timestamp('last_contacted_at')->nullable()->after('admin_notes'));
        if (!Schema::hasColumn('consultations','source')) Schema::table('consultations',fn(Blueprint $t)=>$t->string('source')->default('website')->after('last_contacted_at'));
        if (!Schema::hasColumn('services','service_category_id')) Schema::table('services',fn(Blueprint $t)=>$t->unsignedBigInteger('service_category_id')->nullable()->after('id'));
        if (!Schema::hasColumn('services','solution')) Schema::table('services',fn(Blueprint $t)=>$t->text('solution')->nullable()->after('problem'));
        if (!Schema::hasColumn('services','thumbnail')) Schema::table('services',fn(Blueprint $t)=>$t->string('thumbnail')->nullable()->after('image'));
    }
    public function down(): void {
        foreach(['admin_notes','last_contacted_at','source'] as $column) if(Schema::hasColumn('consultations',$column)) Schema::table('consultations',fn(Blueprint $t)=>$t->dropColumn($column));
        foreach(['service_category_id','solution','thumbnail'] as $column) if(Schema::hasColumn('services',$column)) Schema::table('services',fn(Blueprint $t)=>$t->dropColumn($column));
    }
};
