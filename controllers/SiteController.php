<?php

namespace app\controllers;

use yii\base\ErrorException;
use \yii\web\Controller;
use Yii;
use app\models;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\DynamicModel;
use app\models\CalcD;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\FileConvertion;
use app\models\MultiUploadForm;
use app\models\database\NetworkSave;
use app\models\database\AgencySave;
use app\models\database\BillingSave;
use app\models\database\DatabaseSearch;
use yii\db\Exception;

class SiteController extends Controller
{
    /**
     * Константа, указывающая папку для загрузки файлов
     * к actionData.
     */
    const DIR = 'uploads/databaseFiles/';


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Экшн вычисления минимальной разницы D. Получает POST-данные.
     * Динамическая валидация POST.
     * Обращается к static CalculateD() из класса app\models\CalcD
     */
    public function actionCalc()
    {
        $data = Yii::$app->request->post();
        /*Получаем массив ключей из пришедшего массива*/
        $input_as_array = array_keys($data);
        /*Валидация*/
        try {
            $model = DynamicModel::validateData($data, [
                [$input_as_array, 'number', 'max' => 1000, 'min' => -1000],
                [$input_as_array, 'default', 'value' => 0],
            ]);
            if ($model->hasErrors()) throw new ErrorException ("Не корректно введены данные");}
        catch (ErrorException $e) {return $this->render('info',['msg' => $e->getMessage(),]);}

        /*Получаем массив значений из пришедшего массива*/
        $array_values = array_values($data);
        /*Вычисляем абсолютную разность*/
        $result = CalcD::CalculateD($array_values);
        return $this->render('index',['result' => $result]);
    }


    /**
     * Экшн для загрузки файлов базу. Сразу трех одновременно.
     */

    public function actionData()
    {
        $model = new MultiUploadForm();
        try {
            if (Yii::$app->request->isPost) {
                $model->txtFile = UploadedFile::getInstances($model, 'txtFile');
                $filenames = array();
                foreach ($model->txtFile as $file) {
                    $filenames[] = $file->baseName;
                }

                $filenames = array_flip($filenames);

                if (array_key_exists('agency_network', $filenames)
                    && array_key_exists('agency', $filenames)
                    && array_key_exists('billing', $filenames)
                ) {
                    /*Валидация*/
                    if ($model->txtFile && $model->validate()) {
                        if (!is_dir(self::DIR))
                            mkdir(self::DIR, 0700, false);
                        foreach ($model->txtFile as $file) {
                            $file->saveAs(self::DIR . '/' . $file->baseName . '.' . $file->extension);
                        }

                        /*Сохраняем в базу*/
                        $networkSave = new NetworkSave();
                        $agencySave = new AgencySave();
                        $billingSave = new BillingSave();

                        return $this->render('info',['msg' => $networkSave->msg
                                    . "<br>"
                                    . $agencySave->msg
                                    . "<br>"
                                    . $billingSave->msg,]);

                    } else throw new ErrorException ("Не корректные данные");}
                      else {throw new ErrorException ("Только три файла одновременно разрешены к загрузке");}
            }
        } catch (ErrorException $e) {return $this->render('info',['msg' => $e->getMessage(),]);}

        return $this->render(
            'data',
            [
                'model' => $model
            ]
        );

    }

    /**
     * Экшн для преобразования файла data.txt в result.txt
     * Обращается к static convert() из app\models\FileConvertion;
     */
    public function actionRegexp()
    {
        $model = new UploadForm();
        try {
            if (Yii::$app->request->isPost) {
                $model->txtFile = UploadedFile::getInstance($model, 'txtFile');
                if ($model->upload()) {
                    FileConvertion::convert($model->txtFile);
                } else throw new ErrorException ();
            }
        } catch (ErrorException $e) {return $this->render('info',['msg' => $e->getMessage(),]);}

        return $this->render(
            'regexp',
            [
                'model' => $model
            ]
        );
    }

    /**
     * Экшн для вывода из базы таблицы с фильтрацией по дате.
     * Динамическая валидация POST.
     * Обращается к static search(() из app\models\DatabaseSearch;
     */
    public function actionList()
    {
        if ($input = Yii::$app->request->post()) {
            try {
                /*Валидация*/
                $input_as_array = array_keys($input);
                $model = DynamicModel::validateData($input, [
                    [$input_as_array, 'required'],
                ]);
                if ($model->hasErrors() || $input[date1] >= $input[date2]) {
                    throw new ErrorException ("Не верные даты!");
                } else {
                    try {
                        $result = DatabaseSearch::search($input);
                    } catch (Exception $e) {return $this->render('info',['msg' => "Нет соединения с базой",]);
                    }

                    return $this->render(
                        'getlist',
                        [
                            'result' => $result,
                        ]
                    );
                }

            } catch (ErrorException $e) {return $this->render('info',['msg' => $e->getMessage(),]);}

        }
        return $this->render('getlist');
    }
}
