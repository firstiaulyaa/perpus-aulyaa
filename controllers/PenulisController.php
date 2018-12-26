<?php

namespace app\controllers;

use Yii;
use app\models\Penulis; // untuk memanggil model Penulis
use app\models\penulisSearch; // untuk memanggil model PenulisSearch
use yii\web\NotFoundHttpException; // untuk memanggil pesan jika model tidak ditemukan
use yii\web\UploadedFile; // untuk memanggil fungsi upload file
use PhpOffice\PhpWord\PhpWord; // untuk memanggil fungsi eksport word
use PhpOffice\PhpWord\Shared\Converter; 
use PhpOffice\PhpWord\IOFactory;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

// Penulis Controller
class PenulisController extends Controller
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


    // action untuk menampilkan semua data pada Data Penulis (views/index) //
    public function actionIndex()
    {
        $searchModel = new penulisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    // ------------------------------------------------------------- //



    // action untuk menampilkan suatu data yang dipilih pada Data Anggota (views/view) //
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    // ------------------------------------------------------------- //



    // action untuk menambahkan penulis ke database pada (views/create) //
    public function actionCreate()
    {
        $model = new Penulis();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('success', 'Penulis berhasil ditambahkan');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    // ------------------------------------------------------------- //



    // action untuk melakukan update data yang dipilih pada (views/update) //
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('success', 'Data berhasil diperbaharui');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    // ------------------------------------------------------------- //



    // action untuk menghapus data yang dipilih di Data Penulis //
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
         Yii::$app->session->setFlash('success', 'Data berhasil dihapus');
        return $this->redirect(['index']);
    }
    // ------------------------------------------------------------- //



    // action untuk memanggil model Data Penulis di model lain //
    protected function findModel($id)
    {
        if (($model = Penulis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // ------------------------------------------------------------- //

    public function actionExportPdf() 
    {
      $this->layout='main1';
      $model = Penulis::find()->All();
      $mpdf=new mPDF();
      $mpdf->WriteHTML($this->renderPartial('temp_pdf',['model'=>$model]));
      $mpdf->Output('DataPenulis_MyLibrary.pdf', 'D');
      exit;
    }
}
// -- akhir Penulis Controller
