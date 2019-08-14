<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{

    public $tableName = 'videos';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('servidor_video_id');
            $table->string('ruta', 1000);
            $table->integer('videoble_id')->unsigned();
            $table->string('videoble_type');
            $table->timestamps();

            $table->index(["servidor_video_id"], 'fk_servidor_videos_video_idx');

            $table->foreign('servidor_video_id', 'fk_servidor_videos_video_idx')
                ->references('id')->on('servidor_videos')
                ->onDelete('no action')
                ->onUpdate('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
