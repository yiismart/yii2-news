<?php

namespace smart\news\models;

use smart\db\ActiveRecord;
use smart\storage\components\StoredInterface;

class News extends ActiveRecord implements StoredInterface
{
    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct(array_replace([
            'active' => true,
        ], $config));
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->modifyDate = gmdate('Y-m-d H:i:s');
        return true;
    }

    /**
     * Parsing html for files in <img> and <a>.
     * @param string $content 
     * @return string[]
     */
    protected function getFilesFromContent($content)
    {
        if (preg_match_all('/(?:src|href)="([^"]+)"/i', $content, $matches)) {
            return $matches[1];
        }

        return [];
    }

    /**
     * @inheritdoc
     * @see smart\storage\components\StoredInterface
     */
    public function getOldFiles()
    {
        $files = $this->getFilesFromContent($this->getOldAttribute('text'));
        if (!empty($file = $this->getOldAttribute('image'))) {
            $files[] = $file;
        }

        return $files;
    }

    /**
     * @inheritdoc
     * @see smart\storage\components\StoredInterface
     */
    public function getFiles()
    {
        $files = $this->getFilesFromContent($this->getAttribute('text'));
        if (!empty($file = $this->getAttribute('image'))) {
            $files[] = $file;
        }

        return $files;
    }

    /**
     * @inheritdoc
     * @see smart\storage\components\StoredInterface
     */
    public function setFiles($files)
    {
        $content = $this->text;
        foreach ($files as $from => $to) {
            $content = str_replace($from, $to, $content);
        }
        $this->text = $content;

        if (array_key_exists($this->image, $files)) {
            $this->image = $files[$this->image];
        }
    }
}
