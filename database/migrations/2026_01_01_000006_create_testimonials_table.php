<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){ Schema::create('testimonials', function(Blueprint $t){$t->id();$t->string('name');$t->string('company')->nullable();$t->text('message');$t->integer('rating')->default(5);$t->string('photo')->nullable();$t->boolean('status')->default(true);$t->timestamps();}); } public function down(){Schema::dropIfExists('testimonials');}};
