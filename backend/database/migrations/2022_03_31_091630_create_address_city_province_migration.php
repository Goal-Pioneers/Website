<?php

// Needed Libraries
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



// Code Function
/**
 * 
 */
    return new class extends Migration
    {
        
        // Code Preperation
        const DB_TABLE_NAME = 'address_city_province';

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            //
            Schema::create( self::DB_TABLE_NAME, 
                function ( Blueprint $table ) 
                {
                    $table->id(); 

                    $table->bigInteger('address_label_province_id')->unsigned();
                    $table->integer('postal_code')->unsigned();
                    
                    $table->foreign( 'address_label_province_id' )->references( 'id' )->on( 'address_label_province' );
                }
            );
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            //
            Schema::dropIfExists( self::DB_TABLE_NAME );
        }
    };



?>