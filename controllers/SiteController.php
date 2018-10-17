<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\RegisterForm;
use app\models\Buku; // untuk memanggil model buku
use Mpdf\Mpdf; //untuk memanggil ekstension pdf
use app\models\Forget;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function actionEmail()
   {
       return Yii::$app->mail->compose()
       ->setFrom('firstiaulyaa@gmail.com')
       ->setTo('samsulaculhadi@gmail.com')
       ->setSubject('Hai')
       ->setTextBody('<b>hallo guys</b>')
       ->send();
   }

   public function actionForget()
   {
       $this->layout = 'main-login';
       $model = new Forget();

       if ($model->load(Yii::$app->request->post()) && $model->validate()) {
           if (!$model->Email()) {
               Yii::$app->session->setFlash('Gagal', 'Email tidak ditemukan');
               return $this->refresh();
           }
           else
           {
               Yii::$app->session->setFlash('Berhasil', 'Cek Email Anda');
               return $this->redirect('site/login');
           }
       }
       return $this->render('forget', [
           'model' => $model,
       ]);
   }

   public function actionNewPassword($token)
   {
       $this->layout = 'main-login';
       $model = new NewPassword();

       // Untuk mendapatkan token yang ada di tabel user yang dimana sudah di relasikan di anggota model
       $user = User::findOne(['token' => $token]);

       if ($user === null) {
           throw new NotFoundHttpException("Halaman tidak ditemukan", 404);
       }

       if ($model->load(Yii::$app->request->post()) && $model->validate()) {

           $user = new User();
           $user->password = $model->new_password;
           $user->token = Yii::$app->getSecurity()->generateRandomString ( $length = 50 );
           $user->save();
           return $this->redirect(['site/login']);
       }

       return $this->render('new_password', [
           'model' => $model,
       ]);
   }

    public function verifyCode()
    {
        return[
                'captcha' => [
                    'class' => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionRegistrasi()
   {
       $this->layout = 'main-login';
       $model = new Registrasi();
       if ($model->load(Yii::$app->request->post()))
       {
           $anggota = new Anggota();
           $anggota->nama = $model->nama;
           $anggota->alamat = $model->alamat;
           $anggota->telepon = $model->telepon;
           $anggota->email = $model->email;
           $anggota->status_aktif = 1;
           $anggota->save();

           // if($anggota->save()) {
           //     Yii::$app->session->setFlash('success','Data berhasil disimpan.');

           $user = new User();
           $user->id_anggota = $anggota->id;
           $user->id_user_role = $anggota->id;
           $user->username = $model->username;
           $user->password = $model->password;
           $user->id_petugas = 0;
           $user->id_user_role = 2;
           $user->status = 1;
           // token berfungsi untuk membedakan atau menjadikan identitas sebuah user. untuk mengamankan sebuah transaksi.
           $user->token = Yii::$app->getSecurity()->generateRandomString ( $length = 50 );
           $user->save();

           // if($user->save()) {
           //     Yii::$app->session->setFlash('success','Data berhasil disimpan.');

           return $this->redirect(['site/login']);
       }

       // $model->password = '';
       return $this->render('registrasi', [
           'model' => $model,
       ]);
   }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) 
        {
            return $this->redirect(['site/dashboard']);
        } else {
            return $this->redirect(['site/login']);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


     // ------------------------------------------------------ //
    // action untuk melakukan eksport Data Buku ke pdf (.pdf) //
    // ------------------------------------------------------ //

    public function actionExportPdf() 
       {
             $this->layout='main1';
             $model = Buku::find()->All();
             $mpdf=new mPDF();
             $mpdf->WriteHTML($this->renderPartial('template',['model'=>$model]));
             $mpdf->Output('DataBuku.pdf', 'D');
             exit;
       }

   // ------------------------------------------------------ //


    // Custom Sendiri untuk dashboard
    public function actionDashboard()
    {
        // if (User::isAdmin() || User::isAnggota()) {
         if (User::isAdmin()) {
            return $this->render('dashboard');
        } elseif (User::isAnggota()) {
             return $this->render('dashboard');
            
        } elseif (User::isPetugas()) {
             return $this->render('dashboard');
        }
        else
         {
         return $this->redirect(['site/login']);
        }
        //  return $this->render('dashboard');
    }


    // register
        //untuk membuat register sendiri
    public function actionRegister()
    {
        //agar secara otomatis membuat sendiri
        $this->layout='main-login';
        //$model untuk layout register
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $anggota = new Anggota();
            $anggota->nama = $model->nama;
            $anggota->alamat = $model->alamat;
            $anggota->telepon = $model->telepon;
            $anggota->email = $model->email;
            $anggota->save();

            $user = new User();
            $user->username = $model->username;
            $user->password = $model->password;
            $user->id_anggota = $anggota->id;
            $user->id_petugas = 0;
            $user->id_user_role = 2;
            $user->status = 2;
            $user->save();

            return $this->redirect(['site/login']);
        } 

        //untuk memunculkan form dari halaman register
        return $this->render('register', ['model'=>$model]);
    }

    // ============================================================= 
    // lupa password melalui email
}
