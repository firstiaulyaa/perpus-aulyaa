<?php

namespace app\controllers;

use Yii;
use app\models\Peminjaman;
use app\models\PeminjamanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\filters\AccessControl;
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

            // Access Control URL.
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update', 'view', 'delete'],
                        'allow' => User::isAdmin() || User::isPetugas(),
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'create', 'kembalikan-buku'],
                        'allow' => User::isAdmin() || User::isPetugas() || User::isAnggota(),
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

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

    /**
     * Creates a new Peminjaman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_buku = null)
    {
        $model = new Peminjaman();
        $model->id_buku = $id_buku;
        $model->status_buku = 1;
        $model->tanggal_kembali = date('Y-m-d', strtotime('+7 days'));
        $model->tanggal_pengembalian_buku = '0000-00-00';
        // if (User::isAnggota()) {
        //     $model->id_anggota=1;
        // }

        if (Yii::$app->user->identity->id_user_role == 2) {
            $model->id_anggota = Yii::$app->user->identity->id_anggota;
            $model->tanggal_pinjam = date('Y-m-d');
            $model->tanggal_kembali = date('Y-m-d', strtotime('+7 days'));
            $model->status_buku = 1;
            $model->tanggal_pengembalian_buku = '0000-00-00';
            Yii::$app->mail->compose('@app/template/pemberitahuan',['model' => $model])
                ->setFrom('samsulaculhadi@gmail.com')
                ->setTo($model->anggota->email)
                ->setSubject('Pemberitahuan - PerpusJJ')
                ->send();
            $model->save();
            Yii::$app->session->setFlash('success', 'Berhasil pinjam buku. Silahkan cek email anda.');
            return $this->redirect(['index']);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

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
            Yii::$app->session->setFlash('success', 'Data berhasil di perbaharui');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

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

        throw new NotFoundHttpException('Halaman tidak tersedia.');
    }

    public function actionKembalikanBuku($id)
    {
        $model = Peminjaman::findOne($id);
        
        $model->status_buku = 2;
        $model->tanggal_pengembalian_buku = date('Y-m-d');

        $model->save();

        Yii::$app->session->setFlash('Berhasil', 'Buku telah berhasil di kembalikan');
        return $this->redirect(['peminjaman/index']);
    }
}
