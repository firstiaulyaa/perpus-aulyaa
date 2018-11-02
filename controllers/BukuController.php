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
       Yii::$app->session->setFlash('success', 'Berhasil menambahkan buku');
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
      Yii::$app->session->setFlash('success', 'Data berhasil di perbaharui');
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



  // action untuk export Data Buku ke word
  public function actionExportWord()
  {
   $phpWord = new \PhpOffice\PhpWord\PhpWord();
       $phpWord->setDefaultFontSize(11); // ukuran font
       $phpWord->setDefaultFontName('Bookman Old Style'); // style font
        // mengatur jarak (space)
       $phpWord->setDefaultParagraphStyle(
         array(
           'align'      => 'both',
           'spaceAfter' => Converter::pointToTwip(0.7),
           'spacing'    => 0,
         )
       );
        // mengatur jarak penulisan
       $sectionStyle = [ 
         'marginTop'=>Converter::cmToTwip(2.25),
         'marginBottom'=>Converter::cmToTwip(2.49),
         'marginLeft'=>Converter::cmToTwip(2.2),
         'marginRight'=>Converter::cmToTwip(2.6),
       ];
        // mengatur paragraf
       $section = $phpWord->addSection($sectionStyle);
       $phpWord->addParagraphStyle('headerPStyle', ['alignment'=>'center']);
       $phpWord->addParagraphStyle('headerPStyleNoSpace', ['alignment'=>'center']);
       $phpWord->addFontStyle('headerFStyle', ['bold'=>true]);
       $phpWord->addParagraphStyle(
         'multipleTabLeft',
         array(
           'tabs' => array(
             new \PhpOffice\PhpWord\Style\Tab('left', 750),
             new \PhpOffice\PhpWord\Style\Tab('left', 1050),
           ),
           'align'=>'left'
         )
       );
       // mengatur penulisan angka
       $phpWord->addNumberingStyle(
         'multilevel',
         array(
           'type' => 'multilevel',
           'levels' => array(
             array('format' => 'upperRoman', 'text' => '%1.', 'left' => 400, 'hanging' => 360, 'tabPos' => 360),
             array('format' => 'decimal', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
           )
         )
       );
       // membuat header
       $header_alamat = ['bold' => false, 'size' => 12]; // membuat pemanggilan style tulisan alamat
       $header_style = ['bold' => false, 'size' => 12,]; // membuat pemanggilan style header
       $header_page = $section->addHeader();
       $imageStyle = array(
         'width' => 65,
         'wrappingStyle' => 'square',
         'positioning' => 'absolute',
         'posHorizontalRel' => 'margin',
         'posVerticalRel' => 'line',
       );
       $paragraphCenter = [
         'alignment' =>'center',   
       ];
       $fontStyleBold = [
        'bold' => true,
        'size' => 11,
      ];

       // text untuk header
      $textrun->addText("\t\t PEMERINTAH KABUPATEN PURBALINGGA", $header_style,'headerPStyle');
      $header_page->addText("\t\t KECAMATAN KUTASARI", $header_style, 'headerPStyle');
      $header_page->addText("\t\t DESA SUMINGKIR", $header_alamat, 'headerPStyle'); 
      $header_page->addText("\t\t JALAN PINGIT NOMOR 3303070003", $header_alamat, 'headerPStyle');
      $header_page->addText("\t\t         ", $header_alamat, 'headerPStyle');



        // Line
      $header_page->addShape(
       'line',
       array(
         'points'  => '1,1 630,0',
         'outline' => array(
           'color'      => '#000000',
           'line'       => 'thickThin',
           'weight'     => 2,
         ),
       )
     );   
       // membuat teks ($ untuk pemanggilan style teks)
      $section->addText( 
       'SURAT PENGANTAR IMUNISASI',
       $phpWord,
       $paragraphCenter,
       $fontStyleBold
     );
      $section->addText( 
       'Nomor  : ./003/I/2017',
       $phpWord,
       $paragraphCenter
     );
      $section->addText( 
       'Nomor  : ./003/I/2017',
       $phpWord
     );


       // Tempat penyimpanan file sama nama file.
        $filename = time() . '_' . 'export-word.docx'; // nama file
        $path = 'document' . $filename;
        $xmlWrite = IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWrite->save($path);

        return $this->redirect($path);
      }  
  // ------------------------------------------------------------- //
}
// -- akhir Buku Controller