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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('name', 20)->unique();
            $table->text('description')->nullable();
            $table->string('processor', 100);
            $table->unsignedSmallInteger('ram');
            $table->string('graphics', 100)->nullable();
            $table->string('storage', 100);
            $table->string('monitor', 100)->nullable();

            $table->decimal('hourly_price', 8, 2);

            $table->string('status', 30)
                ->default('available')
                ->index();

            $table->string('image')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
