<?php

namespace app\controllers;
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

class SiteController extends Controller
{
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

    public function actionCalc()
    {
        $data = Yii::$app->request->post();
        /*Получаем массив ключей из пришедшего массива*/
        $input_as_array = array_keys($data);
        /*Валидация*/
        $model = DynamicModel::validateData($data, [
            [$input_as_array, 'number', 'max' => 1000, 'min' => -1000],
            [$input_as_array, 'default', 'value' => 0],
        ]);
        if ($model->hasErrors()) {
            $msg='Не корректно введены данные';
            return $this->render(
                'error',
                [
                    'msg' => $msg,
                ]
            );

        } else {
            /*Получаем массив значений из пришедшего массива*/
            $array_values = array_values($data);
            /*Вычисляем абсолютную разность*/
            $result = CalcD::CalculateD($array_values);
            return $this->render('index',
                [
                    'result' => $result
                ]
            );

    }
    }

        public function actionData()
        {

            $model = new MultiUploadForm();

            if (Yii::$app->request->isPost) {
                $model->txtFile = UploadedFile::getInstances($model, 'txtFile');
                $filenames=array();
                foreach ($model->txtFile as $file) {
                    $filenames[]=$file->baseName;
                }
                $filenames = array_flip($filenames);
                if (array_key_exists('agency_network',$filenames)
                            && array_key_exists('agency',$filenames)
                                && array_key_exists('billing',$filenames)) {
                        if ($model->txtFile && $model->validate()) {
                            if (!is_dir(self::DIR)) mkdir(self::DIR, 0700, false);
                            foreach ($model->txtFile as $file) {
                            $file->saveAs(self::DIR .'/'. $file->baseName . '.' . $file->extension);
                        }
                            $networkSave = new NetworkSave();
                            $agencySave = new AgencySave();
                            $billingSave = new BillingSave();
                            return $this->render(
                                'error',
                                [
                                    'msg' => $networkSave->msg
                                        ."<br>"
                                        .$agencySave->msg
                                        ."<br>"
                                        .$billingSave->msg,
                                ]
                            );

                    }
               }
                else {
                    $msg = 'Все три файла: agency_network.txt, agency.txt и billing.txt обязателены к отправке';
                    return $this->render(
                        'error',
                        [
                            'msg' => $msg,
                        ]
                    );
                }

                }
                return $this->render(
                    'data',
                    [
                        'model' => $model
                    ]
                );

        }


    public function actionRegexp()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->txtFile = UploadedFile::getInstance($model, 'txtFile');
            if ($model->upload()) {
                FileConvertion::convert($model->txtFile);
            }
        }

        return $this->render(
            'regexp',
            [
                'model' => $model
            ]
            );
    }
}
