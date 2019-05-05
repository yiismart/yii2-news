<?php

namespace smart\news\backend;

use Yii;
use yii\helpers\Html;
use smart\base\BackendModule;

class Module extends BackendModule
{
    /**
     * @inheritdoc
     */
    protected static function security()
    {
        $auth = Yii::$app->getAuthManager();
        if ($auth->getRole('News') === null) {
            $role = $auth->createRole('News');
            $auth->add($role);
        }
    }

    /**
     * @inheritdoc
     */
    public function menu(&$items)
    {
        if (!Yii::$app->getUser()->can('News')) {
            return;
        }

        $items['news'] = [
            'label' => '<i class="far fa-newspaper"></i> ' . Html::encode(Yii::t('news', 'News')),
            'url' => ['/news/news/index'],
            'encode' => false,
        ];
    }
}
