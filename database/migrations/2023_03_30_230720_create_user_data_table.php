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
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('u_id')->unique()->comment('ユーザーID');
            $table->string('yubin')->nullable()->comment('郵便番号');
            $table->string('jusho1')->nullable()->comment('住所1');
            $table->string('jusho2')->nullable()->comment('住所2');
            $table->string('jusho3')->nullable()->comment('住所3');
            $table->string('tel')->nullable()->comment('電話番号');
            $table->text('biko')->nullable()->comment('備考');
            $table->integer('type_flag')->default('0')->comment('タイプフラグ');
            $table->integer('kanri_flag')->default('0')->comment('管理フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_data');
    }
};
