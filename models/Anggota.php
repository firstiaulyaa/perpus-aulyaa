<?php

namespace app\models;

use Yii;
use yii\helpers\StringHelper;
/**
 * This is the model class for table "anggota".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 * @property int $status_aktif
 */
class Anggota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anggota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['status_aktif'], 'integer'],
            [['nama', 'alamat'], 'string', 'max' => 255],
            [['telepon', 'email'], 'string', 'max' => 50],
            [['foto'], 'file', 'extensions'=>'jpg, gif, png', 'maxSize'=>5218288, 'tooBig' => 'batas limit upload gambar 5mb'],
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
            'status_aktif' => 'Status Aktif',
            'foto' => 'Foto',
        ];
    }
    public static function getCount()
    {
        return static::find()->count();
    }
    public static function getList()
    {
        if (User::isAnggota())
        {
            return \yii\helpers\ArrayHelper::map(Anggota::find()->andWhere(['id' => Yii::$app->user->identity->id_anggota])->all(), 'id', 'nama');
        }
    }
    // Relasi dengan User
    public function getUser()
    {
        return $this->hasOne(User::class, ['id_anggota' => 'id']);
    }
    // public function getManyBuku()
    // {
    //     return $this->hasMany(Buku::class, ['id_anggota' => 'id']);
    // }
    // public static function getGrafikList()
    // {
    //     $data = [];
    //     foreach (static::find()->all() as $anggota) {
    //         $data[] = [StringHelper::truncate($anggota->nama, 20), (int) $anggota->getManyBuku()->count()];
    //     }
    //     return $data;
    // }
}
