<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\components;

use lispa\amos\core\components\PartQuestionarioAbstract;
use lispa\amos\projectmanagement\Module;

/**
 * Class CreateProject
 *
 * defines the steps for creation/update of project instances
 * @package lispa\amos\projectmanagement\components
 *
 */
class CreateProject extends PartQuestionarioAbstract
{
    /**
     * constants PART_<part_name>
     * each constant is a step in the progress wizard of project creation form
     */
    const PART_INFO = 'index';
    const PART_ORGANIZATIONS = 'organizations';
    const PART_TAG = 'tag';
    const PART_EXPENSE = 'expense';
    const PART_COMPLETION = 'completion';

    /**
     * @var Projects $project
     */
    public $project;

    /**
     * @inheritdoc
     */
    public function initMap()
    {
        $i = 1;
        self::$map = [
            self::PART_INFO => [
                'label' => Module::t('amosproject_management', 'Information'),
                'index' => $i++,
                'description' => '',
                'status' => $this->getStatus(self::PART_INFO),
                'title' => $this->getTitle(self::PART_INFO),
                'url' => $this->createUrl([self::PART_INFO, 'id' => $this->project->id]),
            ],
            self::PART_ORGANIZATIONS => [
                'label' => Module::t('amosproject_management', 'Organizations'),
                'index' => $i++,
                'description' => '',
                'status' => $this->getStatus(self::PART_ORGANIZATIONS),
                'title' => $this->getTitle(self::PART_ORGANIZATIONS),
                'url' => $this->createUrl([self::PART_ORGANIZATIONS, 'id' => $this->project->id]),
            ],
            self::PART_TAG => [
                'label' => Module::t('amosproject_management', 'Tag'),
                'index' => $i++,
                'description' => '',
                'status' => $this->getStatus(self::PART_TAG),
                'title' => $this->getTitle(self::PART_TAG),
                'url' => $this->createUrl([self::PART_TAG, 'id' => $this->project->id]),
            ],
            self::PART_EXPENSE => [
                'label' => Module::t('amosproject_management', 'Expense Plane'),
                'index' => $i++,
                'description' => '',
                'status' => $this->getStatus(self::PART_EXPENSE),
                'title' => $this->getTitle(self::PART_EXPENSE),
                'url' => $this->createUrl([self::PART_EXPENSE, 'id' => $this->project->id]),
            ],
            self::PART_COMPLETION => [
                'label' => Module::t('amosproject_management', 'Completion'),
                'index' => $i++,
                'description' => '',
                'status' => $this->getStatus(self::PART_COMPLETION),
                'title' => $this->getTitle(self::PART_COMPLETION),
                'url' => $this->createUrl([self::PART_COMPLETION, 'id' => $this->project->id]),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function isCompleted($part)
    {
        switch ($part) {
            case self::PART_INFO:
                return true;
                break;
            case self::PART_ORGANIZATIONS:
                return true;
                break;
            case self::PART_TAG:
                return true;
                break;
            case self::PART_EXPENSE:
                return false;
                break;
            case self::PART_COMPLETION:
                return true;
                break;
        }

        return false;
    }
}
