<?php

namespace app\models;

/**
 * This is the model class for table "noticias".
 *
 * @property int $id
 * @property string $titulo
 * @property string $noticia
 * @property string $link
 * @property int $usuario_id
 * @property int $categoria_id
 * @property string $created_at
 *
 * @property Comentarios[] $comentarios
 * @property Movimientos[] $movimientos
 * @property Usuarios[] $usuarios
 * @property Categorias $categoria
 * @property Usuarios $usuario
 */
class Noticias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noticias';
    }


    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'noticia', 'link', 'usuario_id', 'categoria_id'], 'required'],
            [['noticia'], 'string'],
            [['usuario_id', 'categoria_id'], 'default', 'value' => null],
            [['usuario_id', 'categoria_id'], 'integer'],
            [['created_at'], 'safe'],
            [['titulo', 'link'], 'string', 'max' => 255],
            [['link'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'noticia' => 'Noticia',
            'link' => 'Link',
            'usuario_id' => 'Usuario ID',
            'categoria_id' => 'Categoria ID',
            'created_at' => 'Created At',
            'imageFile' => 'Imagen',
        ];
    }

    public function upload()
    {
        return $this->validate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentarios::className(), ['noticia_id' => 'id'])->inverseOf('noticia');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovimientos()
    {
        return $this->hasMany(Movimientos::className(), ['noticia_id' => 'id'])->inverseOf('noticia');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('movimientos', ['noticia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria_id'])->inverseOf('noticias');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('noticias');
    }
}
