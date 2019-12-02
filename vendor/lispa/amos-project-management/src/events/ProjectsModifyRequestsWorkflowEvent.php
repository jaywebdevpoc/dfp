<?php

namespace lispa\amos\projectmanagement\events;

use lispa\amos\core\user\User;
use lispa\amos\core\utilities\Email;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use raoul2000\workflow\events\WorkflowEvent;
use Yii;

/**
 * Class ProjectsModifyRequestsWorkflowEvent
 * @package lispa\amos\projectmanagement\events
 */
class ProjectsModifyRequestsWorkflowEvent
{
    /**
     * @param WorkflowEvent $event
     */
    public function afterEnterStatusToValidate(WorkflowEvent $event)
    {
        try {
            /** @var ProjectsModifyRequest $modifyRequest */
            $modifyRequest = $event->data;
            /** @var Projects $project */
            $project = $modifyRequest->projects;

            $userIds = [];
            /** @var User $manager */
            foreach ($project->community->communityManagers as $manager) {
                $userIds[] = $manager->id;
            }
            $userIds  = array_unique ($userIds);
            $link = \Yii::$app->urlManager->createAbsoluteUrl(['/project_management/projects-modify-request/update', 'id' => $modifyRequest->id]);
            $subject = "Modification request for the project plan '{projectTitle}'";
            $text = '{nameSurnameRequestCreator} ha inviato una richiesta di modifica del piano di progetto con questo testo:<BR><i>{requestContent}</i>';
            $text .= "<a href='$link'>Apri la richiesta di modifica</a>";

            $this->sendMail($modifyRequest, $userIds, $subject, $text);
        } catch (\Exception $e) {
            Yii::$app->getSession()->addFlash('danger', $e->getMessage());
        }
    }

    /**
     * @param WorkflowEvent $event
     */
    public function afterEnterStatusValidated(WorkflowEvent $event)
    {
        try {
            /** @var ProjectsModifyRequest $modifyRequest */
            $modifyRequest = $event->data;
            /** @var Projects $project */
            $project = $modifyRequest->projects;

            if ($project->status == Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED) {
                $project->sendToStatus(Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT);
                $project->save(false);
            }

            $userIds = [];
            $userIds[] = $modifyRequest->created_by;
            $userIds  = array_unique ($userIds);


            $subject = 'The request to modify the project plan has been accepted';
            $text = 'Your request to modify the project plan {projectTitle} has been accepted. <br> The change is in progress; you will be warned when it will be finished';

            $this->sendMail($modifyRequest, $userIds, $subject, $text);
        } catch (\Exception $e) {
            Yii::$app->getSession()->addFlash('danger', $e->getMessage());
        }
    }

    /**
     * @param WorkflowEvent $event
     */
    public function afterEnterStatusRejected(WorkflowEvent $event)
    {
//        Email...
//        Oggetto: E’ stata respinta la richiesta di modifica del piano di progetto
//        Testo: La tua richiesta di modifica del piano del progetto <Titolo del progetto> è stata respinta

        try {
            /** @var ProjectsModifyRequest $modifyRequest */
            $modifyRequest = $event->data;

            $userIds = [];
            $userIds[] = $modifyRequest->created_by;

            $subject = 'The request to modify the project plan was rejected';
            $text = 'Your request to modify the project plan {projectTitle} was rejected';

            $this->sendMail($modifyRequest, $userIds, $subject, $text);
        } catch (\Exception $e) {
            Yii::$app->getSession()->addFlash('danger', $e->getMessage());
        }
    }

    /**
     * @param ProjectsModifyRequest $requestModel
     * @param $userIds
     * @param null $from
     * @return void
     */
    private function sendMail(ProjectsModifyRequest $requestModel, $userIds, $subject, $text, $from = null)
    {
        $projectModel = $requestModel->projects;

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
            'title' => $subject,
            'model' => $projectModel,
            'request' => $requestModel,
        ]);

        $ret = Email::sendMail(
            $from,
            $tos,
            $subjectRendered,
            $textRendered,
            [], [], [], 0, false);
    }
}
