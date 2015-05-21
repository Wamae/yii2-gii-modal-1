<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$idModelName = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

conquer\gii\GiiAsset::register($this);

$this->title = Yii::t('yii', 'Create') . ' ' . <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= "<?php" ?> Pjax::begin(['id'=>'pjax-<?= $idModelName ?>-create']) ?>

<div class="<?= $idModelName ?>-create">

    <?= "<?php" ?> if(!\Yii::$app->request->isAjax): ?>
    
    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    
    <?= "<?php" ?> endif ?>

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?= "<?php" ?> Pjax::end() ?>