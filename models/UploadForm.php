<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 * @package app\models
 * Модель для загружаемого фала с раширением txt
 * вызывается из actionRegexp контроллера SiteController
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $txtFile;

    public function rules()
    {
        return [
            [['txtFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
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