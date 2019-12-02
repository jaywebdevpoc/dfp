<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\forms
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\forms;

use lispa\amos\core\record\Record;
use lispa\amos\core\utilities\CurrentUser;
use lispa\amos\core\views\common\Buttons;

/**
 * Class PMButtons
 * @package lispa\amos\projectmanagement\forms
 */
class PMButtons extends Buttons
{
    /**
     * @param Record $model
     * @param string $action
     * @return bool
     */
    protected function can($model, $action)
    {
        $modelClassName = $this->get_real_class($model);
        $permissionName = strtoupper($modelClassName . '_' . $action);
        return CurrentUser::getUser()->can($permissionName, ['model' => $model]);
    }
}
