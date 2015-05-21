<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$baseModelName = StringHelper::basename($generator->modelClass);
$wordsModelName = Inflector::camel2words($baseModelName);
$idModelName =  Inflector::camel2id($baseModelName);
$title = $generator->generateString(Inflector::pluralize($wordsModelName));

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

conquer\gii\GiiAsset::register($this);

$this->title = <?= $title ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $idModelName ?>-index">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <p>
    <?= "<?= " ?>Html::button(<?= $dataHeader = $generator->generateString('Create ' . $wordsModelName) ?>, [
        'class' => 'btn btn-success show-modal',
        'value' => Url::to(['create']),
        'data-target' => '#modal_view',
        'data-header' => <?= $dataHeader ?>,
    ]); ?>
    </p>

    <?= "<?= " ?>Modal::widget([
        'id' => 'modal_view',
    ]); ?>

    <?= "<?php" ?> Pjax::begin(['id'=>'pjax-<?= $idModelName ?>-index']);?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class'=>'show-modal',
                            'value' => $url,
                            'data-target' => '#modal_view', 
                            'data-header' => Yii::t('yii', 'View') . ' ' . <?= $title ?>,
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'javascript:;', $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class'=>'show-modal',
                            'value' => $url, 
                            'data-target' => '#modal_view', 
                            'data-header' => Yii::t('yii', 'Update') . ' ' . <?= $title ?>,
                        ]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'javascript:;', $options);
                    },
                ],
            ],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

    <?= "<?php" ?> Pjax::end();?>
    
</div>
