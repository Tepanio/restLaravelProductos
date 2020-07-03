<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
            $table->foreignId('producto_id')->constrained();
            $table->integer('cantidad')->default(1);
        });

        DB::connection('mysql')->table('usuarios')->insert([

            [
                'username'=>'admin',
                'password'=>Hash::make('admin'),
                'email'=>'tincho@rin.com',
                'email_verified_at' => \Carbon\Carbon::now()->toDateTime(),
                'nombre' => 'martin',
                'apellido'=> 'canal',
                'direccion'=> '',
                'telefono'=>'',
                'admin'=> 0 ,
            ]

        ]);

        DB::connection('mysql')->table('pedidos')->insert([

            [

                'usuario_username' => 'admin'
            ],
            [

                'usuario_username' => 'admin',

            ]


        ]);

        DB::connection('mysql')->table('productos')->insert([

            [
                'nombre' => 'Ravioles',
                'descripcion'=>'',
                'precio' => '599',

            ],
            [
                'nombre' => 'Sorrentinos',
                'descripcion'=>'',
                'precio' => '590',

            ],
            [
                'nombre' => 'Tallarines',
                'descripcion'=>'',
                'precio' => '599',

            ]


        ]);

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */



    public function down()
    {
        Schema::dropIfExists('pedido_productos');
    }


}
