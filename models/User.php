<?php

namespace app\models;

use Yii;

/**
* This is the model class for table "user".
*
* @property int $id
* @property string $username
* @property string $password
* @property int $id_anggota
* @property int $id_petugas
* @property int $id_user_role
* @property int $status
*/
class user extends \yii\db\ActiveRecord  implements \yii\web\IdentityInterface
{
   /**
    * {@inheritdoc}
    */
   public static function tableName()
   {
       return 'user';
   }

   /**
    * {@inheritdoc}
    */
   public function rules()
   {
       return [
           [['username', 'password'], 'required'],
           [['id_anggota', 'id_petugas', 'id_user_role', 'status'], 'integer'],
           [['username'], 'string', 'max' => 255],
           [['password'], 'string', 'max' => 25],
       ];
   }

   /**
    * {@inheritdoc}
    */
   public function attributeLabels()
   {
       return [
           'id' => 'ID',
           'username' => 'username',
           'password' => 'password',
           'id_anggota' => 'Anggota',
           'id_petugas' => 'Petugas',
           'id_user_role' => 'Id User Role',
           'status' => 'Status',
       ];
   }