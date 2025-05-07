<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // FK para cliente
            $table->string('description');
            $table->date('expiration'); // vencimento
            $table->decimal('value', 10, 2); // valor da cobrança
            $table->enum('status', ['pendente', 'paga']); // status
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
