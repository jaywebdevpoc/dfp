<?php

namespace lispa\amos\projectmanagement\events;

use lispa\amos\core\user\User;
use lispa\amos\core\utilities\Email;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsProgressStatements;
use raoul2000\workflow\events\WorkflowEvent;
use Yii;

/**
 * Class ProjectsProgressStatementsWorkflowEvent
 * @package lispa\amos\projectmanagement\events
 */
class ProjectsProgressStatementsWorkflowEvent
{
    /**
     * @param WorkflowEvent $event
     */
    public function afterChangeStatusFromConfirmedToOnEdit(WorkflowEvent $event)
    {
        /** @var ProjectsProgressStatements $progressStatement */
        $progressStatement = $event->data;

//        Oggetto: Richiesta di rettifica di dichiarazione avanzamento attività
//        Testo: Il Project manager richiede che venga corretta la dichiarazione di avanzamento per l’attività <titolo attività>

        $users[] = $progressStatement->projectsTask->getUserResponsibleId();
        $users[] = $progressStatement->projectsTask->projectsActivities->getUserResponsibleId();
        $users  = array_unique ($users);

        // At the activity responsible and cc WP responsible
        $subject = 'Request for activity declaration correction';
        $text = 'The Project manager requires that the progress statement for the activity be corrected: <br> {activityTitle}';

        $this->sendMail($progressStatement, $users, $subject, $text);
    }

    /**
     * @param WorkflowEvent $event
     */
    public function afterChangeStatusFromOnEditToConfirmed(WorkflowEvent $event)
    {
        /** @var ProjectsProgressStatements $progressStatement */
        $progressStatement = $event->data;

        $progressStatement->user_responsible_id = $progressStatement->projectsTask->getUserResponsibleId();
        $progressStatement->organization_id = $progressStatement->projectsTask->organization->id;
        $progressStatement->last_confirmed_time = date("Y-m-d H:i:s");
        $progressStatement->save(false);

//        Oggetto: Conferma dichiarazione avanzamento attività
//        Testo: <Nome cognome utente che ha confermato> ha confermato la dichiarazione di avanzamento per l’attività <titolo attività>

        /** @var Projects $project */
        $project = $progressStatement->projectsTask->project;
        $users  = array_unique ($project->getProjectManagerIds());

        // At the activity responsible and cc WP responsible
        $subject = 'Confirm activity progress statement';
        $text = '#email_confirm_progess_declaration';

        $this->sendMail($progressStatement, $users, $subject, $text);
    }

    /**
     * @param ProjectsProgressStatements $progressStatement
     * @param $userIds
     * @param null $from
     * @return void
     */
    private function sendMail(ProjectsProgressStatements $progressStatement, $userIds, $subject, $text, $from = null)
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
            'model' => $progressStatement,
            'text' => $subject,
        ]);

        try {
            $confirmedUserId = $progressStatement->getStatusLastUpdateUser(ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED);
            $confirmedUser = User::findOne($confirmedUserId);
            $confirmedUser = $confirmedUser->userProfile->getNomeCognome();
        } catch (\Exception $e) {
            $confirmedUser = '';
        }

        $textRendered = Yii::$app->controller->renderMailPartial('email' . DIRECTORY_SEPARATOR . 'content', [
            'model' => $progressStatement,
            'text' => $text,
            'confirmedUser' => $confirmedUser,
        ]);

        $ret = Email::sendMail(
            $from,
            $tos,
            $subjectRendered,
            $textRendered,
            [], [], [], 0, false);
    }
}
