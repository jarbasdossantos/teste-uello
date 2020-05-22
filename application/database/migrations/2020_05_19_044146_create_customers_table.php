<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            
            $table->string('name', 100);
            $table->string('email', 100);
            $table->date('birth_date');
            $table->string('cpf', 14);
            $table->text('address');
            $table->string('neighborhood', 100);
            $table->string('city', 100);
            $table->string('number', 100);
            $table->string('state');
            $table->string('zip_code', 9);
            $table->string('lat', 100);
            $table->string('lng', 100);
            $table->longText('place_id');
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
