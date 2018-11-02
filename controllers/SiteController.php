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
use app\models\Registrasi;
use app\models\NewPassword;
use app\models\Anggota;
use app\models\Forget;
use yii\web\NotFoundHttpException;
use yii\authclient\client\Facebook;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\web\UploadedFile;


class SiteController extends Controller
{
    // public $successUrl = '';
    /**
     * {@inheritdoc}
     */

    // public function actionEmail()
    // {
    //     return Yii::$app->mail->compose()
    //     ->setFrom('samsulaculhadi@gmail.com')
    //     ->setTo('firstiaulyaa@gmail.com')
    //     ->setSubject('Hai')
    //     ->setTextBody('<b>hallo guys</b>')
    //     ->send();
    // }
    // public function actionDownload()
    // {
    //     return \Yii::$app->response->sendFile('path/to/file.txt');
    // }
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
                'only' => ['logout', 'registrasi'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['registrasi'],
                        'allow' => true,
                        'roles' => ['?'],
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
            'auth' => [
              'class' => 'yii\authclient\AuthAction',
              'successCallback' => [$this, 'oAuthSuccess'],
              // 'successUrl' => $this->successUrl
          ],
      ];
  }

    /**
     * Displays homepage.
     *
     * @return string
     */

    // redirect itu buat array, bukan string atau bisa dikatakan untuk mengalihkan sebuah halaman ke url atau route lain.
    // dan untuk render kemungkinan bukan untuk arayy, tapi kebalikanya yaitu string. untuk nampilin sebuah view atau template lain.
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->redirect(['site/dashboard']);
        }
        else
        {
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
    public function actionDashboard()
    {

        if (User::isAdmin() || User::isAnggota() || User::isPetugas()) {
            $provider = new ActiveDataProvider([
                'query' => \app\models\Buku::find(),
                'pagination' => [
                    'pageSize' => 6
                ],
                // 'sort' => [
                //     'defaultOrder' => [
                //         'created_at' => SORT_DESC,
                //         'title' => SORT_ASC, 
                //     ]
                // ],
            ]);
            return $this->render('dashboard', ['provider' => $provider]);
        }
        else
        {
            return $this->redirect('site/login');
        }
        // if (User::isAdmin())
        // {
        //     return $this->render('dashboard');
        // }
        // elseif (User::isAnggota()) {
        //     return $this->render('dashboard');
        // }
        // elseif (User::isPetugas()) {
        //     return $this->render('dashboard');
        // }
        // else
        // {
        //     return $this->redirect(['site/login']);
        // }
        // // return $this->render('dashboard');
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

            $foto = UploadedFile::getInstance($model, 'foto');
            $model->foto = time(). '_' . $foto->name;
            $foto->saveAs(Yii::$app->basePath. '/web/user/' . $model->foto);
            $anggota->foto = $model->foto;
            $anggota->save();

            // if($anggota->save()) {
            //     Yii::$app->session->setFlash('success','Data berhasil disimpan.');

            $user = new User();
            $user->id_anggota = $anggota->id;
            $user->id_user_role = $anggota->id;
            $user->username = $model->username;
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $user->id_petugas = 0;
            $user->id_user_role = 2;
            $user->status = 1;
            // token berfungsi untuk membedakan atau menjadikan identitas sebuah user. untuk mengamankan sebuah transaksi.
            $user->token = Yii::$app->getSecurity()->generateRandomString(100);
            $user->save();
            Yii::$app->session->setFlash('success', 'Berhasil Registrasi. Silahkan Login.');

            // if($user->save()) {
            //     Yii::$app->session->setFlash('success','Data berhasil disimpan.');

            return $this->redirect(['site/login']);
        }

        // $model->password = '';
        return $this->render('registrasi', [
            'model' => $model,
        ]);
    }
    
    public function actionForget()
    {
        $this->layout = 'main-login';
        $model = new Forget();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!$model->Email()) {
                Yii::$app->session->setFlash('warning', 'Email tidak ditemukan');
                return $this->refresh();
            }
            else
            {
                Yii::$app->session->setFlash('success', 'Berhasil, Silahkan Cek Email Anda');
                return $this->redirect(['site/login']);
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
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->new_password);
            $user->token = Yii::$app->getSecurity()->generateRandomString(100);
            $user->save();
            return $this->redirect(['site/login']);
        }

        return $this->render('new_password', [
            'model' => $model,
        ]);
    }

    public function oAuthSuccess($client) 
    {
    // get user data from client
      $userAttributes = $client->getUserAttributes();
      // $user = \app\models\User::find()
      // ->where(['username' => $attributes['username'],])
      // ->one();
      // if (!empty($user)) {
      //     Yii::$app->user->login($user);
      // }
      // else
      // {
      //   $session = Yii::$app->session;
      //   $session['attributes'] = $attributes;
      //   $this->successUrl = \yii\helpers\Url::to(['registrasi']);
      // }
    // do some thing with user data. for example with $userAttributes['email']
  }
}
