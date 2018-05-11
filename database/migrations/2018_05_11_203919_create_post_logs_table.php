<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->comment('文章编号');
            $table->ipAddress('ip')->comment('访问ip');
            $table->integer('viewed_time')->comment('浏览时长');
            $table->timestamps();
            $table->index('ip', 'idx_ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_logs');
    }
}
