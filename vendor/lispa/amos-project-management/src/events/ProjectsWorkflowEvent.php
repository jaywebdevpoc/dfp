<?php

namespace lispa\amos\projectmanagement\events;

use lispa\amos\core\user\User;
use lispa\amos\core\utilities\Email;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use raoul2000\workflow\events\WorkflowEvent;
use Yii;

/**
 * Class ProjectsWorkflowEvent
 * @package lispa\amos\projectmanagement\events
 */
class ProjectsWorkflowEvent
{
    /**
     * @param WorkflowEvent $event
     */
    public function afterChangeStatusFromStartupToValidated(WorkflowEvent $event)
    {
        try {
            /** @var Projects $project */
            $project = $event->data;

            $users = $project->community->communityUsers;
            $userIds = [];
            foreach ($users as $u) {
                $userIds[] = $u->id;
            }

            $subject = 'Release of the project plan {projectTitle}';
            $text = 'The project plan has been released. If you want to review the changes, {projectLink}';

            $userIds  = array_unique ($userIds);
            $this->sendMail($project, $userIds, $subject, $text);
        } catch (\Exception $e) {
            Yii::$app->getSession()->addFlash('danger', $e->getMessage());
        }
    }

    /**
     * @param WorkflowEvent $event
     */
    public function afterChangeStatusFromOnModifyToValidated(WorkflowEvent $event)
    {
        try {
            /** @var Projects $project */
            $project = $event->data;

            // All approved request of modify are to close
            /** @var ProjectsModifyRequest $projectModify */
            foreach ($project->projectsModifyRequestMms as $projectModify) {
                if ($projectModify->status == ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED) {
                    $projectModify->sendToStatus(ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_CLOSED);
                    $projectModify->save(false);
                }
            }

            /** @var Projects $project */
            $project = $event->data;

            $users = $project->community->communityUsers;
            $userIds = [];
            foreach ($users as $u) {
                $userIds[] = $u->id;
            }
            $userIds  = array_unique ($userIds);


            $subject = 'Project plan update {projectTitle}';
            $text = 'The project plan has been updated. To view the changes, {projectLink}';

            $this->sendMail($project, $userIds, $subject, $text);
        } catch (\Exception $e) {
            Yii::$app->getSession()->addFlash('danger', $e->getMessage());
        }
    }

    /**
     * @param Projects $projectModel
     * @param $userIds
     * @param null $from
     * @return void
     */
    private function sendMail(Projects $projectModel, $userIds, $subject, $text, $from = null)
    {
        if (is_null($from)) {
            $from = \Yii::$app->params['email-assistenza'];
        }

        $tos = [];
        foreach ($userIds as $id) {
            $toEmail = User::findOne($id)->email;
            $tos[] = $toEmail;
        }

        $subjectRendered = Yii::$app->controller->renderMailPartial('email' . DIRECTORY_SEPARATOR . 'content_subject', [
            'text' => $subject,
            'model' => $projectModel,
        ]);

        $textRendered = Yii::$app->controller->renderMailPartial('email' . DIRECTORY_SEPARATOR . 'content', [
            'text' => $text,
            'model' => $projectModel,
        ]);

        $ret = Email::sendMail(
            $from,
            $tos,
            $subjectRendered,
            $textRendered,
            [], [], [], 0, false);
    }
}
