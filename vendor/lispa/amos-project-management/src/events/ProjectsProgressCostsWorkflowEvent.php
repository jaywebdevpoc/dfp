<?php

namespace lispa\amos\projectmanagement\events;

use lispa\amos\core\user\User;
use lispa\amos\core\utilities\Email;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsProgressCosts;
use raoul2000\workflow\events\WorkflowEvent;
use Yii;

/**
 * Class ProjectsProgressCostsWorkflowEvent
 * @package lispa\amos\projectmanagement\events
 */
class ProjectsProgressCostsWorkflowEvent
{
    /**
     * @param WorkflowEvent $event
     */
    public function afterChangeStatusFromConfirmedToOnEdit(WorkflowEvent $event)
    {
        /** @var ProjectsProgressCosts $progressCost */
        $progressCost = $event->data;

//        Oggetto: Richiesta di rettifica di dichiarazione avanzamento attività
//        Testo: Il Project manager richiede che venga corretta la dichiarazione di avanzamento per l’attività <titolo attività>

        $users[] = $progressCost->projectsTask->getUserResponsibleId();
        $users[] = $progressCost->projectsTask->projectsActivities->getUserResponsibleId();
        $users  = array_unique ($users);

        // At the activity responsible and cc WP responsible
        $subject = 'Request for activity declaration correction';
        $text = 'The Project manager requires that the progress cost for the activity be corrected: <br> {activityTitle}';

        $this->sendMail($progressCost, $users, $subject, $text);
    }

    /**
     * @param WorkflowEvent $event
     */
    public function afterChangeStatusFromOnEditToConfirmed(WorkflowEvent $event)
    {
        /** @var ProjectsProgressCosts $progressCost */
        $progressCost = $event->data;

        $progressCost->user_responsible_id = $progressCost->projectsTask->getUserResponsibleId();
        $progressCost->organization_id = $progressCost->projectsTask->organization->id;
        $progressCost->last_confirmed_time = date("Y-m-d H:i:s");
        $progressCost->save(false);

//        Oggetto: Conferma dichiarazione avanzamento attività
//        Testo: <Nome cognome utente che ha confermato> ha confermato la dichiarazione di avanzamento per l’attività <titolo attività>

        /** @var Projects $project */
        $project = $progressCost->projectsTask->project;
        $users  = array_unique ($project->getProjectManagerIds());

        // At the activity responsible and cc WP responsible
        $subject = 'Confirm activity progress cost';
        $text = '#email_confirm_cost_declaration';

        $this->sendMail($progressCost, $users, $subject, $text);
    }

    /**
     * @param ProjectsProgressCosts $progressCost
     * @param $userIds
     * @param null $from
     * @return void
     */
    private function sendMail(ProjectsProgressCosts $progressCost, $userIds, $subject, $text, $from = null)
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
            'model' => $progressCost,
            'text' => $subject,
        ]);

        try {
            $confirmedUserId = $progressCost->getStatusLastUpdateUser(ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED);
            $confirmedUser = User::findOne($confirmedUserId);
            $confirmedUser = $confirmedUser->userProfile->getNomeCognome();
        } catch (\Exception $e) {
            $confirmedUser = '';
        }

        $textRendered = Yii::$app->controller->renderMailPartial('email' . DIRECTORY_SEPARATOR . 'content', [
            'model' => $progressCost,
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
