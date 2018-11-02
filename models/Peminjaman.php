<?php

namespace app\models;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "peminjaman".
 *
 * @property int $id
 * @property int $id_buku
 * @property int $id_anggota
 * @property string $tanggal_pinjam
 * @property string $tanggal_kembali
 * @param $tanggal_lalu
 * @param $tanggal_sekarang
 * @param string $key default (days)
 * @return int
*/
class Peminjaman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peminjaman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_buku', 'id_anggota', 'tanggal_pinjam', 'tanggal_kembali', 'status_buku'], 'required'],
            [['id_buku', 'id_anggota'], 'integer'],
            [['tanggal_pinjam', 'tanggal_kembali', 'tanggal_pengembalian_buku'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_buku' => 'Buku',
            'id_anggota' => 'Anggota',
            'tanggal_pinjam' => 'Tanggal Pinjam',
            'status_buku' => 'Status Buku',
            'tanggal_pengembalian_buku' => 'Tanggal Pengembalian Buku',
        ];
    }
    public static function getCount()
    {
        return static::find()->count();
    }
    public static function getList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'nama');
    }
    public function getAnggota()
    {
        return $this->hasOne(Anggota::class, ['id' => 'id_anggota']);
    }
    public function getBuku()
    {
        return $this->hasOne(Buku::class, ['id' => 'id_buku']);
    }
    public static function getListBulanGrafik()
    {
        $list = [];

        for ($i=1; $i <= 12 ; $i++) {
            $list[] = self::getBulanSingkat($i);
        }

        return $list;
    }
                            
    public static function getCountGrafik()
    {
        $list = [];
        for ($i = 1; $i <= 12; $i++) {
            if (strlen($i) == 1) $i = '0' . $i;
            $count = static::findCountGrafik($i);

            $list [] = (int)@$count->count();

        }

        return $list;
    }

    public static function findCountGrafik($bulan)
    {
        $tahun = date('Y');
        $lastDay = date("t", strtotime($tahun.'_'.$bulan));

        return static::find()->andWhere(['between','tanggal_pinjam', "$tahun-$bulan-01", "$tahun-$bulan-$lastDay"]);
    }
    public function getStatusPeminjaman()
    {
        if ($this->status_buku === 0) {
            return "Dikembalikan";
        }
        else{
            return "Belum di kembalikan";
        }
    }
    public static function getSelisihTanggal($tanggal_lalu, $tanggal_sekarang, $key = 'd')
    {
        $tanggal_lalu  = date_create($tanggal_lalu);
        $tanggal_sekarang = date_create($tanggal_sekarang)/*->modify('+1 day')*/; //Tangal sekarang +1 hari
        $diff  = date_diff($tanggal_lalu, $tanggal_sekarang);
        switch ($key) {
            case 'y':
                return $diff->y;
                break;
            case 'm':
                return $diff->m;
                break;
            case 'd':
                return $diff->d;
                break;
            default:
                return $diff->h;
                break;
        }
    }
    public function getTanggal()
    {
        return $this->getSelisihTanggal($this->tanggal_pinjam, $this->tanggal_kembali);
    }
}
