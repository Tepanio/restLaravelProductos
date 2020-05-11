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
        });
    
        DB::connection('mysql')->table('usuarios')->insert([
                
            [
                'id'=>'tinchorin',
                'nombre' => 'martin',
                'apellido'=> 'canal',
                'direccion'=> '',
                'telefono'=>'',
                'super'=> 0 ,
            ]

        ]);
        DB::connection('mysql')->table('pedidos')->insert([
                
            [
                
                'usuario_id' => 'tinchorin'
            ],
            [
                
                'usuario_id' => 'tinchorin'
            ]
            

        ]);
        
        DB::connection('mysql')->table('productos')->insert([
                
            [
                'nombre' => 'papa',
                'descripcion'=>'',
                'precio' => '99',
                'activo'=> 1
            ],
            [
                'nombre' => 'boñato',
                'descripcion'=>'',
                'precio' => '9',
                'activo'=> 1
            ],
            [
                'nombre' => 'bolas de mono',
                'descripcion'=>'',
                'precio' => '999999',
                'activo'=> 1
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
