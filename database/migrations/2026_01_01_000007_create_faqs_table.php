<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){ Schema::create('faqs', function(Blueprint $t){$t->id();$t->string('question');$t->text('answer');$t->integer('order')->default(0);$t->boolean('status')->default(true);$t->timestamps();}); } public function down(){Schema::dropIfExists('faqs');}};
