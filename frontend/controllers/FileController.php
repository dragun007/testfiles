<?php

namespace frontend\controllers;

use common\models\File;
use common\models\StatisticByDateFileSearch;
use common\models\StatisticFileSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['get', 'view', 'statistics', 'statistics-by-date'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ],
        );
    }

    /**
     * Displays a single File model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new File();
        if ($model->load(Yii::$app->request->post())) {
            $model->upload = UploadedFile::getInstance($model, 'upload');

            if ($model->validate()) {
                if ($model->upload) {
                    $filename = $model->upload->baseName . '.' . $model->upload->extension;
                    $file_hash = Yii::$app->getSecurity()->generateRandomString();
                    $filePath = Yii::$app->params['documentPath'] . $file_hash;
                    if ($model->upload->saveAs($filePath)) {
                        $model->filename = $filename;
                        $model->file_hash = $file_hash;
                        $model->user_id = Yii::$app->getUser()->id;
                    }
                }

                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = File::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStatistics(): string
    {
        $searchModel = new StatisticFileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('statistics', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatisticsByDate(): string
    {
        $searchModel = new StatisticByDateFileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('statisticsByDate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGet($file_hash)
    {
        if (($model = File::findOne(['file_hash' => $file_hash])) !== null) {
            if (
                $model->type == FILE::TYPE_PRIVATE &&
                !Yii::$app->user->can(FILE::VIEW_PRIVATE_DOC, ['file' => $model])
            ) {
                throw new ForbiddenHttpException('Not allowed');
            } elseif ($model->type == FILE::TYPE_HALF_PUBLIC && !Yii::$app->user->can(FILE::VIEW_HALF_PUBLIC)) {
                throw new ForbiddenHttpException('Not allowed');
            }
            if (file_exists($model->getPath())) {
                return Yii::$app->response->sendFile($model->getPath(), $model->filename);
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
