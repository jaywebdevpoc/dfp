<?php

/**
 * @package yii2-widgets
 * @subpackage yii2-widget-fileinput
 * @version 1.0.8
 */

namespace kartik\file;

/**
 * DomPurify asset bundle for FileInput Widget
 *
 * @since 1.0
 */
class DomPurifyAsset extends BaseAsset
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setupAssets('js', ['js/plugins/purify']);
        parent::init();
    }
}