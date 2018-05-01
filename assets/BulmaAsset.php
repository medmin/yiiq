<?php

namespace app\assets;

use yii\web\AssetBundle;

class BulmaAsset extends AssetBundle
{
    public $sourcePath = '@bower/bulma';

    public $css = [
        'css/bulma.min.css'
    ];

    public $depends = [
        'yii\web\YiiAsset'
    ];
}