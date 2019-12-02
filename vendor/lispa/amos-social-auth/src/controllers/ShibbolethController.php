<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\socialauth
 * @category   CategoryName
 */

namespace lispa\amos\socialauth\controllers;

use lispa\amos\admin\models\UserProfile;
use lispa\amos\core\controllers\BackendController;
use lispa\amos\core\user\User;
use lispa\amos\socialauth\models\SocialIdmUser;
use lispa\amos\socialauth\Module;
use lispa\amos\socialauth\utility\SocialAuthUtility;
use http\Exception\RuntimeException;
use yii\filters\AccessControl;
use Yii;

/**
 * Class ShibbolethController
 * @package lispa\amos\socialauth\controllers
 */
class ShibbolethController extends BackendController
{
    /**
     * @var string $layout
     */
    public $layout = 'login';

    /**
     * @var string $authType
     */
    protected $authType = '';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'endpoint',
                            'mobile',
                            'sign-up',
                        ],
                        //'roles' => ['*']
                    ]
                ],
            ],
        ];
    }

    /**
     *
     * @param Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {

        parent::init();
        $this->setUpLayout('login');
        // custom initialization code goes here
    }

    /**
     * Endpoint bridge with shibbolethsp authentication
     * @param bool $confirm
     * @return bool|\yii\web\Response
     */
    public function actionEndpoint($confirm = false)
    {
        //Link to current user with IDM
        return $this->tryIdmLink($confirm);
    }

    public function actionMobile()
    {
        $result = $this->tryIdmLink(false, true, false);

        if(is_array($result) && isset($result['status'])) {
            $user = \lispa\amos\mobile\bridge\modules\v1\models\User::findOne(Yii::$app->user->id);
            $user->refreshAccessToken('', '');

            return $this->redirect(['/socialauth/social-auth/land', 'token' => $user->getAccessToken()]);
        } else {
            return $this->redirect(['/socialauth/social-auth/land', 'error' => true]);
        }
    }

    /**
     * @param string $type
     * @param array $dataFetch
     * @return string|\yii\web\Response
     */
    public function tryIdmLink($confirmLink = false, $render = true, $redirect = true)
    {
        $procedure = $this->procedure($confirmLink, $render);

        if (!is_array($procedure)) {
            return $procedure;
        }

        if($redirect) {
            switch ($procedure['status']) {
                case 'success':
                case 'fc':
                case 'ND':
                case 'override':
                case 'conf':
                    {
                        return $this->redirect(['/', 'done' => $procedure['status']]);
                    };
                    break;
            }
        } else {
            return $procedure;
        }
    }

    protected function procedure($confirmLink = false, $render = true)
    {
        //Store data into session
        $userDatas = $this->storeDataInSession();

        //Find for existing relation
        $relation = SocialIdmUser::findOne(['numeroMatricola' => $userDatas['matricola']]);

        //Find by other attributes
        $usersByCF = UserProfile::find()->andWhere(['codice_fiscale' => $userDatas['codiceFiscale']])->all();
        $countUsersByCF = count($usersByCF);
        /** @var UserProfile|null $existsByFC */
        $existsByFC = (($countUsersByCF == 1) ? reset($usersByCF) : null);
        $existsByEmail = User::findOne(['email' => $userDatas['emailAddress']]);

        /** @var Module $socialAuthModule */
        $socialAuthModule = Module::instance();

        //Get timeout for app login
        $loginTimeout = \Yii::$app->params['loginTimeout'] ?: 3600;

        if ($socialAuthModule->enableSpidMultiUsersSameCF && ($countUsersByCF > 1) && \Yii::$app->user->isGuest) {
            $post = \Yii::$app->request->post();
            if ($post && isset($post['user_by_fiscal_code'])) {
                $usersByCFUserIds = SocialAuthUtility::makeUsersByCFUserIds($usersByCF);
                if (in_array($post['user_by_fiscal_code'], $usersByCFUserIds)) {
                    $user = User::findOne($post['user_by_fiscal_code']);
                    if (!is_null($user)) {
                        $signIn = \Yii::$app->user->login($user, $loginTimeout);
                        if ($signIn === true) {
                            $this->updateFiscalCode($userDatas);

                            return ['status' => 'fc'];
                            //return $this->redirect(['/', 'done' => 'fc']);
                        } else {
                            \Yii::$app->getSession()->addFlash('danger', Module::t('amossocialauth', 'Login Failed'));
                        }
                    } else {
                        \Yii::$app->getSession()->addFlash('danger', Module::t('amossocialauth', 'User Not Found, Please try with Other User'));
                    }
                } else {
                    \Yii::$app->getSession()->addFlash('danger', Module::t('amossocialauth', 'User Not Corresponding'));
                }
            }
            // Form to select identity by fiscal code and log-in
            return $this->render('ask-which-user', [
                'userDatas' => $userDatas,
                'usersByCF' => $usersByCF
            ]);
        } elseif ($relation && $relation->id && \Yii::$app->user->isGuest) {
            //Se l'utente è già collegato logga in automatico
            $signIn = \Yii::$app->user->login($relation->user, $loginTimeout);

            //Remove session data
            \Yii::$app->session->remove('IDM');

            return ['status' => 'rl'];
            //return $this->redirect(['/', 'done' => 'rl']);
        } elseif ($existsByFC && $existsByFC->id && \Yii::$app->user->isGuest) {
            $signIn = \Yii::$app->user->login($existsByFC->user, $loginTimeout);

            //Store IDM user
            $this->createIdmUser($userDatas);

            return ['status' => 'fc'];
            //return $this->redirect(['/', 'done' => 'fc']);
        } elseif ((($relation && $relation->id) || ($existsByFC && $existsByFC->id)) && !\Yii::$app->user->isGuest) {
            //User logged and idm exists, go to home, case not allowed
            //return $this->redirect(['/', 'error' => 'overload']);
        } elseif ($existsByEmail && $existsByEmail->id && \Yii::$app->user->isGuest && !$confirmLink && $render) {
            //Form to confirm identity and log-in
            return $this->render('log-in', [
                'userDatas' => $userDatas,
                'userProfile' => $existsByEmail->profile,
                'authType' => $this->authType,
            ]);
        } elseif ($existsByEmail && $existsByEmail->id && \Yii::$app->user->isGuest && $confirmLink) {
            //Login
            $signIn = \Yii::$app->user->login($existsByEmail, $loginTimeout);

            //Store IDM user
            $this->createIdmUser($userDatas);

            return ['status' => 'conf'];
            //return $this->redirect(['/', 'done' => 'conf']);
        } elseif (\Yii::$app->user->isGuest && $render) {
            //Form to confirm identity and log-in
            return $this->render('ask-signup', [
                'userDatas' => $userDatas,
                'authType' => $this->authType,
            ]);
        } elseif (!\Yii::$app->user->isGuest) {

            //Store IDM user
            $this->createIdmUser($userDatas);

            return ['status' => 'override'];
            //return $this->redirect(['/', 'done' => 'override']);
        }

        if ($render) {
            return ['status' => 'ND'];
            //return $this->redirect(['/', 'done' => 'ND']);
        }
    }

    /**
     * @return array|mixed
     */
    public function storeDataInSession()
    {
        //Get Headers to ckeck the reverse proxy header datas
        $headers = \Yii::$app->request->getHeaders();

        //Get Session IDM datas (copy of headers)
        $sessionIDM = \Yii::$app->session->get('IDM');

        //Check what type
        if ($headers->get('serialNumber')) {
            $type = 'header_idm';
            $dataFetch = $headers;
        } else if ($headers->get('saml_attribute_codicefiscale') || $headers->get('saml-attribute-codicefiscale')) {
            $type = 'header_spid';
            $dataFetch = $headers;
        } else if ($sessionIDM && $sessionIDM['matricola']) {
            $type = 'idm';
            $dataFetch = $headers;
        } else if ($sessionIDM && $sessionIDM['saml_attribute_codicefiscale']) {
            $type = 'spid';
            $dataFetch = $sessionIDM;
        }

        if (!$sessionIDM || !$sessionIDM['matricola']) {
            $matricola = null;
            $nome = null;
            $cognome = null;
            $emailAddress = null;
            $codiceFiscale = null;

            //Based on type i pick the user identiffier
            switch ($type) {
                case 'idm':
                    {
                        $matricola = $dataFetch['serialNumber'];
                        $nome = $dataFetch['name'];
                        $cognome = $dataFetch['familyName'];
                        $emailAddress = $dataFetch['email'];
                        $codiceFiscale = $dataFetch['codiceFiscale'];
                    }
                    break;
                case 'spid':
                    {
                        $matricola = $dataFetch['saml_attribute_codicefiscale'] ?: $dataFetch['saml-attribute-codicefiscale'];
                        $nome = $dataFetch['saml_attribute_nome'] ?: $dataFetch['saml-attribute-nome'];
                        $cognome = $dataFetch['saml_attribute_cognome'] ?: $dataFetch['saml-attribute-cognome'];
                        $emailAddress = $dataFetch['saml_attribute_emailaddress'] ?: $dataFetch['saml-attribute-emailaddress'];
                        $codiceFiscale = $dataFetch['saml_attribute_codicefiscale'] ?: $dataFetch['saml-attribute-codicefiscale'];
                    }
                    break;
                case 'header_idm':
                    {
                        $matricola = $dataFetch->get('serialNumber');
                        $nome = $dataFetch->get('name');
                        $cognome = $dataFetch->get('familyName');
                        $emailAddress = $dataFetch->get('email');
                        $codiceFiscale = $dataFetch->get('fiscalCode');
                    }
                    break;
                case 'header_spid':
                {
                    $matricola = $dataFetch->get('saml_attribute_codicefiscale') ?: $dataFetch->get('saml-attribute-codicefiscale');
                    $nome = $dataFetch->get('saml_attribute_nome') ?: $dataFetch->get('saml-attribute-nome');
                    $cognome = $dataFetch->get('saml_attribute_cognome') ?: $dataFetch->get('saml-attribute-cognome');
                    $emailAddress = $dataFetch->get('saml_attribute_emailaddress') ?: $dataFetch->get('saml-attribute-emailaddress');
                    $codiceFiscale = $dataFetch->get('saml_attribute_codicefiscale') ?: $dataFetch->get('saml-attribute-codicefiscale');
                }
            }

            //Data to store in session in case header is not filled
            $sessionIDM = [
                'matricola' => $matricola,
                'nome' => $nome,
                'cognome' => $cognome,
                'emailAddress' => $emailAddress,
                'codiceFiscale' => $codiceFiscale
            ];

            //Store to session
            \Yii::$app->session->set('IDM', $sessionIDM);
        }

        return $sessionIDM;
    }

    /**
     * @param $userDatas
     * @return bool
     */
    public function createIdmUser($userDatas)
    {
        $this->updateFiscalCode($userDatas);

        $newRelation = new SocialIdmUser();
        $newRelation->numeroMatricola = $userDatas['matricola'];
        $newRelation->nome = $userDatas['nome'];
        $newRelation->cognome = $userDatas['cognome'];
        $newRelation->emailAddress = $userDatas['emailAddress'];
        $newRelation->codiceFiscale = $userDatas['codiceFiscale'];
        $newRelation->user_id = \Yii::$app->user->id;

        //Remove session data
        \Yii::$app->session->remove('IDM');

        return $newRelation->save(false);
    }

    /**
     * @param $userDatas
     * @return bool
     */
    private function updateFiscalCode($userDatas)
    {
        // Update codice fiscale
        $user = UserProfile::findOne(['user_id' => \Yii::$app->user->id]);
        $user->codice_fiscale = $userDatas['codiceFiscale'];
        return $user->save(false);
    }
}
