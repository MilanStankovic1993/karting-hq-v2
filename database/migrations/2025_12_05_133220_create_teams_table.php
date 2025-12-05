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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();

            // npr. "Duracell Racing", "Karting Team Novak" itd.
            $table->string('name');

            // vlasnik tima (tehničar / glavni user kod klijenta)
            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // da li je nalog aktivan (pretplata plaćena itd.)
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
