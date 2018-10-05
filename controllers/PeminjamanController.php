<?php

namespace app\controllers;

use Yii;
use app\models\Peminjaman; // untuk memanggil model Peminjaman
use app\models\PeminjamanSearch; // untuk memanggil model PeminjamanSearch
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dosamigos\datepicker\DatePicker; // untuk memanggil ekstension DatePicker (tanggal)
use PhpOffice\PhpWord\IOFactory; // untuk 
use PhpOffice\PhpWord\PhpWord; // untuk memanggil ekstension PhpWord
use PhpOffice\PhpWord\Shared\Converter; // untuk 

/**
 * PeminjamanController implements the CRUD actions for Peminjaman model.
 */
class PeminjamanController extends Controller
{
    /**
     * {@inheritdoc}
     */
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



    // -------------------------------------------------------------------- //
    // action untuk menampilkan semua data pada Data Peminjaman (index.php) //
    // -------------------------------------------------------------------- //

    /**
     * Lists all Peminjaman models.
     * @return mixed
     */
    public function actionIndex()
        {
            $searchModel = new PeminjamanSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    // --------------------------------------------- //



    // ----------------------------------------------------------------------------------- //
    // action untuk menampilkan suatu data yang dipilih pada Data Peminjaman pada view.php //
    // ----------------------------------------------------------------------------------- //

    /**
     * Displays a single Peminjaman model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
        {
            return $this->render('view', [
                'model' => $this->findModel($id), 
            ]);
        }

    // -------------------------------------------------------------------------------- //



    // ------------------------------------------------------------- //
    // action untuk menambahkan anggota ke database pada create.php //
    // ------------------------------------------------------------- //

    /**
     * Creates a new Peminjaman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
        {
            $model = new Peminjaman();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }

    // ------------------------------------------------------------- //



    // --------------------------------------------------------------- //
    // action untuk melakukan update data yang dipilih pada update.php //
    // --------------------------------------------------------------- //

    /**
     * Updates an existing Peminjaman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    // --------------------------------------------------------------- //



    // ----------------------------------------------------------- //
    // action untuk menghapus data yang dipilih di Data Peminjaman //
    // ----------------------------------------------------------- //

    /**
     * Deletes an existing Peminjaman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
        {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }

    // ------------------------------------------------------------- //



    // ------------------------------------------------------- //
    // action untuk memanggil model Data Anggota di model lain //
    // ------------------------------------------------------- //

    /**
     * Finds the Peminjaman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Peminjaman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
        {
            if (($model = Peminjaman::findOne($id)) !== null) {
                return $model;
            }

            throw new NotFoundHttpException('The requested page does not exist.');
        }

    // ------------------------------------------------------- //


    public function getInputDate($param)
    {
        $array=explode("-",$param);
        return $array[2]."-".$array[1]."-".$array[0];
        }
    }
    ?>
}
