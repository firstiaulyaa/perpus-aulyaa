<?php

namespace app\controllers;

use Yii;
use app\models\Penulis; // untuk memanggil model Penulis
use app\models\penulisSearch; // untuk memanggil model PenulisSearch
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

/**
 * PenulisController implements the CRUD actions for Penulis model.
 */
class PenulisController extends Controller
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
    // action untuk menampilkan semua data pada Data Penulis (index.php) //
    // ----------------------------------------------------------------- //

    /**
     * Lists all Penulis models.
     * @return mixed
     */
    public function actionIndex()
        {
            $searchModel = new penulisSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

    // ----------------------------------------------------------------- //



    // -------------------------------------------------------------------------------- //
    // action untuk menampilkan suatu data yang dipilih pada Data Anggota pada view.php //
    // -------------------------------------------------------------------------------- //

    /**
     * Displays a single Penulis model.
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
    // action untuk menambahkan penulis ke database pada create.php //
    // ------------------------------------------------------------ //

    /**
     * Creates a new Penulis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
        {
            $model = new Penulis();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }

    // --------------------------------------------------------------- //



    // --------------------------------------------------------------- //
    // action untuk melakukan update data yang dipilih pada update.php //
    //---------------------------------------------------------------- //

    /**
     * Updates an existing Penulis model.
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

    // ------------------------------------------------------------- //



    // -------------------------------------------------------- //
    // action untuk menghapus data yang dipilih di Data Penulis //
    // -------------------------------------------------------- //

    /**
     * Deletes an existing Penulis model.
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

    // -------------------------------------------------------- //



    // ------------------------------------------------------- //
    // action untuk memanggil model Data Penulis di model lain //
    // ------------------------------------------------------- //

    /**
     * Finds the Penulis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penulis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penulis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // -------------------------------------------------------- //


    //Untuk Export Buku ke word

   public function actionExportWord()
   {
       $phpWord = new \PhpOffice\PhpWord\PhpWord();
       $phpWord->setDefaultFontSize(11);
       $phpWord->setDefaultFontName('Bookman Old Style');
       $phpWord->setDefaultParagraphStyle(
       array(
           'align'      => 'both',
           'spaceAfter' => Converter::pointToTwip(0.7),
           'spacing'    => 0,
           )
       );
       $sectionStyle = [
           'marginTop'=>Converter::cmToTwip(2.25),
           'marginBottom'=>Converter::cmToTwip(2.49),
           'marginLeft'=>Converter::cmToTwip(2.2),
           'marginRight'=>Converter::cmToTwip(2.6),
       ];
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
       //START HEADER
       $header_alamat = ['bold' => false, 'size' => 12];
       $header_style = ['bold' => false, 'size' => 12,];
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

       //START Of HEADER
       $textrun = $header_page->addTextRun('headerPStyle');
       $textrun->addImage('images/logo.jpg', $imageStyle);
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
        $filename = time() . '_' . 'export-word.docx';
        $path = 'document' . $filename;
        $xmlWrite = IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWrite->save($path);

        return $this->redirect($path);
   }
}
