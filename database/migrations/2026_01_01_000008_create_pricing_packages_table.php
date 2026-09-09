<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){ Schema::create('pricing_packages', function(Blueprint $t){$t->id();$t->string('name');$t->string('price');$t->text('features')->nullable();$t->boolean('highlight')->default(false);$t->boolean('status')->default(true);$t->timestamps();}); } public function down(){Schema::dropIfExists('pricing_packages');}};
