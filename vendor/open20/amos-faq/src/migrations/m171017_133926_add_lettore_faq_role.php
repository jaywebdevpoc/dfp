<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq\migrations
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use open20\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

/**
 * Class m171017_133926_add_lettore_faq_role
 */
class m171017_133926_add_lettore_faq_role extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'LETTORE_FAQ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Ruolo di lettore delle FAQ',
                'parent' => ['AMMINISTRATORE_FAQ', 'BASIC_USER'],
                'children' => [
                    \open20\amos\faq\widgets\icons\WidgetIconFaqDashboard::className(),
                    \open20\amos\faq\widgets\icons\WidgetIconFaq::className(),
                    'FAQ_READ',
                    'FAQCATEGORIES_READ',
                    'FAQSTATO_READ'
                ]
            ]
        ];
    }
}
