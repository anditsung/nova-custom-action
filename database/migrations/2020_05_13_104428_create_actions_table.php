<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('changes')->nullable();
            $table->text('rules')->nullable();
            $table->text('nova_resources')->nullable();
            $table->string('modal_title');
            $table->text('modal_message')->nullable();
            $table->unsignedBigInteger('icon_id');
            $table->timestamps();
        });

        \DB::table('actions')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Active',
                    'changes' => '[{"layout":"changes","key":"qevN5xzirx6k2HV1","attributes":{"name":"is_active","value":"1"}}]',
                    'rules' => '[{"layout":"rules","key":"E0Lf3B47nXFwhXGl","attributes":{"name":"is_active","value":"0"}}]',
                    'nova_resources' => '',
                    'modal_title' => 'Active',
                    'modal_message' => 'Do you really want to <b class="text-success">Active</b> the resource?',
                    'icon_id' => 1,
                    'updated_at' => '2020-05-26 06:22:14',
                    'created_at' => '2020-05-26 06:22:14',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Deactive',
                    'changes' => '[{"layout":"changes","key":"Av23pzBaQ4JwhG2B","attributes":{"name":"is_active","value":"0"}}]',
                    'rules' => '[{"layout":"rules","key":"uixOqG2RbnBQyByr","attributes":{"name":"is_active","value":"1"}}]',
                    'nova_resources' => '',
                    'modal_title' => 'Deactive',
                    'modal_message' => 'Do you really want to <b class="text-danger">Deactive</b> the resource?',
                    'icon_id' => 2,
                    'updated_at' => '2020-05-26 06:26:08',
                    'created_at' => '2020-05-26 06:26:08',
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
        Schema::dropIfExists('actions');
    }
}
