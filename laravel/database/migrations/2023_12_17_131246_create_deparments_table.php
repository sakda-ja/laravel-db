<?php

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
        Schema::create('deparments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('department_name');
            $table->timestamps();
            $table->softDeletes(); //เช็คว่าข้อมูลเราโดนลบออกไปหรือไม่ | กู้คืนข้อมูลได้
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deparments');
    }
};
