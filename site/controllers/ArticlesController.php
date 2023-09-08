<?php

namespace app\controllers;

use app\components\I18;
use app\components\S22;
use app\models\Article;
use app\models\CallForm;
use app\models\Category;
use app\models\MessageForm;
use Yii;
use app\models\ImageUpload;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

class ArticlesController extends Controller
{
    /**
     * {@inheritdoc}
     */
   public function actionAll()
    {
        try{
            $id=Yii::$app->request->get('id');
            if(!empty($id))
            {
                $page = Category::findOne($id);
                $urlstart=$page->url;;
                $url = S22::formatter_url($urlstart);
            }else
            {
                $urlstart=Yii::$app->request->url;
                $url = S22::formatter_url($urlstart);
                $page=Category::find()->where(['url'=>$url])->select(['*'])->one();
            }
            $catid = !empty($page->id) ? $page->id : $id;
            $title=I18::decode($page->title);
            $this->setMeta($page->title, !empty($page->keywords) ? $page->keywords : $page->title,!empty($page->description) ? I18::decode($page->description): $page->title, $page->meta);
            $query = Article::find()->where(['status' => true])->orderBy(['id'=>SORT_DESC]);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount'=>$countQuery->count(), 'pageSize'=>12]);
            $allArticles=$query->offset($pages->offset)->limit($pages->limit)->all();
            return $this->render('all', compact(['catid', 'url', 'title', 'allArticles', 'pages']));
        }catch (ErrorException $e) {
            return $this->redirect(['site/errors']);
}

    }

    public function actionArticle()
    {
        try{
            $id = Yii::$app->request->get('id');
            $categoryId = Yii::$app->request->get('catid');
            $category=Category::findOne($categoryId);
            //all article
            $article=Article::findOne($id);
            $similarArticles = S22::Article();
            $title=I18::decode($article->title);
            $this->setMeta(I18::decode($article->title), !empty($article->keywords) ? $article->keywords : '', I18::decode($article->content), $article->meta);
            //viewin
            $article->viewedCounter();
            $messageForm = new MessageForm();
            if(Yii::$app->request->isPost and !empty($messageForm)) {
                if ($messageForm->load(Yii::$app->request->post())) {
                    $messageForm->validate();
                    Yii::$app->mailer->compose('layouts/message', compact(['messageForm']))
                        ->setFrom(['info@eservice.org.ua' => 'e-service'])
                        ->setTo([Yii::$app->params['adminEmail']])
                        ->setSubject('Клієнт підписався на листування.')
                        ->send();
                    Yii::$app->session->setFlash('success', "Ваc підписано на розсилання!");
                    return $this->redirect(['articles/article', 'id' => $article->id, 'slug' =>$article->keywords, 'catid' => $categoryId]);
                }else{
                        return $this->redirect(['site/errors']);
                    }
            }else {
                return $this->render('article', compact(['similarArticles', 'id', 'categoryId', 'category', 'title', 'article', 'messageForm']));
            }
        }catch (ErrorException $e) {
            return $this->redirect(['site/errors']);
        }
    }

    protected function setMeta($title= null, $keywords = null, $content=null, $meta=null)
    {
        $this->view->title=I18::decode($title);
        $this->view->registerMetaTag(['name' => 'keywords', 'content' =>"$keywords"]);
        $this->view->registerMetaTag(['name' => 'content', 'content' =>"$content"]);
        $this->view->registerMetaTag(['name' => 'robots', 'content' =>"$meta"]);
    }
}

