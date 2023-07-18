<?php
//ref: https://laravel.com/docs/10.x/migrations
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
            $table->string('uid');
			$table->string('email');
			$table->string('password');
			$table->boolean('isAdmin')->default(0);
			$table->string('apiToken');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
