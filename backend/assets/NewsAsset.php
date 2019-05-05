<?php

namespace smart\news\backend\assets;

use yii\web\AssetBundle;

class NewsAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/news';

    public $js = [
        'news.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
