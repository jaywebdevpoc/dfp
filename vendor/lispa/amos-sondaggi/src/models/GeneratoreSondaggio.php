<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\models
 * @category   CategoryName
 */

namespace lispa\amos\sondaggi\models;

use ReflectionClass;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\View;
use yii\gii\CodeFile;

/**
 * Class GeneratoreSondaggio
 * @package lispa\amos\sondaggi\models
 */
class GeneratoreSondaggio extends \yii\base\Model
{
    public $template            = 'default';
    public $templates           = [];
    public $ns                  = '';
    public $titoloSondaggio     = '';
    public $paginaSondaggio     = '';
    public $descPaginaSondaggio = '';
    public $baseClass           = 'yii\base\Model';

    /**
     * Genera il Model nel percorso specificato per la pagina indicata
     */
    public function creaModel($percorso, $id, $percorso_validator, $ns)
    {
        $className             = "Pagina_".$id;
        $this->ns              = $ns;
        $pagina                = SondaggiDomandePagine::findOne(['id' => $id]);
        $domande               = $pagina->getSondaggiDomandes();
        $this->titoloSondaggio = $pagina->sondaggi->titolo;
        $this->paginaSondaggio = $pagina->titolo;
        $params                = [
            'className' => "Pagina_".$id,
            'labels' => $this->generaLabel($pagina),
            'rules' => $this->generateRules($pagina, $percorso_validator),
            'ns' => $this->ns,
            'attributi' => $this->generateAttributi($pagina),
            'funzioni' => $this->generaFunzioni($pagina),
            'salvataggio' => $this->generaSave($id)
        ];
        $files                 = (new CodeFile(
            Yii::getAlias('@'.str_replace('\\', '/', $percorso)).'/'.$className.'.php',
            $this->render('model.php', $params)
            ))->save();
    }

    /**
     * Genera la classe Validatrice nel percorso specificato
     *
     */
    public function creaValidator($percorso, $id)
    {

        $this->ns              = $percorso;
        $pagina                = SondaggiDomandePagine::findOne(['id' => $id]);
        $domande               = $pagina->getSondaggiDomandes();
        $this->titoloSondaggio = $pagina->sondaggi->titolo;
        $this->paginaSondaggio = $pagina->titolo;
        foreach ($domande->all() as $Domanda) {
            if ($Domanda['sondaggi_domande_tipologie_id'] == 9 && strlen($Domanda['nome_classe_validazione']) > 0) {
                $className = $Domanda['nome_classe_validazione'];
                $params    = [
                    'className' => $className,
                    'ns' => $this->ns,
                ];
                $esiste    = SondaggiDomande::find()->andWhere(['nome_classe_validazione' => $Domanda['nome_classe_validazione']]);
                if ($esiste->count() == 0) {
                    $files = (new CodeFile(
                        Yii::getAlias('@'.str_replace('\\', '/', $percorso)).'/'.$className.'.php',
                        $this->render('validator.php', $params)
                        ))->save();
                }
            }
        }
    }

    /**
     * Genera la View nel percorso specificato per la pagina indicata
     *
     */
    public function creaView($percorso, $id, $ns)
    {
        $className = "Pagina_".$id;
        $this->ns  = $ns;
        $pagina    = SondaggiDomandePagine::findOne(['id' => $id]);
        $nPagine   = SondaggiDomandePagine::find()->andWhere(['sondaggi_id' => $pagina->sondaggi_id])->count();
        $allPagine = SondaggiDomandePagine::find()->andWhere(['sondaggi_id' => $pagina->sondaggi_id])->orderBy('id')->asArray()->all();
        $nObbligatorie = SondaggiDomande::find()->andWhere(['sondaggi_domande_pagine_id' => $id])->andWhere(['obbligatoria' => 1])->count();
        $arrPagine = [];
        foreach ($allPagine as $k => $v) {
            $arrPagine[$v['id']] = $k;
        }
        $progress                  = round(bcdiv(bcmul(100, $arrPagine[$pagina->id], 4), $nPagine, 4), 2);
        $sondaggio                 = Sondaggi::findOne(['id' => $pagina->sondaggi_id]);
        $this->titoloSondaggio     = $pagina->sondaggi->titolo;
        $this->paginaSondaggio     = $pagina->titolo;
        $this->descPaginaSondaggio = $pagina->descrizione;
        $params                    = [
            'className' => "Pagina_".$id,
            'campi' => $this->generaCampi($pagina),
            'ns' => $this->ns,
            'sondaggio' => $sondaggio,
            'pagina' => $pagina,
            'progress' => $progress,
            'obbligatorie' => $nObbligatorie,
        ];
        $files                     = (new CodeFile(
            Yii::getAlias('@'.str_replace('\\', '/', $percorso)).'/'.$className.'.php',
            $this->render('view.php', $params)
            ))->save();
    }

    /**
     * Genera le rules del model.
     * @param lispa\amos\sondaggi\models\SondaggiDomandePagine $pagina
     * @return array L'array delle rules del model
     */
    public function generateRules(SondaggiDomandePagine $pagina, $percorso_validator)
    {
        $rules       = [];
        $userProfile = \Yii::$app->getUser()->getId();
        $domande     = $pagina->getSondaggiDomandes();
        foreach ($domande->all() as $Domanda) {
            $tipo = SondaggiDomandeTipologie::findOne($Domanda['sondaggi_domande_tipologie_id'])->html_type;
            if ($Domanda['obbligatoria'] && !$Domanda['domanda_condizionata']) {
                $rules[] = "[['domanda_".$Domanda['id']."'], 'required']";
            } else if ($Domanda['obbligatoria'] && $Domanda['domanda_condizionata']) {
                $condizione           = SondaggiDomandeCondizionate::findOne(['sondaggi_domande_id' => $Domanda['id']]);
                $rispostaCondizione   = SondaggiRispostePredefinite::findOne(['id' => isset($condizione->sondaggi_risposte_predefinite_id) ? $condizione->sondaggi_risposte_predefinite_id : null]);
                $idRispostaCondizione = isset($rispostaCondizione->id) ? $rispostaCondizione->id : null;
                $domandaCondizionata  = isset($rispostaCondizione->sondaggi_domande_id) ? $rispostaCondizione->sondaggi_domande_id : null;
                $DomandaCond          = SondaggiDomande::findOne(['id' => $domandaCondizionata]);
                if(isset($DomandaCond->sondaggi_domande_tipologie_id)){
                    $tipoCondizionata     = SondaggiDomandeTipologie::findOne(['id' => $DomandaCond->sondaggi_domande_tipologie_id])->html_type;
                }                
                if ($pagina->id == $Domanda['sondaggi_domande_pagine_id'] && isset($DomandaCond->sondaggi_domande_tipologie_id)) {
                    switch ($tipoCondizionata) {
                        case 'checkbox':
                            $rules[] = "['domanda_".$Domanda['id']."', 'required', 'when' => function(\$model) {\n"
                                ."return in_array($idRispostaCondizione, is_array(\$model->domanda_$domandaCondizionata)? \$model->domanda_$domandaCondizionata : [\$model->domanda_$domandaCondizionata]);\n"
                                ."}, 'whenClient' => \"function (attribute, value) {\"\n"
                                .". \"var arrayDom$domandaCondizionata = [];\"\n"
                                .". \"$('input[type=\\\"checkbox\\\"]:checked', $('#pagina_{$pagina->id}-domanda_$domandaCondizionata')).each(function() {\"\n"
                                .". \"arrayDom$domandaCondizionata.push($(this).val());\"\n"
                                .". \"});\"\n"
                                .". \"var pos$domandaCondizionata = $.inArray(\\\"$idRispostaCondizione\\\", arrayDom$domandaCondizionata);\"\n"
                                .". \"if(pos$domandaCondizionata >= 0){\"\n"
                                .". \"return true;\"\n"
                                .". \"} else {\"\n"
                                .". \"return false;\"\n"
                                .". \"}\"\n"
                                .". \"}\"]\n";
                            break;
                        case 'radio':
                            $rules[] = "['domanda_".$Domanda['id']."', 'required', 'when' => function(\$model) {\n"
                                ."return in_array($idRispostaCondizione, is_array(\$model->domanda_$domandaCondizionata)? \$model->domanda_$domandaCondizionata : [\$model->domanda_$domandaCondizionata]);\n"
                                ."}, 'whenClient' => \"function (attribute, value) {\"\n"
                                .". \"var arrayDom$domandaCondizionata = [];\"\n"
                                .". \"$('input[type=\\\"radio\\\"]:checked', $('#pagina_{$pagina->id}-domanda_$domandaCondizionata')).each(function() {\"\n"
                                .". \"arrayDom$domandaCondizionata.push($(this).val());\"\n"
                                .". \"});\"\n"
                                .". \"var pos$domandaCondizionata = $.inArray(\\\"$idRispostaCondizione\\\", arrayDom$domandaCondizionata);\"\n"
                                .". \"if(pos$domandaCondizionata >= 0){\"\n"
                                .". \"return true;\"\n"
                                .". \"} else {\"\n"
                                .". \"return false;\"\n"
                                .". \"}\"\n"
                                .". \"}\"]\n";
                            break;
                        case 'select':
                            $rules[] = "['domanda_".$Domanda['id']."', 'required', 'when' => function(\$model) {\n"
                                ."return in_array($idRispostaCondizione, is_array(\$model->domanda_$domandaCondizionata)? \$model->domanda_$domandaCondizionata : [\$model->domanda_$domandaCondizionata]);\n"
                                ."}, 'whenClient' => \"function (attribute, value) {\"\n"
                                .". \"var dom$domandaCondizionata = $('#select-domanda_$domandaCondizionata').val();\"\n"
                                .". \"if(dom$domandaCondizionata == $idRispostaCondizione){\"\n"
                                .".\"return true;\"\n"
                                .".\"} else {\"\n"
                                .".\"return false;\"\n"
                                .". \"}\"\n"
                                .". \"}\"]\n";
                            break;
                        case 'select-multiple':
                            $rules[] = "['domanda_".$Domanda['id']."', 'required', 'when' => function(\$model) {\n"
                                ."return in_array($idRispostaCondizione, is_array(\$model->domanda_$domandaCondizionata)? \$model->domanda_$domandaCondizionata : [\$model->domanda_$domandaCondizionata]);\n"
                                ."}, 'whenClient' => \"function (attribute, value) {\"\n"
                                .". \"var dom$domandaCondizionata = $('#select-domanda_$domandaCondizionata').val();\"\n"
                                .". \"var pos$domandaCondizionata = $.inArray(\\\"$idRispostaCondizione\\\", dom$domandaCondizionata);\"\n"
                                .". \"if(pos$domandaCondizionata >= 0){\"\n"
                                .". \"return true;\"\n"
                                .". \"} else {\"\n"
                                .". \"return false;\"\n"
                                .". \"}\"\n"
                                .". \"}\"]\n";
                            break;
                        case 'file'://da implementare
                            break;
                        case 'file-multiple'://da implementare
                            break;
                        case 'img'://da implementare
                            break;
                        case 'img-multiple'://da implementare
                            break;
                        case 'custom'://da implementare
                            break;
                    }
                } else {
                    $sessione     = SondaggiRisposteSessioni::findOne(['sondaggi_id' => $Domanda['sondaggi_id'], 'user_id' => $userProfile]);
                    $risposteDate = SondaggiRisposte::findOne(['sondaggi_risposte_sessioni_id' => $sessione->id, 'sondaggi_domande_id' => isset($condizione->sondaggi_domande_id) ? $condizione->sondaggi_domande_id : null,
                            'sondaggi_risposte_predefinite_id' => $idRispostaCondizione]);
                    if (isset($risposteDate) && count($risposteDate) == 1) {
                        $rules[] = "[['domanda_".$Domanda['id']."'], 'required']";
                    }
                }
            }
            $min     = $Domanda['min_int_multipla'];
            $max     = $Domanda['max_int_multipla'];
            $minRule = "[['domanda_".$Domanda['id']."'], 'checkMinDomanda_".$Domanda['id']."']";
            $maxRule = "[['domanda_".$Domanda['id']."'], 'checkMaxDomanda_".$Domanda['id']."']";
            switch ($tipo) {
                case 'checkbox':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'safe']";
                    if ($min) {
                        $rules[] = $minRule;
                    }
                    if ($max) {
                        $rules[] = $maxRule;
                    }
                    break;
                case 'radio':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'integer']";
                    break;
                case 'select':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'integer']";
                    break;
                case 'select-multiple':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'safe']";
                    if ($min) {
                        $rules[] = $minRule;
                    }
                    if ($max) {
                        $rules[] = $maxRule;
                    }
                    break;
                case 'string':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'string', 'max' => 255]";
                    break;
                case 'text':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'string']";
                    break;
                case 'img':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'integer']";
                    break;
                case 'img-multiple':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'integer']";
                    if ($min) {
                        $rules[] = $minRule;
                    }
                    if ($max) {
                        $rules[] = $maxRule;
                    }
                    break;
                case 'file':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'safe']";
                    break;
                case 'file-multiple':
                    $rules[] = "[['domanda_".$Domanda['id']."'], 'safe']";
                    break;
                case 'custom':
                    $rules[] = "[['domanda_".$Domanda['id']."'], '$percorso_validator".$Domanda['nome_classe_validazione']."']";
                    break;
            }
        }
        return $rules;
    }

    /**
     * Genera le rules del model.
     * @param lispa\amos\sondaggi\models\SondaggiDomandePagine $pagina
     * @return array L'array delle rules del model
     */
    public function generaCampi(SondaggiDomandePagine $pagina)
    {
        $campi   = [];
        $domande = $pagina->getSondaggiDomandes()->orderBy('ordinamento ASC');
        foreach ($domande->all() as $Domanda) {
            $tipo         = SondaggiDomandeTipologie::findOne($Domanda['sondaggi_domande_tipologie_id'])->html_type;
            $idD          = $Domanda['id'];
            $user_id      = \Yii::$app->user->id;
            $tooltip      = addslashes($Domanda->tooltip);
            $introduzione = ((!empty(trim($Domanda->introduzione))) ? \Yii::$app->formatter->asHtml(str_replace('<p></p>',
                        '', trim($Domanda->introduzione))) : '');
            $tooltipHtml  = !empty($tooltip) ? "<span class=\"tooltip-field m-l-10\">
                                <span title=\"\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"$tooltip\" aria-describedby=\"tooltip833635\">
                                    <span class=\"am am-help\"> 
                                    </span> 
                                </span>
                                <div class=\"tooltip fade top\" role=\"tooltip\" id=\"tooltip833635\" style=\"top: -47px; left: 590.281px; display: none;\"><div class=\"tooltip-arrow\" style=\"left: 50%;\"></div>
                                    <div class=\"tooltip-inner\">$tooltip</div>
                                </div> 
                            </span>" : '';
            $idPagina     = $pagina->id;
            $js           = "";
            $condizionata = $Domanda['domanda_condizionata'];
            $inline       = ($Domanda['inline']) ? 'true' : 'false';
            if ($condizionata) {
                $js = "<script type=\"text/javascript\">\n"
                    .$this->generaJavascript($idD)."\n";
            }
            switch ($tipo) {
                case 'checkbox':
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')."<div class=\"col-lg-12 col-sm-12\" id=\"div-domanda_$idD\">\n"
                        ."<?php \n"
                        ."\$dati_$idD = SondaggiRispostePredefinite::find()->andWhere(['sondaggi_domande_id' => $idD])->select(['id', 'risposta'])->orderBy('ordinamento ASC')->asArray()->all(); \n"
                        ."echo \$form->field(\$model, 'domanda_$idD')->inline($inline)->checkboxList(ArrayHelper::map(\$dati_$idD, 'id', 'risposta'))->label(\$model->attributeLabels()[ 'domanda_$idD'] . '$tooltipHtml');\n"
                        ."?>\n"
                        .$js
                        ."</div>\n";
                    break;
                case 'radio':
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')."<div class=\"col-lg-12 col-sm-12\" id=\"div-domanda_$idD\">\n"
                        ."<?php \n"
                        ."\$dati_$idD = SondaggiRispostePredefinite::find()->andWhere(['sondaggi_domande_id' => $idD])->select(['id', 'risposta'])->orderBy('ordinamento ASC')->asArray()->all(); \n"
                        ."echo \$form->field(\$model, 'domanda_$idD')->inline($inline)->radioList(ArrayHelper::map(\$dati_$idD, 'id', 'risposta'))->label(\$model->attributeLabels()[ 'domanda_$idD'] . '$tooltipHtml');\n"
                        ."?>\n"
                        .$js
                        ."</div>\n";
                    break;
                case 'select':
                    //$campi[] = "echo \$form->field(\$model, 'domanda_$idD')->dropDownList(ArrayHelper::map(SondaggiRispostePredefinite::find()->andWhere(['sondaggi_domande_id' => $idD])->select(['id', 'risposta'])->all(), 'id', 'risposta'), ['prompt' => AmosSondaggi::t('amossondaggi', 'Seleziona una risposta ...')]);";
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')."<div class=\"col-lg-12 col-sm-12\" id=\"div-domanda_$idD\">\n"
                        ."<?php \n"
                        ."echo \$form->field(\$model, 'domanda_$idD')->widget(Select2::className(), ['data' => ArrayHelper::map(SondaggiRispostePredefinite::find()->andWhere(['sondaggi_domande_id' => $idD])->select(['id', 'risposta'])->all(), 'id', 'risposta'),\n"
                        ."'language' => 'it',\n"
                        ."'options' => ['placeholder' => AmosSondaggi::t('amossondaggi', 'Seleziona una risposta ...'), 'id' => 'select-domanda_$idD'],\n"
                        ."'pluginOptions' => [\n"
                        ."    'allowClear' => true\n"
                        ."],\n"
                        ."])->label(\$model->attributeLabels()[ 'domanda_$idD'] . '$tooltipHtml');\n"
                        ."?>\n"
                        .$js
                        ."</div>\n";
                    break;
                case 'select-multiple':
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')."<div class=\"col-lg-12 col-sm-12\" id=\"div-domanda_$idD\">\n"
                        ."<?php \n"
                        ."echo \$form->field(\$model, 'domanda_$idD')->widget(Select2::className(), ['data' => ArrayHelper::map(SondaggiRispostePredefinite::find()->andWhere(['sondaggi_domande_id' => $idD])->select(['id', 'risposta'])->all(), 'id', 'risposta'),\n"
                        ."'language' => 'it',\n"
                        ."'options' => ['placeholder' => AmosSondaggi::t('amossondaggi', 'Seleziona una o più risposte ...'), 'id' => 'select-domanda_$idD', 'multiple' => true],\n"
                        ."'pluginOptions' => [\n"
                        ."    'allowClear' => true\n"
                        ."],\n"
                        ."])->label(\$model->attributeLabels()[ 'domanda_$idD'] . '$tooltipHtml');\n"
                        ."?>\n"
                        .$js
                        ."</div>\n";
                    break;
                case 'string':
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')."<div class=\"col-lg-12 col-sm-12\" id=\"div-domanda_$idD\">\n"
                        ."<?php \n"
                        ."echo \$form->field(\$model, 'domanda_$idD')->textInput(['maxlength' => true])->label(\$model->attributeLabels()[ 'domanda_$idD'] . '$tooltipHtml');\n"
                        ."?>\n"
                        .$js
                        ."</div>\n";
                    break;
                case 'text':
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')."<div class=\"col-lg-12 col-sm-12\" id=\"div-domanda_$idD\">\n"
                        ."<?php \n"
                        ."echo \$form->field(\$model, 'domanda_$idD')->textarea(['rows' => 6])->label(\$model->attributeLabels()[ 'domanda_$idD'] . '$tooltipHtml');\n"
                        ."?>\n"
                        .$js
                        ."</div>\n";
                    break;
                case 'file':
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')."<div class=\"col-xs-12\">
                    <?php echo Html::tag('label', \$model->attributeLabels()['domanda_{$idD}']. '$tooltipHtml'); ?>
                    <?php 
                    echo
                    FileInput::widget([
                        'name' => 'domanda_{$idD}_user_{$user_id}',
                          'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false
                        ]
                    ]);\n
                    echo '<p>'. AmosSondaggi::t('amossondaggi', 'Puoi inserire un solo allegato, aggiungendone un altro questo sostituirà il precedente.').'</p>';
                  
                  if(!empty(\$file_$idD)){
                      echo AttachmentsList::widget([
                        'model' => \$file_$idD,
                        'attribute' =>  'domanda_$idD'
                      ]); \n
                  } \n
             
                  echo \$form->field(\$model, 'domanda_$idD')->hiddenInput(['value' => 'file'])->label(false);
                    
                  ?>
                </div>
                    ";
                    break;
                case 'file-multiple':
                    $campi[] = (!empty($introduzione) ? "<div class=\"col-lg-12 col-sm-12 testo-introduttivo\">$introduzione</div>"
                            : '')
                        ."<div class=\"col-xs-12\">
                     <?php echo Html::tag('label', \$model->attributeLabels()['domanda_{$idD}']. '$tooltipHtml'); ?>
                    <?php 
                    echo
                    FileInput::widget([
                        'name' => 'domanda_{$idD}_user_{$user_id}[]',
                          'pluginOptions' => [
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false
                        ],
                        'options' => ['multiple' => true]
                    ]);\n
                  
                  if(!empty(\$file_$idD)){
                      echo AttachmentsList::widget([
                        'model' => \$file_$idD,
                        'attribute' =>  'domanda_$idD'
                      ]); \n
                  } \n
             
                  echo \$form->field(\$model, 'domanda_$idD')->hiddenInput(['value' => 'file'])->label(false);
                    
                  ?>
                </div>
                    ";
                    break;
                case 'img'://da implementare
                    $campi[] = "";
                    break;
                case 'img-multiple'://da implementare
                    $campi[] = "";
                    break;
                case 'custom'://da implementare
                    $campi[] = "";
                    break;
            }
        }
        return $campi;
    }

    /**
     * Genera il codice javascript per le domande condizionate in modo da
     * farle visualizzare o nascondere, il funzionamento è differenziato
     * in base alla presenza di domande condizionate in questa pagina oppure
     * in pagine precedenti
     * @param integer $idD Id della domanda
     * @return string Restituisce il codice javascript da inserire nella view
     */
    public function generaJavascript($idD, $utente = NULL)
    {
        if (!$utente) {
            $utente = \Yii::$app->getUser()->getId();
        }
        $tipoCondizioneLibera = null;
        $tipoCondizione = null;
        $domanda              = SondaggiDomande::findOne(['id' => $idD]);
        $sondaggio            = $domanda->sondaggi_id;
        $tipo                 = SondaggiDomandeTipologie::findOne($domanda->sondaggi_domande_tipologie_id)->html_type;
        $idPagina             = $domanda->getSondaggiDomandePagine()->one()['id'];
        $idPaginaCondizione = $idPagina;
        $condizione           = SondaggiDomandeCondizionate::findOne(['sondaggi_domande_id' => $domanda->id]);
        $condizioneLibera           = $domanda->domanda_condizionata_testo_libero;
        if(!empty($condizioneLibera)){
            $rispostaCondizioneLibera   = SondaggiDomande::findOne(['id' => $condizioneLibera]);

        $idPaginaCondizioneLibera   = $rispostaCondizioneLibera->sondaggi_domande_pagine_id;
        $idDomandaCondizioneLibera  = $rispostaCondizioneLibera->id;
        $tipoCondizioneLibera       = SondaggiDomandeTipologie::findOne($rispostaCondizioneLibera->sondaggi_domande_tipologie_id)->html_type;       
        $rispostaCondizione   = SondaggiRispostePredefinite::findOne(['id' => $condizione->sondaggi_risposte_predefinite_id]);
        }
        
        if(!empty($rispostaCondizione)){
        $idRispostaCondizione = $rispostaCondizione->id;
        $idPaginaCondizione   = $rispostaCondizione->getSondaggiDomande()->one()['sondaggi_domande_pagine_id'];
        $idDomandaCondizione  = $rispostaCondizione->getSondaggiDomande()->one()['id'];
        $tipoCondizione       = SondaggiDomandeTipologie::findOne($rispostaCondizione->getSondaggiDomande()->one()['sondaggi_domande_tipologie_id'])->html_type;
        }
      
        $javascript           = "";
        if ($idPagina == $idPaginaCondizione) {
            switch ($tipoCondizione) {
                case 'checkbox':
                    $javascript = "$(document).ready(function () {"
                        ."$('#pagina_$idPagina-domanda_$idDomandaCondizione').ready(function(){"
                        ."var arrayPreDom$idDomandaCondizione = [];"
                        ."$('input[type=\"checkbox\"]:checked', this).each(function () {"
                        ."arrayPreDom$idDomandaCondizione.push($(this).val());"
                        ."});"
                        ."var prepos$idDomandaCondizione = $.inArray(\"$idRispostaCondizione\", arrayPreDom$idDomandaCondizione);"
                        ."if (prepos$idDomandaCondizione >= 0) {"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}"
                        ."});"
                        ."$('#pagina_$idPagina-domanda_$idDomandaCondizione').change(function (event, messages) {"
                        ."var arrayDom$idDomandaCondizione = [];"
                        ."$('input[type=\"checkbox\"]:checked', this).each(function() {"
                        ."arrayDom$idDomandaCondizione.push($(this).val());"
                        ."});"
                        ."var pos$idDomandaCondizione = $.inArray(\"$idRispostaCondizione\", arrayDom$idDomandaCondizione);"
                        ."if(pos$idDomandaCondizione >= 0){"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}});"
                        ."});"
                        ."\n</script>\n";
                    break;
                case 'radio':
                    $javascript = "$(document).ready(function () {"
                        ."$('#pagina_$idPagina-domanda_$idDomandaCondizione').ready(function(){"
                        ."var arrayPreDom$idDomandaCondizione = [];"
                        ."$('input[type=\"radio\"]:checked', this).each(function () {"
                        ."arrayPreDom$idDomandaCondizione.push($(this).val());"
                        ."});"
                        ."var prepos$idDomandaCondizione = $.inArray(\"$idRispostaCondizione\", arrayPreDom$idDomandaCondizione);"
                        ."if (prepos$idDomandaCondizione >= 0) {"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}"
                        ."});"
                        ."$('#pagina_$idPagina-domanda_$idDomandaCondizione').change(function (event, messages) {"
                        ."var arrayDom$idDomandaCondizione = [];"
                        ."$('input[type=\"radio\"]:checked', this).each(function() {"
                        ."arrayDom$idDomandaCondizione.push($(this).val());"
                        ."});"
                        ."var pos$idDomandaCondizione = $.inArray(\"$idRispostaCondizione\", arrayDom$idDomandaCondizione);"
                        ."if(pos$idDomandaCondizione >= 0){"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}});"
                        ."});"
                        ."\n</script>\n";
                    break;
                case 'select':
                    $javascript = "$(document).ready(function () {"
                        ."$('#div-domanda_$idD').hide();"
                        ."if($('#select-domanda_$idDomandaCondizione').val() == $idRispostaCondizione){"
                        ."$('#div-domanda_$idD').show();"
                        ."}"
                        ."$('#select-domanda_$idDomandaCondizione').change(function (event, messages) {"
                        ."var dom$idDomandaCondizione = $('#select-domanda_$idDomandaCondizione').val();"
                        ."if(dom$idDomandaCondizione == $idRispostaCondizione){"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}"
                        ."});"
                        ."});"
                        ."\n</script>\n";
                    break;
                case 'select-multiple':
                    $javascript = "$(document).ready(function () {"
                        ."$('#div-domanda_$idD').hide();"
                        ."var preDom$idDomandaCondizione = $('#select-domanda_$idDomandaCondizione').val();"
                        ."var prePos$idDomandaCondizione = $.inArray('$idRispostaCondizione', preDom$idDomandaCondizione);"
                        ."if(prePos$idDomandaCondizione >= 0){"
                        ."$('#div-domanda_$idD').show();"
                        ."}"
                        ."$('#select-domanda_$idDomandaCondizione').change(function (event, messages) {"
                        ."var dom$idDomandaCondizione = $('#select-domanda_$idDomandaCondizione').val();"
                        ."var pos$idDomandaCondizione = $.inArray('$idRispostaCondizione', dom$idDomandaCondizione);"
                        ."if (pos$idDomandaCondizione >= 0) {"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}"
                        ."});"
                        ."});"
                        ."\n</script>\n";
                    break;
                case 'custom'://da implementare
                    $javascript = "\n</script>\n";
                    break;
            }
            switch ($tipoCondizioneLibera) {
                case 'string':
                     $javascript = "$(document).ready(function () {"
                        ."$('#div-domanda_$idD').hide();"
                            . "var str$idDomandaCondizioneLibera = $('#pagina_$idPagina-domanda_$idDomandaCondizioneLibera').val();"
                        ."if(str$idDomandaCondizioneLibera.length > 0){"
                        ."$('#div-domanda_$idD').show();"
                        ."}"
                        ."$('#pagina_$idPagina-domanda_$idDomandaCondizioneLibera').keyup(function (event, messages) {"
                        ."var dom$idDomandaCondizioneLibera = $('#pagina_$idPagina-domanda_$idDomandaCondizioneLibera').val();"
                        ."if(dom$idDomandaCondizioneLibera.length > 0){"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}"
                        ."});"
                        ."});"
                        ."\n</script>\n";
                    break;
                case 'text':
                        $javascript = "$(document).ready(function () {"
                        ."$('#div-domanda_$idD').hide();"
                            . "var str$idDomandaCondizioneLibera = $('#pagina_$idPagina-domanda_$idDomandaCondizioneLibera').val();"
                        ."if(str$idDomandaCondizioneLibera.length > 0){"
                        ."$('#div-domanda_$idD').show();"
                        ."}"
                        ."$('#pagina_$idPagina-domanda_$idDomandaCondizioneLibera').keyup(function (event, messages) {"
                        ."var dom$idDomandaCondizioneLibera = $('#pagina_$idPagina-domanda_$idDomandaCondizioneLibera').val();"
                        ."if(dom$idDomandaCondizioneLibera.length > 0){"
                        ."$('#div-domanda_$idD').show();"
                        ."} else {"
                        ."$('#div-domanda_$idD').hide();"
                        ."}"
                        ."});"
                        ."});"
                        ."\n</script>\n";
                    break;
            }
        } else {
            if(!empty($condizione)){
            $javascript = "$(document).ready(function () {"
                ."$('#div-domanda_$idD').hide();"
                ."\n</script>\n"
                ."<?php \n"
                ."if(!isset(\$utente)){\n"
                ."\$utente = Yii::\$app->getUser()->getId();\n"
                ."}\n"
                ."\$sessione = SondaggiRisposteSessioni::findOne(['sondaggi_id' => $sondaggio, 'user_id' => \$utente]);\n"
                ."\$risposteDate = SondaggiRisposte::findOne(['sondaggi_risposte_sessioni_id' => \$sessione->id, 'sondaggi_domande_id' => $idDomandaCondizione, 'sondaggi_risposte_predefinite_id' => $idRispostaCondizione]);\n"
                ."if(count(\$risposteDate) == 1){\n"
                ."?>\n"
                ."<script type=\"text/javascript\">\n"
                ."$(document).ready(function () {"
                ."$('#div-domanda_$idD').show();"
                ."});"
                ."\n</script>\n"
                ."<?php\n"
                ."} else {\n"
                ."?>\n"
                ."<script type=\"text/javascript\">\n"
                ."$(document).ready(function () {"
                ."$('#div-domanda_$idD').hide();"
                ."});"
                ."\n</script>\n"
                ."<?php\n"
                ."}\n"
                ."?>\n";
            }
        }
        return $javascript;
    }

    /**
     * Prende il template
     */
    public function getTemplate()
    {
        return NULL;
    }

    public function render($template, $params = [])
    {
        $view                = new View();
        $params['generator'] = $this;

        return $view->renderFile($this->getTemplatePath().'/'.$template, $params, $this);
    }

    /**
     * @return string the root path of the template files that are currently being used.
     * @throws InvalidConfigException if [[template]] is invalid
     */
    public function getTemplatePath()
    {
        if (isset($this->templates[$this->template])) {
            return $this->templates[$this->template];
        } else {
            $this->templates['default'] = $this->defaultTemplate();
            return $this->templates['default'];
        }
    }

    /**
     * Returns the root path to the default code template files.
     * The default implementation will return the "templates" subdirectory of the
     * directory containing the generator class file.
     * @return string the root path to the default code template files.
     */
    public function defaultTemplate()
    {
        $class = new ReflectionClass($this);

        return dirname($class->getFileName()).'/default';
    }

    /**
     * Genera le label del model
     * @param SondaggiDomandePagine $pagina L'active record della pagina del sondaggio
     * @return array L'array con le labels del model
     */
    public function generaLabel(SondaggiDomandePagine $pagina)
    {
        $labels  = [];
        $domande = $pagina->getSondaggiDomandes();
        foreach ($domande->all() as $Domanda) {
            $labels[] = "'domanda_".$Domanda['id']."' => AmosSondaggi::t('amossondaggipubblicazione', '".addslashes($Domanda['domanda'])."')";
        }
        return $labels;
    }

    /**
     * Genera le funzioni per validare i dati
     */
    public function generaFunzioni(SondaggiDomandePagine $pagina)
    {
        $funzioni = [];
        $domande  = $pagina->getSondaggiDomandes();
        foreach ($domande->all() as $Domanda) {
            $tipo    = SondaggiDomandeTipologie::findOne($Domanda['sondaggi_domande_tipologie_id'])->html_type;
            $min     = $Domanda['min_int_multipla'];
            $max     = $Domanda['max_int_multipla'];
            $minRule = "/**\n"
                ."*  Funzione validatrice del campo domanda_".$Domanda['id']."\n"
                ."*  La funzione viene utilizzata dalle rules e verifica che\n"
                ."*  la selezione del numero minimo di elementi sia rispettata\n"
                ."**/\n"
                ."public function checkMinDomanda_".$Domanda['id']."(\$model, \$attribute){\n"
                ."if(count(\$this->domanda_".$Domanda['id'].") < $min){\n"
                ."\$this->addError(\$model, 'Il numero di elementi selezionati non deve essere inferiore a $min');\n"
                ."}\n"
                ."}\n";
            $maxRule = "/**\n"
                ."*  Funzione validatrice del campo domanda_".$Domanda['id']."\n"
                ."*  La funzione viene utilizzata dalle rules e verifica che\n"
                ."*  la selezione del numero massimo di elementi sia rispettata\n"
                ."**/\n"
                ."public function checkMaxDomanda_".$Domanda['id']."(\$model, \$attribute){\n"
                ."if(count(\$this->domanda_".$Domanda['id'].") > $max){\n"
                ."\$this->addError(\$model, 'Il numero di elementi selezionati non deve essere superiore a $max');\n"
                ."}\n"
                ."}\n";
            switch ($tipo) {
                case 'checkbox':
                    if ($min) {
                        $funzioni[] = $minRule;
                    }
                    if ($max) {
                        $funzioni[] = $maxRule;
                    }
                    break;
                case 'radio':
                    break;
                case 'select':
                    break;
                case 'select-multiple':
                    if ($min) {
                        $funzioni[] = $minRule;
                    }
                    if ($max) {
                        $funzioni[] = $maxRule;
                    }
                    break;
                case 'string':
                    break;
                case 'text':
                    break;
                case 'img':
                    break;
                case 'img-multiple':
                    if ($min) {
                        $funzioni[] = $minRule;
                    }
                    if ($max) {
                        $funzioni[] = $maxRule;
                    }
                    break;
                case 'custom':
                    break;
            }
        }
        return $funzioni;
    }

    /**
     * Genera gli attributi del model.
     * @param lispa\amos\sondaggi\models\SondaggiDomandePagine $pagina
     * @return array L'array degli attributi del model
     */
    public function generateAttributi(SondaggiDomandePagine $pagina)
    {
        $attributi = [];
        $domande   = $pagina->getSondaggiDomandes();
        foreach ($domande->all() as $Domanda) {
            $attributi[] = "public \$domanda_".$Domanda['id'];
        }
        return $attributi;
    }

    /**
     * Genera la funzione di salvataggio della pagina
     * @param integer $pagina Id della pagina per cui generare la funzione di salvataggio
     */
    public function generaSave($pagina)
    {
        $Pagina      = SondaggiDomandePagine::findOne(['id' => $pagina]);
        $domande     = $Pagina->getSondaggiDomandes();
        $user_id     = \Yii::$app->user->id;
        $salvataggio = [];
        foreach ($domande->all() as $Domanda) {
            $tipo = SondaggiDomandeTipologie::findOne(['id' => $Domanda['sondaggi_domande_tipologie_id']])->html_type;
            if ($tipo != 'file' && $tipo != 'file-multiple') {
                $salvataggio[] = "SondaggiRisposte::deleteAll(['sondaggi_domande_id' => {$Domanda['id']}, 'sondaggi_risposte_sessioni_id' => \$sessione]);\n";
            }
            $salvataggio[] = "if (!is_array(\$this->domanda_{$Domanda['id']}) && \$this->domanda_{$Domanda['id']} != NULL) {"
                ."\$this->domanda_{$Domanda['id']} = [\$this->domanda_{$Domanda['id']}];\n"
                ."}\n";
            switch ($tipo) {
                case 'checkbox':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = new SondaggiRisposte();\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."\$risposta->sondaggi_risposte_predefinite_id = \$Risposta;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'radio':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = new SondaggiRisposte();\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."\$risposta->sondaggi_risposte_predefinite_id = \$Risposta;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'select':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = new SondaggiRisposte();\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."\$risposta->sondaggi_risposte_predefinite_id = \$Risposta;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'select-multiple':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = new SondaggiRisposte();\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."\$risposta->sondaggi_risposte_predefinite_id = \$Risposta;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'string':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = new SondaggiRisposte();\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."\$risposta->risposta_libera = \$Risposta;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'text':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = new SondaggiRisposte();\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."\$risposta->risposta_libera = \$Risposta;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'file':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = SondaggiRisposte::find()->andWhere(['sondaggi_domande_id' => {$Domanda['id']}, 'sondaggi_risposte_sessioni_id' => \$sessione])->one();\n"
                        ."if(empty(\$risposta)){\$risposta = new SondaggiRisposte();}\n"
                        ."\$file = UploadedFile::getInstanceByName(\"domanda_{$Domanda['id']}_user_{$user_id}\");\n"
                        ."if(!empty(\$file)){\n"
                        ."\$file->saveAs(\Yii::\$app->getModule('attachments')->getUserDirPath(\"domanda_{$Domanda['id']}_user_{$user_id}\") . \$file->name);\n"
                        ."\$dir = \Yii::\$app->getModule('attachments')->getUserDirPath(\"domanda_{$Domanda['id']}_user_{$user_id}\");\n"
                        ."\Yii::\$app->getModule('attachments')->attachFile(\$dir .\$file->name , new SondaggiRisposte(), \"domanda_{$Domanda['id']}_user_{$user_id}\", true, true);\n"
                        ."}\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."\$attachfile = File::find()->andWhere(['model' => get_class(new SondaggiRisposte()), 'attribute' => \"domanda_{$Domanda['id']}_user_{$user_id}\"])->one();\n"
                        ."if(!empty(\$attachfile)){\n"
                        ."\$attachfile->itemId = \$risposta->id;\n"
                        ."\$attachfile->attribute = \"domanda_{$Domanda['id']}\";\n"
                        ."\$attachfile->save(false);\n"
                        ."}\n"
                        ."\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'file-multiple':
                    $salvataggio[] = "if (is_array(\$this->domanda_{$Domanda['id']})) {\n"
                        ."foreach (\$this->domanda_{$Domanda['id']} as \$Risposta) {\n"
                        ."\$risposta = SondaggiRisposte::find()->andWhere(['sondaggi_domande_id' => {$Domanda['id']}, 'sondaggi_risposte_sessioni_id' => \$sessione])->one();\n"
                        ."if(empty(\$risposta)){\$risposta = new SondaggiRisposte();}\n"
                        ."\$files = UploadedFile::getInstancesByName(\"domanda_{$Domanda['id']}_user_{$user_id}\");\n"
                        ."foreach(\$files as \$file){\n"
                        ."\$file->saveAs(\Yii::\$app->getModule('attachments')->getUserDirPath(\"domanda_{$Domanda['id']}_user_{$user_id}\") . \$file->name);\n"
                        ."\$dir = \Yii::\$app->getModule('attachments')->getUserDirPath(\"domanda_{$Domanda['id']}_user_{$user_id}\");\n"
                        ."\Yii::\$app->getModule('attachments')->attachFile(\$dir .\$file->name , new SondaggiRisposte(), \"domanda_{$Domanda['id']}_user_{$user_id}\", true, true);\n"
                        ."}\n"
                        ."\$risposta->sondaggi_domande_id = {$Domanda['id']};\n"
                        ."\$risposta->sondaggi_risposte_sessioni_id = \$sessione;\n"
                        ."if(\$accesso){\n"
                        ."\$risposta->sondaggi_accessi_servizi_id = \$accesso;\n"
                        ."}\n"
                        ."\$risposta->save();\n"
                        ."\$attachfiles = File::find()->andWhere(['model' => get_class(new SondaggiRisposte()), 'attribute' => \"domanda_{$Domanda['id']}_user_{$user_id}\"])->all();\n"
                        ."foreach(\$attachfiles as \$attachfile){\n"
                        ."\$attachfile->itemId = \$risposta->id;\n"
                        ."\$attachfile->attribute = \"domanda_{$Domanda['id']}\";\n"
                        ."\$attachfile->save(false);\n"
                        ."} \n"
                        ."\n"
                        ."}\n"
                        ."}\n";
                    break;
                case 'img'://da implementare
                    break;
                case 'img-multiple'://da implementare
                    break;
                case 'custom'://da implementare
                    break;
            }
        }
        $salvataggio[] = "if(\$completato){\n"
            ."\$Sessione = SondaggiRisposteSessioni::findOne(['id' => \$sessione]);\n"
            ."\$Sessione->completato = 1;\n"
            ."\$Sessione->end_date = date('Y-m-d H:i:s');\n"
            ."\$Sessione->save();\n"
            ."}\n";
        return $salvataggio;
    }
}