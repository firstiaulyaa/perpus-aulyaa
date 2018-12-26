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
use Mpdf\Mpdf;
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
                ->setFrom('firstiaulyaa@gmail.com')
                ->setTo($model->anggota->email)
                ->setSubject('Pemberitahuan - myLibrary')
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

    public function actionExportWord()
    {

        $phpWord = new phpWord();
        $section = $phpWord->addSection(
            [
                'marginTop' => Converter::cmTotwip(1.80),
                'marginBottom' => Converter::cmTotwip(1.80),
                'marginLeft' => Converter::cmTotwip(2.1),
                'marginRight'=> Converter::cmTotwip(1.6),
            ]
        );

        $fontStyle = [
            'underline' => 'dash',
            'bold' => true,
            'italic' => true,
        ];
        $paragraphCenter = [
            'alignment' => 'center',
        ];
        $headerStyle = [
            'bold' => true,
            'fgColor' => 'ffffff',
        ];

        $section->addText(
            'Data Buku Perpustakaan SMAN 2 TANGSEL',
            $headerStyle,
            $fontStyle,
            $paragraphCenter
        );

        $section->addTextBreak(1);

        $judul = $section->addTextRun($paragraphCenter);

        $judul->addText('Keterangan dari', $fontStyle);
        $judul->addText('Tabel', ['italic' => true, $fontStyle]);
        $judul->addText('Buku',  ['bold' => true]); 

        $table =$section->addTable([
            'alignment' => 'left',
            'bgColor' => 6,
            'borderSize' => 6,
        ]);
        $table->addRow(null);
        $table->addCell(500)->addText('No', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Nama Buku', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Tahun Terbit', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Penulis', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Penerbit', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Kategori', $headerStyle, $paragraphCenter);
        $table->addCell(5000)->addText('Sinopsis', $headerStyle, $paragraphCenter);

        $semuaBuku = Buku::find()->all();
        $nomor = 1;
        foreach ($semuaBuku as $buku) {
            $table->addRow(null);
            $table->addCell(500)->addText($nomor++, null, $headerStyle, $paragraphCenter);
            $table->addCell(5000)->addText($buku->nama, null);
            $table->addCell(5000)->addText($buku->tahun_terbit, null, $paragraphCenter);
            $table->addCell(3000)->addText(@$buku->penulis->nama, null, $paragraphCenter);
            $table->addCell(3000)->addText(@$buku->penerbit->nama, null, $paragraphCenter);
            $table->addCell(3000)->addText(@$buku->kategori->nama, null, $paragraphCenter);
            $table->addCell(5000)->addText($buku->sinopsis, null);
        }
        $filename = 'DataBuku_MyLibrary.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output"); 
    }

  public function actionExportPdf() 
    {
      $this->layout='main1';
      $model = Peminjaman::find()->All();
      $mpdf = new mPDF();
      $mpdf->WriteHTML($this->renderPartial('temp_pdf',['model'=>$model]));
      $mpdf->Output('DataPeminjaman_MyLibrary.pdf', 'D');
      exit;
  }
  
  public function actionExportExcel() {

    $spreadsheet = new PhpSpreadsheet\Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();

    //Menggunakan Model

    $database = Buku::find()
    ->select('id, id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status_buku')
    ->all();

    $worksheet->setCellValue('A1', 'ID');
    $worksheet->setCellValue('B1', 'ID ANGGOTA');
    $worksheet->setCellValue('C1', 'ID BUKU');
    $worksheet->setCellValue('D1', 'TANGGAL PINJAM');
    $worksheet->setCellValue('C1', 'TANGGAL KEMBALI');
    $worksheet->setCellValue('C1', 'STATUS BUKU');

    //JIka menggunakan DAO , gunakan QueryAll()

    /*
     
    $sql = "select kode_jafung,jenis_jafung from ref_jafung"
     
    $database = Yii::$app->db->createCommand($sql)->queryAll();
     
    */

    $database = \yii\helpers\ArrayHelper::toArray($database);
    $worksheet->fromArray($database, null, 'A2');

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="DataPeminjaman_MyLibrary.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
  }

}
