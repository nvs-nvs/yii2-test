<?php

use yii\db\Schema;
use yii\db\Migration;

class m151012_072848_billing extends Migration
{
    public function safeUp()
    {
        $this->createTable('billing',
            [
                'id' => Schema::TYPE_PK,
                'agency_id' => Schema::TYPE_INTEGER.' UNSIGNED',
                'user_id' => Schema::TYPE_INTEGER.' UNSIGNED',
                'date' => Schema::TYPE_DATE,
                'amount' => Schema::TYPE_DECIMAL.'(9,2)',
        ]
    );
        $this->addForeignKey(
            'to_agency_id',
            'billing',
            'agency_id',
            'agency',
            'agency_id',
            'restrict'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('to_agency.agency_id','billing');
        $this->dropTable('billing');
    }
}
