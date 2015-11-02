<?php

use yii\db\Schema;
use yii\db\Migration;

class m151012_072823_agency_network extends Migration
{
    public function safeUp()
    {
        $this->createTable( 'agency_network',
            [
                'id' => Schema::TYPE_PK,
                'agency_network_id' => Schema::TYPE_INTEGER.' UNSIGNED',
                'agency_network_name' => Schema::TYPE_STRING.'(64) NOT NULL',
            ]
        );


        $this->createIndex ( 'ix_agency_network_id', 'agency_network', 'agency_network_id', $unique = true );
    }

    public function safeDown()
    {
        $this->dropIndex ( 'ix_agency_network_name', 'agency_network' );
        $this->dropTable('agency_network');
    }

}
