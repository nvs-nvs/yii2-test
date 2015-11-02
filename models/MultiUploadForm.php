<?php
/**
 */
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class MultiUploadForm
 * @package app\models
 * Модель для загружаемых 3-х файлом формата txt
 * вызывается из actionData контроллера SiteController
 */
class MultiUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $txtFile;

    public function rules()
    {
        return [
            [['txtFile'], 'file', 'maxFiles' => 3, 'skipOnEmpty' => false, 'extensions' => 'txt'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->txtFile->saveAs('uploads/' . $this->txtFile->baseName . '.' . $this->txtFile->extension);

            return true;
        } else {
            return false;
        }
    }
}