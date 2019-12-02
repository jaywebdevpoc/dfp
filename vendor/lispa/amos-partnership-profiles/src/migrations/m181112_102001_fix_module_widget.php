<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\migrations
 * @category   CategoryName
 */

use yii\db\Migration;

class m181112_102001_fix_module_widget extends Migration
{
    public function safeUp()
    {
        $this->update('amos_widgets', ['module' => 'partnershipprofiles'], ['classname' => 'lispa\amos\partnershipprofiles\widgets\icons\WidgetIconPartnershipProfilesDashboardGeneral']);

    }

    public function safeDown()
    {

    }
}