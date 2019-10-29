<?php

namespace smart\news\backend\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use dkhlystov\helpers\Translit;
use smart\base\BackendController;
use smart\imperavi\ImperaviControllerTrait;
use smart\news\backend\filters\NewsFilter;
use smart\news\backend\forms\NewsForm;
use smart\news\backend\models\News;

class NewsController extends BackendController
{
    use ImperaviControllerTrait;

    /**
     * List
     * @return string
     */
    public function actionIndex()
    {
        $model = new NewsFilter;
        $model->load(Yii::$app->getRequest()->get());

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Create
     * @return string
     */
    public function actionCreate()
    {
        $object = new News;
        $model = new NewsForm;

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $model->assignTo($object);
            if ($object->save()) {
                Yii::$app->session->setFlash('success', Yii::t('cms', 'Changes saved successfully.'));
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Update
     * @param string $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $object = News::findOne($id);
        if ($object === null) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        $model = new NewsForm;
        $model->assignFrom($object);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $model->assignTo($object);
            if ($object->save()) {
                Yii::$app->session->setFlash('success', Yii::t('cms', 'Changes saved successfully.'));
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'object' => $object,
        ]);
    }

    /**
     * Delete
     * @param string $id
     * @return string
     */
    public function actionDelete($id)
    {
        $object = News::findOne($id);
        if ($object === null) {
            throw new BadRequestHttpException(Yii::t('cms', 'Item not found.'));
        }

        if ($object->delete()) {
            Yii::$app->storage->removeObject($object);
            Yii::$app->session->setFlash('success', Yii::t('cms', 'Item deleted successfully.'));
        }

        return $this->redirect(['index']);
    }
}
