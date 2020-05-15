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
            $table->integer('cantidad');
        });

        DB::connection('mysql')->table('usuarios')->insert([

            [
                'username'=>'tinchorin',
                'password'=>Hash::make('123456'),
                'email'=>'tincho@rin.com',
                'nombre' => 'martin',
                'apellido'=> 'canal',
                'direccion'=> '',
                'telefono'=>'',
                'admin'=> 0 ,
            ]

        ]);

        DB::connection('mysql')->table('pedidos')->insert([

            [

                'usuario_username' => 'tinchorin'
            ],
            [

                'usuario_username' => 'tinchorin',

            ]


        ]);

        DB::connection('mysql')->table('productos')->insert([

            [
                'nombre' => 'papa',
                'descripcion'=>'',
                'precio' => '99',

            ],
            [
                'nombre' => 'boñato',
                'descripcion'=>'',
                'precio' => '9',

            ],
            [
                'nombre' => 'bolas de mono',
                'descripcion'=>'',
                'precio' => '999999',

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
