<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('api_post_id')->index();
            $table->bigInteger('api_id')->unique();
            $table->string('name');
            $table->string('email')->index();
            $table->mediumText('body');
            $table->dateTime('cached_at')->useCurrent();
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
        Schema::dropIfExists('api_comments');
    }
}
