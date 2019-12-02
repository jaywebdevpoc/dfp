<?php
namespace lispa\amos\projectmanagement\events;

use lispa\amos\projectmanagement\models\new_project_wizard\StepB;
use lispa\amos\projectmanagement\models\new_project_wizard\StepC;
use lispa\amos\projectmanagement\models\new_project_wizard\StepD;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use raoul2000\workflow\events\WorkflowEvent;

class NewProjectWizardEvents
{

    /**
     * @param WorkflowEvent $event
     */
    public function checkStepA(WorkflowEvent $event)
    {
        $event->isValid = false;
        if (isset($event->data['select'])) {
            $communityId = $event->data['select'];
            // OPEN if you are CM and you wont to go StepB
            if (ProjectManagementUtility::loggedUsedIsCommunityManager($communityId) && ($event->getEndStatus()->getId() == StepB::WIZFLOW)){
                $event->isValid = true;
                return;
            } else {
                if ($event->getEndStatus()->getId() == StepC::WIZFLOW){
                    $event->isValid = true;
                    return;
                }
            }
        }
        if ($event->getEndStatus()->getId() == StepC::WIZFLOW){
            $event->isValid = true;
        }
    }

    /**
     * @param WorkflowEvent $event
     */
    public function checkStepB(WorkflowEvent $event)
    {
        $event->isValid = false;
        if (isset($event->data['allCommunityUsersInProject'])) {
            $answer = $event->data['allCommunityUsersInProject'];
            // OPEN if you are CM and you wont to go StepB
            if (($answer == 0) && ($event->getEndStatus()->getId() == StepD::WIZFLOW)){
                $event->isValid = true;
            }

            if (($answer == 1) && ($event->getEndStatus()->getId() == StepC::WIZFLOW)){
                $event->isValid = true;
            }
        }
    }
}