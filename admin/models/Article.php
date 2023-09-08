<?php

namespace app\models;

use app\components\Transforfilter;
use Yii;
use yii\base\Model;
use app\modules\auth\models\User;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $user_id
 * @property int|null $viewed
 * @property int|false $status
 * @property string|null $keywords
 * @property string|null $meta
 * @property string|null $alt
 *
 * * @property User $user
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'keywords'], 'required'],
            [['content'], 'string', 'max' => 10000],
            [['date'], 'date', 'format'=>'Y-m-d'],
            [['date'], 'default','value'=>date('Y-m-d')],
            [['viewed', 'user_id'], 'integer'],
            [['title', 'keywords', 'alt'], 'string', 'max' => 500],
            [['title','content','keywords','alt'],'filter','filter' => function($value) {
                return trim($value);}],
            [['image'], 'safe'],
            [['status'], 'boolean', 'trueValue' => true, 'falseValue' => false],
            [['meta'], 'in', 'range'=> ['index, follow', 'index, nofollow']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Назва',
            'content' => 'Опис',
            'date' => 'Дата',
            'image' => 'Малюнок',
            'viewed' => 'Перегляди',
            'user_id' => 'Автор',
            'status' => 'Статус активний',
            'keywords' => 'Слова-ключі',
            'meta' => 'Індексація сторінки',
            'alt' => 'Назва малюнка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function saveUser($user_id)
    {
        $user = User::findOne($user_id);
        if ($user != null) {
            $this->link('user', $user);
            return true;
        }
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()
    {
        return ($this->image) ? '/web/uploads/'. $this->image : '/no-image.png';
    }

    public function deleteImage()
    {
        $imageUploadModel= new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete(); //auto delete
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    public function viewedCounter()
    {
        $this->viewed +=1;
        return $this->save(false);
    }
}
