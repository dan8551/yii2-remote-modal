<?php

namespace dan8551\components\modal;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class RemoteModal extends \yii\bootstrap4\Modal
{
    const TYPE_DEFAULT = 'default';

    const SIZE_LARGE = 'lg';
    const SIZE_MEDIUM = 'md';

    public function run()
    {
	parent::run();
	$this->registerAssets();
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        RemoteModalAsset::register($view);
 	$uuid = uniqid();

    	$js = "rm_$uuid = new RemoteModal('#$this->id');\n";
    	$js .= "$(document).on('click', '[role=\"$this->id\"]', function (event){ \n ";
        $js .= "event.preventDefault(); \n";
        $js.= "rm_$uuid.open(this, null);\n";
    	$js .="});\n";
	$view->registerJs($js,\yii\web\View::POS_READY);
    }
}
