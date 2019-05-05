<?php

namespace smart\news\backend\forms;

use Yii;
use smart\base\Form;
use smart\news\backend\models\News;

class NewsForm extends Form
{
    /**
     * @var boolean
     */
    public $active = 1;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $date;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $text;

    /**
     * @var integer
     */
    private $_id;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active' => Yii::t('news', 'Active'),
            'title' => Yii::t('news', 'Title'),
            'url' => Yii::t('news', 'Friendly URL'),
            'date' => Yii::t('news', 'Date'),
            'image' => Yii::t('news', 'Image'),
            'description' => Yii::t('news', 'Description'),
            'text' => Yii::t('news', 'Text'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['active', 'boolean'],
            ['title', 'string', 'max' => 100],
            [['url', 'image'], 'string', 'max' => 200],
            ['url', 'match', 'pattern' => '/^[a-z0-9\-_]*$/'],
            ['url', 'unique', 'targetClass' => News::className(), 'when' => function ($model, $attribute) {
                $object = News::findOne($this->_id);
                return $object === null || $object->url != $this->url;
            }],

            ['date', 'date', 'format' => 'yyyy-MM-dd'],
            [['text', 'description'], 'string'],
            [['title', 'url'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function assignFrom($object)
    {
        $this->active = self::fromBoolean($object->active);
        $this->title = self::fromString($object->title);
        $this->url = self::fromString($object->url);
        $this->date = self::fromDate($object->date);
        $this->image = self::fromString($object->image);
        $this->description = self::fromString($object->description);
        $this->text = self::fromHtml($object->text);

        $this->_id = $object->id;

        Yii::$app->storage->cacheObject($object);
    }

    /**
     * @inheritdoc
     */
    public function assignTo($object)
    {
        $object->active = self::toBoolean($this->active);
        $object->title = self::toString($this->title);
        $object->url = self::toString($this->url);
        $object->date = self::toDate($this->date);
        $object->image = self::toString($this->image);
        $object->description = self::toString($this->description);
        $object->text = self::toHtml($this->text);

        $object->modifyDate = gmdate('Y-m-d H:i:s');

        Yii::$app->storage->storeObject($object);
    }
}
