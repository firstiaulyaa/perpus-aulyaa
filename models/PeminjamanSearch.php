<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Peminjaman;
use app\models\User;
use app\models\StatusBuku;

/**
 * PeminjamanSearch represents the model behind the search form of `app\models\Peminjaman`.
 */
class PeminjamanSearch extends Peminjaman
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_buku', 'id_anggota', 'status_buku'], 'integer'],
            [['tanggal_pinjam', 'tanggal_kembali', 'tanggal_pengembalian_buku'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (Yii::$app->user->identity->id_user_role == 1) {
            $query = Peminjaman::find();

        // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $this->load($params);

            if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
                return $dataProvider;
            }

        // grid filtering conditions
            $query->andFilterWhere([
                'id' => $this->id,
                'id_buku' => $this->id_buku,
                'id_anggota' => $this->id_anggota,
                'tanggal_pinjam' => $this->tanggal_pinjam,
                'tanggal_kembali' => $this->tanggal_kembali,
                'status_buku' => $this->status_buku,
                'tanggal_pengembalian_buku' => $this->tanggal_pengembalian_buku,
            ]);

            return $dataProvider;
        }

        // Menampilkan data peminjaman berdasarkan anggota yang meminjam buku.
        if (Yii::$app->user->identity->id_user_role == 2) {
            $query = Peminjaman::find()->andWhere(['id_anggota' => Yii::$app->user->identity->id_anggota]);

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'id' => $this->id,
                'id_buku' => $this->id_buku,
                'id_anggota' => $this->id_anggota,
                'tanggal_pinjam' => $this->tanggal_pinjam,
                'tanggal_kembali' => $this->tanggal_kembali,
                'status_buku' => $this->status_buku,
                'tanggal_pengembalian_buku' => $this->tanggal_pengembalian_buku,
            ]);

            return $dataProvider;
        }

        // Menampilkan data peminjaman.
        if (Yii::$app->user->identity->id_user_role == 3) {
            $query = Peminjaman::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'id' => $this->id,
                'id_buku' => $this->id_buku,
                'id_anggota' => $this->id_anggota,
                'tanggal_pinjam' => $this->tanggal_pinjam,
                'tanggal_kembali' => $this->tanggal_kembali,
                'status_buku' => $this->status_buku,
                'tanggal_pengembalian_buku' => $this->tanggal_pengembalian_buku,
            ]);

            return $dataProvider;
        }
    }
}
