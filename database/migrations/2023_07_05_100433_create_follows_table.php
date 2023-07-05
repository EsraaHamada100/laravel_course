<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            /**
             * That line tells him to create a field that references the id field in
             * users table , note that the name matters here
             * The constrained felid tells him to not accept any value that's not in users id
             **/
            $table->foreignId('user_id')->constrained();
            /**
             * Here we create the field with ourself , and you can choose any name
             * you want, And then we assign the relation to it
             */
            $table->unsignedBigInteger('followed_user');
            $table->foreign('followed_user')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
