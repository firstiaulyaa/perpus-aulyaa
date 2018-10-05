<?php

namespace app\controllers;

use Yii;
use app\models\Anggota; // untuk memanggil model Anggota
use app\models\AnggotaSearch; // untuk memanggil model AnggotaSearch
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpWord\IOFactory; // untuk 
use PhpOffice\PhpWord\PhpWord; // untuk memanggil ekstension PhpWord
use PhpOffice\PhpWord\Shared\Converter; // untuk 

/**
 * AnggotaController implements the CRUD actions for Anggota model.
 */
class AnggotaController extends Controller
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



    // ----------------------------------------------------------------- //
    // action untuk menampilkan semua data pada Data Anggota (index.php) //
    // ----------------------------------------------------------------- //

    /**
     * Lists all Anggota models.
     * @return mixed
     */

    public function actionIndex()
        {
            $searchModel = new AnggotaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    // --------------------------------------------- //
 


    // -------------------------------------------------------------------------------- //
    // action untuk menampilkan suatu data yang dipilih pada Data Anggota pada view.php //
    // -------------------------------------------------------------------------------- //

    /**
     * Displays a single Anggota model.
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



    // ------------------------------------------------------------ //
    // action untuk menambahkan anggota ke database pada create.php //
    // ------------------------------------------------------------ //

    /**
     * Creates a new Anggota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
        {
            $model = new Anggota();

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
     * Updates an existing Anggota model.
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



    // -------------------------------------------------------- //
    // action untuk menghapus data yang dipilih di Data Anggota //
    // -------------------------------------------------------- //

    /**
     * Deletes an existing Anggota model.
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
     * Finds the Anggota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anggota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
        {
            if (($model = Anggota::findOne($id)) !== null) {
                return $model;
            }

            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
    // ------------------------------------------------------------- //
}
    

