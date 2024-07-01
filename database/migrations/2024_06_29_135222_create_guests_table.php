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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('year_id')->constrained('years')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nama');
            $table->string('instansi');
            $table->string('no_telp');
            $table->string('email')->unique(); 
            $table->string('alamat');
            $table->text('keperluan')->nullable();
            $table->text('signature')->nullable();
            $table->date('tgl_kunjungan'); 
            $table->time('waktu_masuk'); 
            $table->time('waktu_keluar')->nullable();
            $table->enum('status', ['done', 'ongoing'])->default('ongoing');
            $table->timestamps();
        });

        // Schema::create('guests', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
        //     $table->foreignId('year_id')->constrained('years')->onUpdate('cascade')->onDelete('restrict');
        //     $table->string('nama');
        //     $table->string('no_telp');
        //     $table->string('alamat');
        //     $table->string('instansi');
        //     $table->string('jabatan');
        //     $table->string('NIP')->unique();
        //     $table->text('keperluan')->nullable(); 
        //     $table->date('tgl_kunjungan'); 
        //     $table->time('waktu_masuk'); 
        //     $table->time('waktu_keluar')->nullable();
        //     $table->enum('status', ['done', 'ongoing'])->default('ongoing');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
