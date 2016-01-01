<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    use DownForeignKeyCheckTrait;

    protected $table = 'entries';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->string('title', 85)->unique();
            $table->text('body');
            $table->timestamps();
        });
    }
}
