<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('width');
            $table->integer('height');
            $table->text('icon');
            $table->text('class');
            $table->timestamps();
        });

        \DB::table('icons')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'plus circle success',
                    'width' => 22,
                    'height' => 22,
                    'icon' => 'M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-9h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z',
                    'class' => 'hover:text-success',
                    'updated_at' => '2020-05-26 05:42:23',
                    'created_at' => '2020-05-26 06:12:55',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'minus circle danger',
                    'width' => 22,
                    'height' => 22,
                    'icon' => 'M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm4-8a1 1 0 0 1-1 1H9a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1z',
                    'class' => 'hover:text-danger',
                    'updated_at' => '2020-05-26 05:43:06',
                    'created_at' => '2020-05-26 06:13:20',
                ),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icons');
    }
}
