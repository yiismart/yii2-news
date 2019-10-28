<?php

namespace smart\news\backend\forms;

use Yii;
use smart\base\Form;
use smart\news\backend\models\News;

class NewsForm extends Form
{
    const FORMAT_DATE = 'yyyy-MM-dd';
    const FORMAT_TIME = 'HH:mm';

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
    public $alias;

    /**
     * @var string
     */
    public $date;

    /**
     * @var string
     */
    public $time;

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
    protected $usingStorage = true;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'active' => Yii::t('news', 'Active'),
            'title' => Yii::t('news', 'Title'),
            'alias' => Yii::t('news', 'Friendly URL'),
            'date' => Yii::t('news', 'Date'),
            'time' => Yii::t('news', 'Time'),
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
            [['alias', 'image'], 'string', 'max' => 200],
            ['alias', 'match', 'pattern' => '/^[a-z0-9\-_]*$/'],
            ['alias', 'unique', 'targetClass' => News::className(), 'when' => function ($model, $attribute) {
                $object = News::findOne($this->_id);
                return $object === null || $object->alias != $this->alias;
            }],
            ['date', 'date', 'format' => self::FORMAT_DATE],
            ['time', 'time', 'format' => self::FORMAT_TIME],
            [['text', 'description'], 'string'],
            [['title', 'alias', 'date'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function map()
    {
        return [
            ['active', 'boolean'],
            [['title', 'alias', 'image', 'description'], 'string'],
            ['date', 'date'],
            ['time', 'time'],
            ['text', 'html'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function assignFrom($object, $attributeNames = null)
    {
        parent::assignFrom($object, $attributeNames);
        $this->_id = $object->id;
    }

    /**
     * @inheritdoc
     */
    public function assignTo($object, $attributeNames = null)
    {
        parent::assignTo($object, $attributeNames);
        $object->modifyDate = gmdate('Y-m-d H:i:s');
    }
}
