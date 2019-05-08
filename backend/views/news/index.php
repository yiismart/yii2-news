<?php

use yii\helpers\Html;
use smart\grid\GridView;

// Title
$title = Yii::t('news', 'News');
$this->title = $title . ' | ' . Yii::$app->name;

// Breadcrumbs
$this->params['breadcrumbs'] = [
    $title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<p class="form-buttons">
    <?= Html::a(Yii::t('cms', 'Add'), ['create'], ['class' => 'btn btn-primary']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $model->getDataProvider(),
    'filterModel' => $model,
    'rowOptions' => function ($model, $key, $index, $grid) {
        return !$model->active ? ['class' => 'table-inactive'] : [];
    },
    'columns' => [
        [
            'attribute' => 'date',
            'format' => 'html',
            'value' => function ($model, $key, $index, $column) {
                return Html::tag('div', $model->date);
            },
        ],
        [
            'attribute' => 'title',
            'format' => 'html',
            'value' => function ($model, $key, $index, $column) {
                $image = '';
                if (!empty($model->image)) {
                    $options = ['class' => 'list-icon'];
                    Html::addCssStyle($options, 'background-image: url(' . $model->image . ');');
                    $image = Html::tag('div', '', $options);
                }

                $title = Html::tag('div', Html::encode($model->title));
                $url = Html::tag('span', Html::encode($model->url), ['class' => 'badge badge-primary']);
                $caption = Html::tag('div', $title . $url);

                return $image . $caption;
            },
        ],
        [
            'class' => 'smart\grid\ActionColumn',
        ],
    ],
]) ?>
