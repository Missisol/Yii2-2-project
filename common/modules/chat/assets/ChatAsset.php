<?php

namespace common\modules\chat\assets;

use yii\web\AssetBundle;

/**
 * Class ChatAsset
 * @package common\modules\chat\assets
 */
class ChatAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/chat.css',
    ];
    public $js = [
    ];
    public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapAsset',
    ];
}
