<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bulletcounter}}`.
 */
class m190404_162232_create_bullet_counters_table extends Migration {

    protected
        $tableName,
        $tableModelsClassname,
        $models,
        $tableOptions
    ;

    /**
     * 
     */
    public function init() {
        $this->tableName = '{{%bullet_counters}}';
        $this->tableModelsClassname = '{{%models_classname}}';
        $this->tableOptions = null;

        // Models based on MyActivities modules
        $this->models = [
            [
                // $this->myActivitiesList->addModelSet($this->getWaitingContacts())
                'module' => 'admin',
                'label' => 'UserContact',
                'description' => 'getWaitingContacts()',
                'classname' => 'lispa\amos\admin\models\UserContact'
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getNewsToValidate($enableOrder))
                'module' => 'news',
                'label' => 'News',
                'description' => 'getNewsToValidate($enableOrder)',
                'classname' => 'lispa\amos\news\models\News'
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getRequestToParticipateCommunity())
                'module' => 'community',
                'label' => 'CommunityUserMm',
                'description' => 'getRequestToParticipateCommunity()',
                'classname' => 'lispa\amos\community\models\CommunityUserMm',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getUserProfileToValidate())
                'module' => 'user',
                'label' => 'UserProfile',
                'description' => 'getUserProfileToValidate()',
                'classname' => 'lispa\amos\admin\models\UserProfile',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getComunityToValidate($enableOrder))
                'module' => 'community',
                'label' => 'Community',
                'description' => 'getComunityToValidate($enableOrder)',
                'classname' => 'lispa\amos\community\models\Community',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getDiscussionToValidate($enableOrder))
                'module' => 'discussioni',
                'label' => 'DiscussioniTopic',
                'description' => 'getDiscussionToValidate($enableOrder)',
                'classname' => 'lispa\amos\discussioni\models\DiscussioniTopic',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getDocumentToValidate($enableOrder))
                'module' => 'documenti',
                'label' => 'Documenti',
                'description' => 'getDocumentToValidate($enableOrder)',
                'classname' => 'lispa\amos\documenti\models\Documenti',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getEventsToValidate($enableOrder))
                'module' => 'events',
                'label' => 'Event',
                'description' => 'getEventsToValidate($enableOrder)',
                'classname' => 'lispa\amos\events\models\Event',
            ],
            [
                //$this->myActivitiesList->addModelSet($this->getOrganizationsToValidate($enableOrder))
                'module' => 'organizations',
                'label' => 'Organizations',
                'description' => 'getOrganizationsToValidate($enableOrder)',
                'classname' => 'openinnovation\organizations\models\Organizations',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getShowcaseProjectToValidate($enableOrder))
                'module' => 'showcase',
                'label' => 'ShowcaseProject',
                'description' => 'getShowcaseProjectToValidate($enableOrder)',
                'classname' => 'lispa\amos\showcaseprojects\models\ShowcaseProject',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getResultsToValidate($enableOrder))
                'module' => 'results',
                'label' => 'Result',
                'description' => 'getResultsToValidate($enableOrder)',
                'classname' => 'amos\results\models\Result',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getEenExpressionOfInterestToTakeover($enableOrder))
                'module' => 'een',
                'label' => 'EenExprOfInterest',
                'description' => 'getEenExpressionOfInterestToTakeover($enableOrder)',
                'classname' => 'lispa\amos\een\models\EenExprOfInterest',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getProposalResultsToValidate($enableOrder))
                'module' => 'results',
                'label' => 'ResultProposal',
                'description' => 'getProposalResultsToValidate($enableOrder)',
                'classname' => 'amos\results\models\ResultProposal',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getPartnershipProfilesToValidate($enableOrder))
                'module' => 'partnershipprofiles',
                'label' => 'PartnershipProfiles',
                'description' => 'getPartnershipProfilesToValidate($enableOrder)',
                'classname' => 'lispa\amos\partnershipprofiles\models\PartnershipProfiles',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getUserProfileActivationRequest())
                'module' => 'admin',
                'label' => 'UserProfile',
                'description' => 'getUserProfileActivationRequest()',
                'classname' => 'lispa\amos\admin\models\UserProfile',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getShowcaseProjectUserToAccept($enableOrder))
                'module' => 'showcaseprojects',
                'label' => 'ShowcaseProjectUserMm',
                'description' => 'getShowcaseProjectUserToAccept($enableOrder)',
                'classname' => 'lispa\amos\showcaseprojects\models\ShowcaseProjectUserMm',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getRequestToParticipateCommunityForManager())
                'module' => 'community',
                'label' => 'CommunityUserMm',
                'description' => 'getRequestToParticipateCommunityForManager()',
                'classname' => 'lispa\amos\community\models\CommunityUserMm',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getReportToRead())
                'module' => 'report',
                'label' => 'Report',
                'description' => 'getReportToRead()',
                'classname' => 'lispa\amos\report\models\Report',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getRequestToJoinOrganizzazioniForReferees())
                'module' => 'organizzazioni',
                'label' => 'ProfiloUserMm',
                'description' => 'getRequestToJoinOrganizzazioniForReferees()',
                'classname' => 'lispa\amos\organizzazioni\models\ProfiloUserMm',
            ],
            [
                // $this->myActivitiesList->addModelSet($this->getRequestToJoinOrganizzazioniSediForReferees())
                'module' => 'organizzazioni',
                'label' => 'ProfiloSediUserMm',
                'description' => 'getRequestToJoinOrganizzazioniSediForReferees()',
                'classname' => 'lispa\amos\organizzazioni\models\ProfiloSediUserMm',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        return true;
        
        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->schema->getTableSchema($this->tableName, true) === null) {
            $this->createTable(
                $this->tableName,
                [
                    'id' => $this->primaryKey(),
                    'models_classname_id' => $this->integer(11)->notNull()->defaultValue(null)->comment('Tipologia di contenuto: News, Documento, Discussione da model_classname'),
                    'user_id' => $this->integer(11)->notNull()->defaultValue(null),
                    'counter' => $this->integer(11)->notNull()->defaultValue(null),
                    'created_at' => $this->dateTime(),
                    'updated_at' => $this->dateTime(),
                    'deleted_at' => $this->dateTime()->comment('Cancellato il'),
                    'created_by' => $this->integer(11)->defaultValue(null)->comment('Creato da'),
                    'updated_by' => $this->integer(11)->defaultValue(null)->comment('Aggiornato da'),
                    'deleted_by' => $this->integer(11)->defaultValue(null)->comment('Cancellato da')
                ],
                $this->tableOptions
            );

            $this->addForeignKey(
                'fk_user_idx',
                $this->tableName,
                'user_id',
                '{{%user}}',
                'id'
            );

            $this->addForeignKey(
                'fk_models_classname_idx',
                $this->tableName,
                'models_classname_id',
                '{{%models_classname}}',
                'id'
            );

            /**
             * Counters for:
             * 'module' => 'admin',
             *     'classname' => 'lispa\amos\admin\models\UserContact'
             *     'classname' => 'lispa\amos\admin\models\UserProfile',
             * 
             * 'module' => 'news',
             *      'classname' => 'lispa\amos\news\models\News'
             * 
             * 'module' => 'community',
             *      'classname' => 'lispa\amos\community\models\CommunityUserMm',
             *      'classname' => 'lispa\amos\community\models\Community',
             *      'classname' => 'lispa\amos\community\models\CommunityUserMm',
             * 
             * 'module' => 'user',
             *      'classname' => 'lispa\amos\admin\models\UserProfile',
             * 
             * 'module' => 'discussioni',
             *      'classname' => 'lispa\amos\discussioni\models\DiscussioniTopic',
             * 
             * 'module' => 'documenti',
             *      'classname' => 'lispa\amos\documenti\models\Documenti',
             * 
             * 'module' => 'events',
             *      'classname' => 'lispa\amos\events\models\Event',
             * 
             * 'module' => 'organizations',
             *      'classname' => 'openinnovation\organizations\models\Organizations',
             * 
             * 'module' => 'showcase',
             *      'classname' => 'lispa\amos\showcaseprojects\models\ShowcaseProject',
             * 
             *  'module' => 'results',
             *      'classname' => 'amos\results\models\Result',
             *      'classname' => 'amos\results\models\ResultProposal',
             * 
             *  'module' => 'een',
             *      'classname' => 'lispa\amos\een\models\EenExprOfInterest',
             * 
             *  'module' => 'partnershipprofiles',
             *      'classname' => 'lispa\amos\partnershipprofiles\models\PartnershipProfiles',
             *   
             *  'module' => 'showcaseprojects',
             *      'classname' => 'lispa\amos\showcaseprojects\models\ShowcaseProjectUserMm',
             * 
             *  'module' => 'report',
             *      'classname' => 'lispa\amos\report\models\Report',
             * 
             *  'module' => 'organizzazioni',
             *      'classname' => 'lispa\amos\organizzazioni\models\ProfiloUserMm',
             *      'classname' => 'lispa\amos\organizzazioni\models\ProfiloSediUserMm',
             * 
             */
//            foreach ($this->models as $key => $model) {
//                $this->insert(
//                    $this->tableModelsClassname,
//                    $model
//                );
//            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable($this->tableName);

        /**
         * Counters for:
         * - News
         * - Community
         * - Discussioni
         * - Documenti
         * -
         */
        foreach ($this->models as $key => $model) {
            $this->delete(
                $this->tableModelsClassname,
                $model
            );
        }
    }

}
