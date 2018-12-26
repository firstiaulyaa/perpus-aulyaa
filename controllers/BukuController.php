<?php

namespace app\controllers;

use Yii;
use app\models\Buku; // untuk memanggil model buku
use app\models\BukuSearch; // untuk memanggil model BukuSearch
use yii\web\Controller;
use yii\web\NotFoundHttpException; // untuk memanggil pesan jika model tidak ditemukan
use yii\filters\VerbFilter;
use yii\web\UploadedFile; // untuk memanggil ekstension UploadFile
use PhpOffice\PhpWord\IOFactory; // untuk 
use PhpOffice\PhpWord\PhpWord; // untuk memanggil ekstension PhpWord
use PhpOffice\PhpWord\Shared\Converter; // untuk 
use yii\web\ArrayHelper;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\base\Behavior;
use yii\helpers\Url;
use app\models\User;
use yii\filters\AccessControl;
use Da\QrCode\QrCode;
use Mpdf\Mpdf;

// Buku Controller
class BukuController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
      'class' => \yii\filters\AccessControl::className(),
      'only' => ['logout', 'index'],
      'rules' => [
        [
          'actions' => ['view', 'create', 'index'],
          'allow' => true,
          'roles' => ['@'],
          'matchCallback' => function() {
            return User::isAdmin() || User::isPetugas();
          }
        ],
          
        // true berarti bisa mengakses.
        [
          'actions' => ['index', 'create'],
          'allow' => false,
          'roles' => ['@'],
          'matchCallback' => function()
         {
           return User::isAnggota();
          },
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


  // action untuk menampilkan semua data pada Data Buku (views/index) //
  public function actionIndex()
  {
    $searchModel = new bukuSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }
  // ------------------------------------------------------------- //



  // action untuk menampilkan suatu data yang dipilih pada Data Buku //
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }
  // ------------------------------------------------------------- //



  // action untuk menambahkan buku ke database pada (views/create) //
  public function actionCreate()
  {
    $model = new Buku();

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      $sampul = UploadedFile::getInstance($model, 'sampul');
      $berkas = UploadedFile::getInstance($model, 'berkas');

      $model->sampul = time() . '_' . $sampul->name;
      $model->berkas = time() . '_' . $berkas->name;

      $model->save(false);

      $sampul->saveAs(Yii::$app->basePath . '/web/upload/sampul/' . $model->sampul);
      $berkas->saveAs(Yii::$app->basePath . '/web/upload/berkas/' . $model->berkas);
      Yii::$app->session->setFlash('success', 'Buku berhasil ditambahkan');
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

    $berkaslama = $model->berkas;
    $sampullama = $model->sampul;

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      $sampul = UploadedFile::getInstance($model, 'sampul');
      $berkas = UploadedFile::getInstance($model, 'berkas');

      if ($sampul !== null) {
        unlink(Yii::$app->basePath . '/web/upload/sampul/' . $sampullama);
        $model->sampul = time() . '_' . $sampul->name;
        $sampul->saveAs(Yii::$app->basePath . '/web/upload/sampul/' . $model->sampul);
      } else {
        $model->sampul = $sampullama;
      }

      if ($berkas !== null) {
        unlink(Yii::$app->basePath . '/web/upload/berkas/' . $berkaslama);
        $model->berkas = time() . '_' . $berkas->name;
        $berkas->saveAs(Yii::$app->basePath . '/web/upload/berkas/' . $model->berkas);
      } else {
        $model->berkas = $berkaslama;
      }

      $model->save(false);
      Yii::$app->session->setFlash('success', 'Data berhasil diperbaharui');
      return $this->redirect(['view', 'id' => $model->id]);
    }
    
    return $this->render('update', [
      'model' => $model,
    ]);
  }
  // ------------------------------------------------------------- //



  // action untuk menghapus data yang dipilih di Data Buku//
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();
    Yii::$app->session->setFlash('success', 'Data berhasil dihapus');
    return $this->redirect(['index']);
  }
  // ------------------------------------------------------------- //



  // action untuk memanggil model Data Buku di model lain //
  protected function findModel($id)
  {
    if (($model = Buku::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
  // ------------------------------------------------------------- //

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
      $model = Buku::find()->All();
      $mpdf=new mPDF();
      $mpdf->WriteHTML($this->renderPartial('temp_pdf',['model'=>$model]));
      $mpdf->Output('DataBuku_MyLibrary.pdf', 'D');
      exit;
  }
  
  public function actionExportExcel() {

    $spreadsheet = new PhpSpreadsheet\Spreadsheet();
    $worksheet = $spreadsheet->getActiveSheet();

    //Menggunakan Model

    $database = Buku::find()
    ->select('nama, tahun_terbit, id_penulis')
    ->all();

    $worksheet->setCellValue('A1', 'Judul Buku');
    $worksheet->setCellValue('B1', 'Tahun Terbit');
    $worksheet->setCellValue('C1', 'Penulis');

    //JIka menggunakan DAO , gunakan QueryAll()

    /*
     
    $sql = "select kode_jafung,jenis_jafung from ref_jafung"
     
    $database = Yii::$app->db->createCommand($sql)->queryAll();
     
    */

    $database = \yii\helpers\ArrayHelper::toArray($database);
    $worksheet->fromArray($database, null, 'A2');

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="DataBuku_MyLibrary.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
  }


  // ------------------------------------------------------------- //
  public function ActionQrCode() {
    $qrCode = (new QrCode('We going kokobop'))
      ->setSize(250)
      ->setMargin(5)
      ->useForegroundColor(0, 0, 0);

    $qrCode->writeFile(Yii::$app->basePath . '@web/qrcode/code.png');
  }
}
// -- akhir Buku Controller