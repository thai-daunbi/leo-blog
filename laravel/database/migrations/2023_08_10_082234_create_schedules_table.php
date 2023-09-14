<?php
    
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    
class CreateSchedulesTable extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('button1')->default(false);
            $table->boolean('button2')->default(false);
            $table->boolean('button3')->default(false);
            $table->boolean('button4')->default(false);
            $table->boolean('button5')->default(false);
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
}
