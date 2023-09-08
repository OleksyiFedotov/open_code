<?php
/* @var $this yii\web\View */
/* @var $article Article */

use app\components\I18;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Article;
use yii\widgets\LinkPager;

$this->params['breadcrumbs'][] = [ "label"=>I18::decode($this->title)];
?>

<main>
    <section class="page-news">
        <div class="container">
            <div class="title__block">
                <h1 class="title__main">
                    <?=$title;?>
                </h1>
            </div>
            <div class="page-news__wrapper">
                <div class="page-news__content">
                    <div class="page-news__block btn__news">
                        <div class="page-news__all-content">
                            <div class="page-news__all-content__inner">
                                <?php if(!empty($allArticles)) :?>
                                    <?php foreach ($allArticles as $allArticle) :?>
                                        <a href="<?=Url::to(['/articles/article', 'slug' =>$allArticle->keywords, 'id'=>$allArticle->id, 'catid'=>!empty($catid->id) ? ($catid->id) : $catid ]);?>" class="news__all-content__wrap">
                                            <div class="page-news__cart">
                                                <div class="page-news__cart-img">
                                                    <img class="page-news__cart-img-item" src="<?=$allArticle->getImage();?>" alt="">
                                                </div>
                                                <div class="page-news__cart-wrap">
                                                    <div class="page-news__cart-title">
                                                        <?=I18::decode($allArticle->title);?>
                                                    </div>
                                                    <div class="page-news__cart-link">
                                                        <?=Yii::t('app','Більше');?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </div>
                            <div class="news__all-content__link">
                                <button class="button__main">
                                    <?=Yii::t('app','Завантажити ще...');?>
                                </button>
                            </div>
                            <div class="pagination">
                                <?php echo LinkPager::widget(['pagination' => $pages,
                                    'maxButtonCount' => 6,
                                    //Css option for container
                                    'options' => ['class' => 'pagination'],
                                    'firstPageLabel' => '&lt',
                                    'lastPageLabel' => '&gt',
                                    'prevPageLabel' => '&laquo; back',
                                    'nextPageLabel' => 'next &raquo',
                                    'activePageCssClass' => 'active',
                                    'linkOptions' => ['class' => 'link'],
                                    'disabledPageCssClass' => 'disabled',
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    $(function(){
        $(".news__all-content__link .button__main").click(function(){
            showPageArticles();
        })
    })
</script>