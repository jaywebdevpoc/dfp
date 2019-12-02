<?php
echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
use lispa\amos\sondaggi\models\SondaggiDomandePagine;
use lispa\amos\sondaggi\models\SondaggiDomandeTipologie;
use lispa\amos\sondaggi\models\SondaggiDomandeCondizionate;
use lispa\amos\sondaggi\models\SondaggiRispostePredefinite;
use lispa\amos\sondaggi\models\Sondaggi;
use lispa\amos\sondaggi\models\SondaggiDomande;
use lispa\amos\sondaggi\models\SondaggiRisposte;
use lispa\amos\sondaggi\models\SondaggiRisposteSessioni;
use lispa\amos\sondaggi\models\SondaggiStato;
use lispa\amos\core\helpers\Html;
use yii\helpers\Url;
use lispa\amos\core\forms\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use lispa\amos\core\forms\Tabs;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use lispa\amos\sondaggi\AmosSondaggi;
use lispa\amos\attachments\components\AttachmentsInput;
use kartik\file\FileInput;
use lispa\amos\attachments\components\AttachmentsList;



/**
* Questa è la view per la pagina "<?= $generator->paginaSondaggio ?>" del sondaggio "<?= $generator->titoloSondaggio ?>".
*
*/

$this->title = AmosSondaggi::t('amossondaggi', 'Compila il sondaggio: <?= addslashes($generator->titoloSondaggio) ?>');
$this->params['breadcrumbs'][] = $this->title;
if(!isset($libero)){
$libero = FALSE;
}
<?php
echo "\n?>\n";
?>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<?php
if ($sondaggio->frontend == 1) {
    if (!empty($sondaggio->forza_lingua)) {
        echo "<?php\n \Yii::\$app->language = '".$sondaggio->forza_lingua."'; \n?>\n";
    }
    ?>
    <div class="container-padding">
        <h1><?= $generator->titoloSondaggio ?></h1>
        <div class="simple-progressbar" style="height:24px;min-width:10%;width:<?= $progress ?>%;background: green;text-align:center;color:#fff"><?= $progress ?>%</div>
    </div>
    <?php
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        var submitClicked = false;
        $('#form_true_sondaggio-<?=$pagina->id?>').submit(function (e) {
            if (submitClicked === false) {
                e.preventDefault();
                return false;
            }
        });
        $('#truesubmit-<?= $pagina->id ?>').click(function () {
            submitClicked = true;
            $('#form_true_sondaggio-<?=$pagina->id?>').submit();

        });
    });
</script>
<div class="sondaggi-compilazione pagid-<?= $pagina->id ?>">
    <div class="sondaggi-form">
        <?php
        echo "<?php \n";
        ?>        
        $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'form_true_sondaggio-<?=$pagina->id?>']]);
        $customView = Yii::$app->getViewPath() . '/imageField.php';
        <?php
        echo "\n ?>\n";
        ?>
        <?php if (!empty(trim($generator->paginaSondaggio))) { ?>
            <h3 class="sondaggio"><?= $generator->paginaSondaggio ?></h3>
        <?php } ?>
        <?php if (!empty(trim($generator->descPaginaSondaggio))) { ?>
            <h4 class="sondaggio"><?= $generator->descPaginaSondaggio ?></h4>
        <?php } ?>
        <div class="row">
            <?php foreach ($campi as $campo) : ?>                          
                <?= $campo ?>
            <?php endforeach; ?>
        </div> 
        <div class="col-xs-12 text-right">
            <?php
            if (!empty($obbligatorie) && $obbligatorie > 0) {
                echo "<?= '* ' . \Yii::t('amossondaggi', 'campi obbligatori') ?>";
            }
            ?>
        </div>
    </div>
    <div id="form-actions" class="bk-btnFormContainer">

        <?php
        $urlSondaggio = trim($sondaggio->url_chiudi_sondaggio);

        echo "<?php
                if(!isset(\$attivita) && !\$libero): ?>\n
                <?=
                Html::a(AmosSondaggi::t('amossondaggi', 'Chiudi'), ".(!empty($urlSondaggio) ? "'$urlSondaggio'" : "Url::previous()").", [
                    'class' => 'btn btn-secondary undo-edit mr10'
                ]);
                ?>\n
                <?php endif; ?>\n
                <?= Html::button(
                                AmosSondaggi::t('amossondaggi', 'Prosegui'), [
                                'id' => 'truesubmit-".$pagina->id."',
                    'class' => 'btn btn-navigation-primary'
                ]);
                ?>\n                
            ";
        ?>

    </div>
    <input type="hidden" name="idPagina" value="<?= '<?=$idPagina?>' ?>">
    <input type="hidden" name="idSessione" value="<?= '<?=$idSessione?>' ?>">
    <input type="hidden" name="utente" value="<?= '<?=$utente?>' ?>">    
    <?php echo "\n<?php ActiveForm::end(); ?>\n" ?>
</div>
