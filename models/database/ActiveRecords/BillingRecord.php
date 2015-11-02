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
     * имя таблицы
     */
    public static function tableName()
    {
        return 'billing';
    }

    /**
     * правила валидации. Не указаны, так как приходят свалидированные данные из базы
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * аттрибуты
     */
    public function attributeLabels()
    {
        return [
//            'id' => 'ID',
//            'agency_id' => 'Agency ID',
//            'user_id' => 'User ID',
//            'date' => 'Date',
            'amount' => 'Amount',
        ];
    }

    /**
     * связь к одному
     */
    public function getAgency()
    {
        return $this->hasOne(AgencyRecord::className(), ['agency_id' => 'agency_id']);
    }
}
