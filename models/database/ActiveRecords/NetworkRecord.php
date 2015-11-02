<?php

namespace app\models\database\ActiveRecords;

use Yii;

/**
 * This is the model class for table "agency_network".
 *
 * @property integer $id
 * @property integer $agency_network_id
 * @property string $agency_network_name
 *
 * @property Agency[] $agencies
 */
class NetworkRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agency_network';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agency_network_id'], 'integer'],
            [['agency_network_name'], 'required'],
            [['agency_network_name'], 'string', 'max' => 64],
            [['agency_network_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'agency_network_id' => 'Agency Network ID',
            'agency_network_name' => 'Agency Network Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgencies()
    {
        return $this->hasMany(Agency::className(), ['agency_network_id' => 'agency_network_id']);
    }

    public function transactions()
    {
        return [
            //always enclose updates in a transaction
            \yii\base\Model::SCENARIO_DEFAULT => self::OP_INSERT,
        ];
    }
}
