<?php

namespace dan8551\components\modal;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use Yii;

class RemoteModal extends \yii\bootstrap4\Modal
{
    const TYPE_DEFAULT = 'default';

    const SIZE_LARGE = 'lg';
    const SIZE_MEDIUM = 'md';
    
    public $remoteUrl;
    
    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $this->options = array_merge([
            'class' => 'fade',
            'role' => 'dialog',
            'tabindex' => -1,
            'aria-hidden' => 'true'
        ], $this->options);
        Html::addCssClass($this->options, ['widget' => 'modal']);

        if ($this->clientOptions !== false) {
            $this->clientOptions = array_merge(['show' => false], $this->clientOptions);
        }

        $this->titleOptions = array_merge([
            'id' => $this->options['id'] . '-label'
        ], $this->titleOptions);
        if (!isset($this->options['aria-label'], $this->options['aria-labelledby']) && $this->title !== null) {
            $this->options['aria-labelledby'] = $this->titleOptions['id'];
        }

        if ($this->closeButton !== false) {
            $this->closeButton = array_merge([
                'data-dismiss' => 'modal',
                'class' => 'close',
                'type' => 'button',
            ], $this->closeButton);
        }
        
        if ($this->toggleButton !== false) {
            $this->toggleButton = array_merge([
                'data-toggle' => 'modal',
                'type' => 'button'
            ], $this->toggleButton);
            if (!isset($this->toggleButton['data-target']) && !isset($this->toggleButton['href'])) {
                $this->toggleButton['data-target'] = '#' . $this->options['id'];
            }
        }
        $this->toggleButton['data-url'] = Url::to($this->remoteUrl);
        $this->toggleButton['role'] = $this->id;
        
        $this->dialogOptions = array_merge([
            'role' => 'document'
        ], $this->dialogOptions);
        Html::addCssClass($this->dialogOptions, ['widget' => 'modal-dialog']);
        if ($this->size) {
            Html::addCssClass($this->dialogOptions, ['size' => $this->size]);
        }
        if ($this->centerVertical) {
            Html::addCssClass($this->dialogOptions, ['align' => 'modal-dialog-centered']);
        }
        if ($this->scrollable) {
            Html::addCssClass($this->dialogOptions, ['scroll' => 'modal-dialog-scrollable']);
        }
    }

    /**
     * Overrides the parent function to load remote view into modal via Ajax.
     */
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
        $js = <<<JS
                rm_{$uuid} = new RemoteModal('#{$this->id}');\n
                $(document).on('click', '[role="{$this->id}"]', function(event){
                    event.preventDefault();
                    rm_{$uuid}.open(this,null);
                });
        JS;
        $view->registerJs($js,View::POS_READY);
    }
}
