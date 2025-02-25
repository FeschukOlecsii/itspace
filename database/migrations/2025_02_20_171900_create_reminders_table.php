<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(1)->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('color')->nullable();
            $table->dateTime('date_time');
            $table->enum('recurrence', ['once','daily', 'specified_days', 'monthly', 'yearly']);
            $table->text('recurrence_days')->nullable();
            $table->integer('recurrence_day_of_month')->nullable();
            $table->date('recurrence_day_of_year')->nullable();
            $table->string('type')->default('type1');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
