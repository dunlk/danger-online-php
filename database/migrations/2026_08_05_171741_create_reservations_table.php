<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate();

            $table->foreignId('computer_id')
                ->constrained()
                ->restrictOnDelete();

            $table->date('reservation_date');
            $table->time('start_time');
            $table->unsignedSmallInteger('duration_hours');

            $table->decimal('hourly_price', 8, 2);
            $table->decimal('total_price', 10, 2);

            $table->string('status', 30)
                ->default('pending')
                ->index();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index([
                'computer_id',
                'reservation_date',
                'start_time',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
