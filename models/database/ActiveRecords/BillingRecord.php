<?php

namespace app\models\database\ActiveRecords;

use Yii;

/**
 * This is the model class for table "billing".
 *
 * @property integer $id
 * @property integer $agency_id
 * @property string $user_id
 * @property integer $date
 * @property string $amount
 * @property Agency $agency
 */
class BillingRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'billing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agency_id' => 'Agency ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['agency_id' => 'agency_id']);
    }

    public function transactions()
    {
        return [
            //always enclose updates in a transaction
            \yii\base\Model::SCENARIO_DEFAULT => self::OP_INSERT,
        ];
    }


}
