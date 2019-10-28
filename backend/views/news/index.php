<?php

use yii\helpers\Html;
use smart\grid\GridView;
use smart\news\backend\forms\NewsForm;

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
                $formatter = Yii::$app->getFormatter();

                $value = Html::tag('div', $formatter->asDate($model->date, NewsForm::FORMAT_DATE));
                if (!empty($model->time)) {
                    $value .= Html::tag('div', $formatter->asTime($model->time, NewsForm::FORMAT_TIME), ['class' => 'text-muted']);
                }

                return $value;
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
                $alias = Html::tag('span', Html::encode($model->alias), ['class' => 'badge badge-secondary']);
                $caption = Html::tag('div', $title . $alias);

                return $image . $caption;
            },
        ],
        [
            'class' => 'smart\grid\ActionColumn',
        ],
    ],
]) ?>
