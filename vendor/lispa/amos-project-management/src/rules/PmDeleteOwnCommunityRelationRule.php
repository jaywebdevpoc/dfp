<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community\rules
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\rules;

use lispa\amos\core\rules\DefaultOwnContentRule;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;

/**
 * Class DeleteOwnCommunitiesRule
 * @package lispa\amos\community\rules
 */
class PmDeleteOwnCommunityRelationRule extends DefaultOwnContentRule
{
    public $name = 'pmDeleteOwnCommunityRelation';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if(!empty(\Yii::$app->getModule('project_management'))) {
            if (isset($params['model'])) {
                /** @var Record $model */
                $model = $params['model'];
                if (!$model->id) {
                    $post = \Yii::$app->getRequest()->post();
                    $get = \Yii::$app->getRequest()->get();
                    if (isset($get['id'])) {
                        $model = $this->instanceModel($model, $get['id']);
                    } elseif (isset($post['id'])) {
                        $model = $this->instanceModel($model, $post['id']);
                    }
                }
                return (!ProjectManagementUtility::isReferentWpOrActivity($model->id));
            }
            return false;
        }
        return true;
    }
}
