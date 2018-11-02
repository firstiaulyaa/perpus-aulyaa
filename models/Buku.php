<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buku".
 *
 * @property int $id
 * @property string $nama
 * @property string $tahun_terbit
 * @property int $id_penulis
 * @property int $id_penerbit
 * @property int $id_kategori
 * @property string $sinopsis
 * @property string $sampul
 * @property string $berkas
 */

// Buku Models
class Buku extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buku';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['tahun_terbit'], 'safe'],
            [['id_penulis', 'id_penerbit', 'id_kategori'], 'integer'],
            [['sinopsis'], 'string'],
            [['nama', 'harga'], 'string', 'max' => 255],
            [['sampul'], 'file', 'extensions'=>'jpg, gif, png', 'maxSize'=>5218288, 'tooBig' => 'batas limit upload gambar 5mb'
            ],
            [['berkas'], 'file', 'extensions'=>'docx, doc, pdf, xls'],
        ];
    }

    // action untuk menampilkan judul field pada tabel
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Buku',
            'tahun_terbit' => 'Tahun Terbit',
            'id_penulis' => 'Penulis',
            'id_penerbit' => 'Penerbit',
            'id_kategori' => 'Kategori',
            'sinopsis' => 'Sinopsis',
            'sampul' => 'Sampul',
            'berkas' => 'Berkas',
            'harga' => 'Harga',
        ];
    }
    // ------------------------------------------------------------- //



    // untuk menampilkan data penulis (nama sesuai id) pada modul buku //
    public function getPenulis()
    {
        return $this->hasOne(Penulis::class, ['id' => 'id_penulis']);
    }
    // ------------------------------------------------------------- //



    // untuk menampilkan data penerbit (nama sesuai id) pada modul buku //
    public function getPenerbit()
    {
        return $this->hasOne(Penerbit::class, ['id' => 'id_penerbit']);
    }
    // ------------------------------------------------------------- //



    // untuk menampilkan data kategori (nama sesuai id) pada modul buku //
    public function getKategori()
    {
        return $this->hasOne(Kategori::class, ['id' => 'id_kategori']);
    }
    // ------------------------------------------------------------- //



    // untuk menampilkan (list) data anggota berdasarkan id dan nama //
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }
    // ------------------------------------------------------------- //



    // untuk menghitung jumlah semua data buku (untuk ditampilkan pada grafik) //
    public static function getCount()
    {
        return static::find()->count();
    }
    // ------------------------------------------------------------- //



    // contoh untuk menampilkan tulisan (di myLibrary tidak ditampilkan) //
    //  public static function hallo()
    // {
    //     return "Selamat Datang";
    // }

    // public static function hallolagi()
    // {
    //     return "Lalalalalalalalalala";
    // }

    // public function halo()
    // {
    //     return "Lililililili";
    // }
    // ------------------------------------------------------------- //
}
// -- akhir Buku Models