<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // essa tabela vai ser o pivô entre a tabela table e a tabela cliente, pois eles tem um relacionamento
        // many-to-many
        Schema::create("client_products", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("product_id")
                ->references("id")
                ->on("products")
                ->onDelete("cascade");
            $table
                ->foreignId("client_id")
                ->references("id")
                ->on("client")
                ->onDelete("cascade");
            $table
                ->foreignId("salesperson_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table->integer("quantity");
            $table->integer("discount");
            $table->integer("price_sales");
            $table->string("status");
            $table->date("date");
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
        //
    }
};
