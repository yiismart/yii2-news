<?php

use yii\helpers\Html;

// Title
$title = $object->title;
$this->title = $title . ' | ' . Yii::$app->name;

// Breadcrumbs
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('news', 'News'), 'url' => ['index']],
    $title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
    'model' => $model,
]) ?>
