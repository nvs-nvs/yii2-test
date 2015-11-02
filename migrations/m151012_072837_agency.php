<?php

use yii\db\Schema;
use yii\db\Migration;

class m151012_072837_agency extends Migration
{
    public function safeUp()
    {
    $this->createTable('agency',
        [
            'id' => Schema::TYPE_PK,
            'agency_id' => Schema::TYPE_INTEGER.' UNSIGNED',
            'agency_network_id' => Schema::TYPE_INTEGER.' UNSIGNED',
            'agency_name' => Schema::TYPE_STRING.'(64) NOT NULL',
        ]
    );
        $this->createIndex('ix_agency_id','agency','agency_id,agency_network_id',true);

        $this->addForeignKey(
        'to_agency_network',
        'agency',
        'agency_network_id',
        'agency_network',
        'agency_network_id',
        'cascade'
        );
    }

    public function safeDown()
    {
        $this->dropIndex('ix_agency_id','agency');
        $this->dropForeignKey('to_agency_network','agency_network');
        $this->dropTable('agency');
    }

}
