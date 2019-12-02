<?php

namespace lispa\amos\audit\panels;

use lispa\amos\audit\components\panels\DataStoragePanelTrait;

use Yii;

/**
 * ConfigPanel
 * @package lispa\amos\audit\panels
 */
class ConfigPanel extends \yii\debug\panels\ConfigPanel
{
    use DataStoragePanelTrait;

    /**
     * @return string
     */
    public function getDetail()
    {
        return Yii::$app->view->render('@yii/debug/views/default/panels/config/detail', [
            'panel' => $this,
        ]);
    }

}