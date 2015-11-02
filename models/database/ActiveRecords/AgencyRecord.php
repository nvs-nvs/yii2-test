<?php

namespace app\models\database\ActiveRecords;

use Yii;

/**
 * This is the model class for table "agency".
 *
 * @property integer $id
 * @property integer $agency_id
 * @property integer $agency_network_id
 * @property string $agency_name
 *
 * @property AgencyNetwork $agencyNetwork
 * @property Billing[] $billings
 */
class AgencyRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agency_id', 'agency_network_id'], 'integer'],
            [['agency_name'], 'required'],
            [['agency_name'], 'string', 'max' => 64],
            [['agency_id', 'agency_network_id'], 'unique', 'targetAttribute' => ['agency_id', 'agency_network_id'], 'message' => 'The combination of Agency ID and Agency Network ID has already been taken.']
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
            'agency_network_id' => 'Agency Network ID',
            'agency_name' => 'Agency Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgencyNetwork()
    {
        return $this->hasOne(AgencyNetwork::className(), ['agency_network_id' => 'agency_network_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillings()
    {
        return $this->hasMany(Billing::className(), ['agency_id' => 'agency_id']);
    }

    public function transactions()
    {
        return [
            //always enclose updates in a transaction
            \yii\base\Model::SCENARIO_DEFAULT => self::OP_INSERT,
        ];
    }


}
