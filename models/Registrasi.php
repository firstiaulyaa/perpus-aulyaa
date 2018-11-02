<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * LoginForm is the model basename(path)ehind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Registrasi extends Model
{
    public $username;
    public $password;
    public $nama;
    public $alamat;
    public $telepon;
    public $email;
    public $foto;
    public $verifyCode;
    // public $captcha;
    // public $recaptcha;
    // public $email_var;
    // public $rememberMe = true;
    // private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // [['password','date_var'],'safe'],
            // ['password', 'required', 'on' => ['register']],
            // ['password', 'string', 'min' => 6, 'max' => 72, 'on' => ['register', 'create']],
            // ['username', 'match', 'pattern' => '/^\d{10}$/', 'message'=> 'Kolom harus terisi 10 digit'],
            // [['passwordConfirm'], 'compare', 'compareAttribute' => 'password'],
            // ['website', 'url', 'defaultScheme' => 'http'],
            // ['recaptcha', 'compare', 'compareAttribute' => 'captcha', 'operator' => '=='],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'Username tidak boleh kosong'],
            [['nama', 'alamat'], 'required', 'message'=> 'Data tidak boleh kosong'],
            [['password'], 'string', 'min' => 6],
            ['telepon', 'match', 'pattern' => '/((\+[0-9]{6})|0)[-]?[0-9]{7}/', 'message' => 'Hanya dari nomor 0 sampai 9'],
            [['email'], 'unique', 'targetClass' => '\app\models\Anggota'],
            [['foto'], 'file', 'extensions'=>'jpg, gif, png', 'maxSize'=>5218288, 'tooBig' => 'batas limit upload gambar 5mb'],
            ['verifyCode', 'captcha'],
        ];
    }
    
}
