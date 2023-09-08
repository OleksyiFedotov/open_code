<?php

use app\components\I18;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = Yii::t('app', 'Оновити статтю: {name}', [
    'name' => I18::decode($model->title),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Статті'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => I18::decode($model->title), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Оновити');
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
