<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Anggota;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Forget extends Model
{
    public $email;
    public $token;
    // public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['token'], 'safe'],
        ];
    }

    // Kirim cek email ada tidak di databases.
    public function Email()
    {
        $model = Anggota::findOne(['email' => $this->email]);

        if ($model !== null) {
            Yii::$app->mail->compose('@app/template/passwordemail',['model' => $model])
                ->setFrom('firstiaulyaa@gmail.com')
                ->setTo($this->email)
                ->setSubject('Reset Password - myLibrary')
                ->send();
            return true;
        }
        return false;
    }
}