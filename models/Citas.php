<?php

namespace app\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "citas".
 *
 * @property int $id
 * @property string $fecha
 * @property string $hora
 * @property int $usuario_id
 *
 * @property Usuarios $usuario
 */
class Citas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'citas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'hora', 'usuario_id'], 'required'],
            [['fecha', 'hora'], 'safe'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }

    public function getCitasPasado() {

    }

    public static function citaPendiente() {
        $cita = Citas::find();
        $usuario_id = Yii::$app->user->id;
        $hoy = new DateTime('now');

        $cita->where([
            'usuario_id' => $usuario_id,
        ])
        ->andWhere([
            '>=', 'fecha', $hoy->format('Y/m/d'),
        ])
        ->one();

        return $cita;
    }
}
