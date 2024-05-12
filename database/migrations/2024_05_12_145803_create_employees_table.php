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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('paternal_name', 20);
            $table->string('maternal_name', 20);
            $table->string('first_name', 20);
            $table->string('other_names', 50)->nullable();
            $table->enum('employment_country', ['Colombia', 'United States']);
            $table->string('id_type');
            $table->string('id_number', 20)->unique();
            $table->string('email')->unique();
            $table->date('entry_date');
            $table->string('area');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamp('registration_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
