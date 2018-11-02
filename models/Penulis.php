<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penulis".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 */
class Penulis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penulis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['alamat'], 'string'],
            [['nama', 'telepon', 'email'], 'string', 'max' => 255],
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



    // ------------------------------------------------------- //
    // untuk memanggil semua list data berdasarkan id dan nama //
    // ------------------------------------------------------- //

    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }

    // ------------------------------------------------------- //
    


    // ------------------------------------------------------- //
    // untuk menampilkan semua data buku berdasarkan id_penerbit //
    // ------------------------------------------------------- //

    public function findAllBuku()
    {
        return Buku::find()
        ->andWhere(['id_penulis' => $this->id])
        ->all();
    }


    // ------------------------------------------------------- //
    // untuk menampilkan semua jumlah data buku berdasarkan id_penulis //
    // ------------------------------------------------------- //

    public function getJumlahBuku()
    {
        return Buku::find()
        ->andWhere(['id_penulis' => $this->id])
        ->count();
    }

    // ------------------------------------------------------- //

    

    // --------------------------------- //
    // untuk menghitung data pada grafik //
    // --------------------------------- //

    public static function getCount()
    {
        return static::find()->count();
    }

    // --------------------------------- //



    // ---------------------------------------------------- //
    // Mengambil semua data yang ada di tabel buku yang dimana id buku akan ditampilkan berdasarkan id_*** / id_*** akan mengambil data di buku yang berkaitan dengan id_*** //
    // ---------------------------------------------------- //

    public function getManyBuku()
    {
        return $this->hasMany(Buku::class, ['id_Penulis' => 'id']);
    }

    // ---------------------------------------------------- //
    


    // ------------------------------------------------------ //
    // Menjumlah semua data buku yang berkaitan dengan id_*** //
    // ------------------------------------------------------ //

    public static function getGrafikList()
    {
        $data = [];
        foreach (static::find()->all() as $penulis) {
            $data[] = [$penulis->nama, (int) $penulis->getManyBuku()->count()];
        }
        return $data;
    }

    // ----------------------------------------------------- //
}
