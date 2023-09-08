<?php

use app\components\I18;
use yii\helpers\Html;
use app\modules\auth\models\User;
use app\models\Article;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */


$this->title = I18::decode($model->title);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Статті'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Оновити'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Малюнок', ['set-image', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Видалити'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                "attribute"=>'title',
                "value"=>function($model, $widget){
                    return I18::decode($model["title"]);
                }
            ],
            [
                "attribute"=>'content',
                "value"=>function($model, $widget){
                    return I18::decode($model["content"]);
                }
            ],
            'date',
            'image',
            [   'label'=>"Автор",
                'value'=>function (Article $model, $widget)
                {
                    if($model->user == null)
                    {
                        $res ='зробіть вибір автора';
                    }else
                    {
                        $res= I18::decode($model->user->name).' '."[$model->user_id]";
                    }
                    return $res;

                }
            ],
            'viewed',
            'status',
            'keywords',
            'meta',
            [
                "attribute"=>'alt',
                "value"=>function($model, $widget){
                    return I18::decode($model["alt"]);
                }
            ],
        ],
    ]) ?>

</div>
