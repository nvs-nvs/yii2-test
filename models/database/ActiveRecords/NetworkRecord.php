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
     * имя таблицы
     */
    public static function tableName()
    {
        return 'agency_network';
    }

    /**
     * правила валидации
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
     * аттрибуты
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
     * связь ко многим
     */
    public function getAgencies()
    {
        return $this->hasMany(AgencyRecord::className(), ['agency_network_id' => 'agency_network_id']);
    }
}
