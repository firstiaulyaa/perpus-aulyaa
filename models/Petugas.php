<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "petugas".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 */
class Petugas extends \yii\db\ActiveRecord
{
    public $username;
    public $password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'petugas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'Username tidak boleh kosong'],
            [['password'], 'string', 'min' => 6],
            [['nama', 'alamat'], 'string', 'max' => 255],
            [['telepon', 'email'], 'string', 'max' => 50],
            [['email'], 'email'],
            ['telepon', 'match', 'pattern' => '/((\+[0-9]{6})|0)[-]?[0-9]{7}/', 'message' => 'Hanya nomor dari 0 sampai 9'],
            [['foto'], 'file', 'extensions' => 'jpg, gif, png', 'maxSize' => 5218288, 'tooBig' => 'Batas limit upload gambar 5mb'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'email' => 'Email',
        ];
    }

    

    // --------------------------------- //
    // untuk menghitung data pada grafik //
    // --------------------------------- //

    public static function getCount()
    {
        return static::find()->count();
    }

    // --------------------------------- //

}
