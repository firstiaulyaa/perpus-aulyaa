<?php

namespace app\controllers;

use Yii;
use app\models\Anggota; // untuk memanggil model Anggota
use app\models\AnggotaSearch; // untuk memanggil model AnggotaSearch
use yii\web\NotFoundHttpException; // untuk memanggil pesan jika model tidak ditemukan
use PhpOffice\PhpWord\IOFactory; // untuk 
use PhpOffice\PhpWord\PhpWord; // untuk memanggil ekstension PhpWord
use PhpOffice\PhpWord\Shared\Converter; // untuk 
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile; // untuk memanggil ekstension UploadFile

// Anggota Controller
class AnggotaController extends Controller
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


    // action untuk menampilkan semua data pada Data Anggota (index.php) //
    public function actionIndex()
    {
        $searchModel = new AnggotaSearch();
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



    // action untuk menambahkan anggota ke database dengan id (views/create) //
    public function actionCreate()
    {
        $model = new Anggota();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $foto = UploadedFile::getInstance($model, 'foto');

            $model->foto = time() . '_' . $berkas->name;

            $model->save(false);

            $berkas->saveAs(Yii::$app->basePath . '/web/user/' . $model->foto);
            Yii::$app->session->setFlash('success', 'Berhasil menambahkan anggota');
            return $this->redirect(['index', 'id' => $model->id]);
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

        $foto_lama = $model->foto;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $foto = UploadedFile::getInstance($model, 'foto');
            if ($foto !== null) {
                unlink(Yii::$app->basePath . '/web/user/' . $foto_lama);
                $model->foto = time() . '_' . $foto->name;
                $foto->saveAs(Yii::$app->basePath . '/web/user/' . $model->foto);
            } else {
                $model->foto = $foto_lama;
            }

            Yii::$app->session->setFlash('success', 'Data berhasil di perbaharui');
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    // ------------------------------------------------------------- //



    // action untuk menghapus data yang dipilih di Data Anggota //
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    // ------------------------------------------------------------- //



    // action untuk memanggil model Data Anggota di controller lain //
    protected function findModel($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // ------------------------------------------------------------- //   
}
// -- akhir Anggota Controller