<?php

namespace app\controllers;

use Yii;
use app\models\Petugas;
use app\models\PetugasSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile; 


/**
 * PetugasController implements the CRUD actions for Petugas model.
 */
class PetugasController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PetugasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data berhasil di perbaharui');
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Petugas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
   {
       $model = new Petugas();

       if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           $petugas = new Petugas();
           $petugas->nama = $model->nama;
           $petugas->alamat = $model->alamat;
           $petugas->telepon = $model->telepon;
           $petugas->email = $model->email;
           $foto = UploadedFile::getInstance($model, 'foto');
           $model->foto = time(). '_' . $foto->name;
           $foto->saveAs(Yii::$app->basePath. '/web/user/' . $model->foto);
           $petugas->foto = $model->foto;
           $petugas->save();


           $user = new User();
           $user->id_petugas = $petugas->id;
           $user->id_user_role = $petugas->id;
           $user->username = $model->username;
           $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
           $user->id_anggota = 0;
           $user->id_user_role = 3;
           $user->status = 1;            
           $user->token = Yii::$app->getSecurity()->generateRandomString(100);
           
           $user->save();
           Yii::$app->session->setFlash('success', 'Berhasil menambahkan petugas');
           return $this->redirect(['index', 'id' => $model->id]);
       }

       return $this->render('create', [
           'model' => $model,
       ]);
   }
}
