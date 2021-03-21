<?php

namespace dan8551\components\modal;

use Yii;
use yii\web\AssetBundle;

class RemoteModalAsset extends AssetBundle
{
     public $sourcePath = '@vendor/dan8551/yii2-remote-modal/assets';

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
   
   public $css = [
	'css/remote-modal.css'
   ];
    
    public $js = [
        'js/hasAttr.js',    
	'js/remote-modal.js'
    ];


}
