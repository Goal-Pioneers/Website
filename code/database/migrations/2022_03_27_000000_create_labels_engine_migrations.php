<?php
    // Needed Libraries
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    use App\Models\LabelMailingListsModel;

    // Code function
    /**
     * 
     */
    return new class extends Migration
    {
        // Code Preperation
            // Base
        const DB_CONNECTOR = 'mysql';
        const DB_ENGINE_DEFAULT = 'InnoDB';

            // Table Names
        const DB_TABLE_NAME_MAILING_LIST = LabelMailingListsModel::DB_TABLE_NAME;


        /**
         * 
         */
        public function up()
        {
            //
            Schema::connection( self::DB_CONNECTOR )
                ->create( self::DB_TABLE_NAME_MAILING_LIST, 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id()
                          ->comment('');

                    $table->string( 'content' )
                          ->unique()
                          ->comment('');
                }
            );

        }
        

        /**
         * 
         */
        public function down()
        {
            //
            Schema::connection( self::DB_CONNECTOR )
                  ->dropIfExists( self::DB_TABLE_NAME_MAILING_LIST );
        }
    };
?>