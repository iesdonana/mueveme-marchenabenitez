<?php

namespace app\models;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property string $comentario
 * @property int $usuario_id
 * @property int $noticia_id
 * @property int $comentario_id
 * @property string $created_at
 *
 * @property Comentarios $comentario0
 * @property Comentarios[] $comentarios
 * @property Noticias $noticia
 * @property Usuarios $usuario
 * @property Votos[] $votos
 * @property Usuarios[] $usuarios
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comentario', 'usuario_id', 'noticia_id'], 'required'],
            [['comentario'], 'string'],
            [['usuario_id', 'noticia_id', 'comentario_id'], 'default', 'value' => null],
            [['usuario_id', 'noticia_id', 'comentario_id'], 'integer'],
            [['created_at'], 'safe'],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['comentario_id' => 'id']],
            [['noticia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Noticias::className(), 'targetAttribute' => ['noticia_id' => 'id']],
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
            'comentario' => 'Comentario',
            'usuario_id' => 'Usuario ID',
            'noticia_id' => 'Noticia ID',
            'comentario_id' => 'Comentario ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentario0()
    {
        return $this->hasOne(self::className(), ['id' => 'comentario_id'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(self::className(), ['comentario_id' => 'id'])->inverseOf('comentario0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticia()
    {
        return $this->hasOne(Noticias::className(), ['id' => 'noticia_id'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Votos::className(), ['comentario_id' => 'id'])->inverseOf('comentario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('votos', ['comentario_id' => 'id']);
    }

    public function getComentariosHijos($noticia_id, $comentario_id)
    {
        return $this
            ->find()
            ->where(['comentario_id' => $comentario_id, 'noticia_id' => $noticia_id])
            ->all();
    }
}
