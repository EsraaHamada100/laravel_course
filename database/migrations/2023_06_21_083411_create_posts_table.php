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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->longText('body');
            /** The first part is the name of the model and the second part is 
             * the name of the field.
             *  constrained() ->  will not allow you to create a post if the 
             * user Id doesn't exist in the user table.
             * onDelete('cascade) -> so whenever you delete a user all the posts created
             * with this user will be deleted .
             **/
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
