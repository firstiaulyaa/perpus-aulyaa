<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penerbit".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telepon
 * @property string $email
 */
class Penerbit extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penerbit';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alamat'], 'string'],
            [['nama', 'telepon'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 2555],
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

    /**
     * @inheritdoc
     * @return array untuk dropdown
     */
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }

    // ------------------------------------------------------- //



    // --------------------------------------------------------- //
    // untuk menampilkan semua data buku berdasarkan id_penerbit //
    // --------------------------------------------------------- //

    public function findAllBuku()
    {
        return Buku::find()
        ->andWhere(['id_penerbit' => $this->id])
        ->orderBy(['nama' => SORT_ASC])
        ->all();
    }

     // ------------------------------------------------------- //
    


    // --------------------------------- //
    // untuk menghitung data pada grafik //
    // --------------------------------- //

    public static function getCount()
    {
        return static::find()->count();
    }

    // ------------------------------------------------------- //



    // ------------------------------------------------------- //
    // Mengambil semua data yang ada di tabel buku yang dimana id buku akan ditampilkan berdasarkan id_*** / id_*** akan mengambil data di buku yang berkaitan dengan id_*** //
    // ------------------------------------------------------- //

    public function getManyBuku()
    {
        return $this->hasMany(Buku::class, ['id_Penerbit' => 'id']);
    }

    // ------------------------------------------------------- //



    // ------------------------------------------------ //
    // memanggil semua data buku (penerbit) pada grafik //
    // ------------------------------------------------ //

    public static function getGrafikList()
    {
        $data = [];
        foreach (static::find()->all() as $penerbit) {
            $data[] = [$penerbit->nama, (int) $penerbit->getManyBuku()->count()];
        }
        return $data;
    }

    // ------------------------------------------------------- //

}
