<?php

namespace smart\news\backend\filters;

use Yii;
use yii\data\ActiveDataProvider;
use smart\base\FilterInterface;
use smart\news\backend\models\News;

class NewsFilter extends News implements FilterInterface
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('news', 'Title'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getDataProvider($config = [])
    {
        $query = self::find();
        $query->andFilterWhere(['like', 'title', $this->title]);

        $config['query'] = $query;

        $config['sort'] = [
            'attributes' => [
                'date' => [
                    'asc' => ['date' => SORT_ASC, 'time' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC, 'time' => SORT_DESC],
                ],
                'title',
                'modifyDate',
            ],
            'defaultOrder' => ['modifyDate' => SORT_DESC],
        ];
        return new ActiveDataProvider($config);
    }
}
