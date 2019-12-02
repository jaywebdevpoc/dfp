<?php

namespace lispa\amos\audit\components;

use lispa\amos\audit\Audit;


/**
 * Class Migration
 * @package lispa\amos\audit\components
 */
class Migration extends \yii\db\Migration
{

    /**
     *
     */
    public function init()
    {
        /** @var Audit $audit */
        $audit = \Yii::$app->getModule('audit');
        if ($audit) {
            $this->db = $audit->db;
        }
        parent::init();
    }

}