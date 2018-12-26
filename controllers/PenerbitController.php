<?php

namespace app\controllers;

use Yii;
use app\models\Penerbit; // untuk memanggil model Penerbit
use app\models\penerbitSearch; // untuk memanggil model PenerbitSearch
use yii\web\NotFoundHttpException; // untuk memanggil pesan jika model tidak ditemukan
use PhpOffice\PhpWord\PhpWord; // untuk memanggil ekstension PhpWord
use PhpOffice\PhpWord\Shared\Converter; // untuk 
use PhpOffice\PhpWord\IOFactory; // untuk 
use yii\web\Controller;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

// Penerbit Controller
class PenerbitController extends Controller
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


    // action untuk menampilkan semua data pada Data Penerbit (views/index) //
    public function actionIndex()
    {
        $searchModel = new penerbitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    // ------------------------------------------------------------- //



    // action untuk menampilkan suatu data yang dipilih pada Data Penerbit (views/view) //
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    // ------------------------------------------------------------- //



    // action untuk menambahkan penerbit ke database (views/create) //
    public function actionCreate()
    {
        $model = new Penerbit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Penerbit berhasil ditambahkan');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    // ------------------------------------------------------------- //


    // action untuk melakukan update data yang dipilih (views/update) //
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



    // action untuk menghapus data yang dipilih di Data Penerbit //
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
         Yii::$app->session->setFlash('success', 'Data berhasil dihapus');
        return $this->redirect(['index']);
    }
    // ------------------------------------------------------------- //



    // action untuk memanggil model Data Penerbit di model lain //
    protected function findModel($id)
    {
        if (($model = Penerbit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // ------------------------------------------------------------- //

    public function actionExportPdf() 
    {
      $this->layout='main1';
      $model = Penerbit::find()->All();
      $mpdf=new mPDF();
      $mpdf->WriteHTML($this->renderPartial('temp_pdf',['model'=>$model]));
      $mpdf->Output('DataPenerbit_MyLibrary.pdf', 'D');
      exit;
    }
}
// -- akhir Penerbit Controller
