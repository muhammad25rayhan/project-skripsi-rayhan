<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_id');
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('question');
            $table->string('image')->nullable();
            $table->longText('choice_1')->nullable();
            $table->decimal('weight_1', 5, 2)->nullable();
            $table->longText('choice_2')->nullable();
            $table->decimal('weight_2', 5, 2)->nullable();
            $table->longText('choice_3')->nullable();
            $table->decimal('weight_3', 5, 2)->nullable();
            $table->longText('choice_4')->nullable();
            $table->decimal('weight_4', 5, 2)->nullable();
            $table->longText('choice_5')->nullable();
            $table->decimal('weight_5', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_questions');
    }
}
