<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('rs', function (Blueprint $table) {
        $table->id();
        $table->string('namobj'); // Nama Rumah Sakit
        $table->string('remark'); // Jenis Rumah Sakit
        $table->text('alamat')->nullable(); // Deskripsi
        $table->string('foto')->nullable(); // Foto (link atau path file)
        $table->decimal('latitude', 10, 8); // Koordinat latitude
        $table->decimal('longitude', 11, 8); // Koordinat longitude
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('rs');
}

};
