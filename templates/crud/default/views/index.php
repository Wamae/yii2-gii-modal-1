<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$baseModelName = StringHelper::basename($generator->modelClass);
$wordsModelName = Inflector::camel2words($baseModelName);
$idModelName = Inflector::camel2id($baseModelName);
$title = $generator->generateString(Inflector::pluralize($wordsModelName));

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use jino5577\daterangepicker\DateRangePicker;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

wamae\gii\GiiAsset::register($this);

$this->title = <?= $title ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $idModelName ?>-index">

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
    <?php if (!empty($generator->searchModelClass)): ?>
        <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php endif; ?>

    <p>
        <?= "<?= " ?>Html::a(<?= $dataHeader = $generator->generateString('Create ' . $wordsModelName) ?>, ['create'], [
        'class' => 'btn btn-success show-modal',
        'data-target' => '#modal_view',
        'data-header' => <?= $dataHeader ?>,
        ]); ?>
    </p>
    
    $gridColumns = [
                <?php
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                    echo "            '" . $name . "',\n";
            }
        } else {
            foreach ($tableSchema->columns as $column) {
                $format = $generator->generateColumnFormat($column);
                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
        ?>
    ];
    
    <?= "<?= " ?>ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]); ?>

    <?= "<?= " ?>Modal::widget([
    'id' => 'modal_view',
    ]); ?>

    <?= '<?php Pjax::begin(); ?>'; ?>

    <?php if ($generator->indexWidgetType === 'grid'): ?>
        <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
        ['class' => 'kartik\grid\SerialColumn'],

        <?php
        $count = 0;
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                if ($name === "created_by") {
                    echo "            ['attribute'=> '" . $name . "','value'=>'createdBy.username'],\n";
                } else if ($name === "updated_by") {
                    echo "            ['attribute'=> '" . $name . "','value'=>'updatedBy.username'],\n";
                } else {
                    echo "            '" . $name . "',\n";
                }
            }
        } else {
            foreach ($tableSchema->columns as $column) {
                $format = $generator->generateColumnFormat($column);
                if ($column->name === "created_by") {
                    echo "            ['attribute'=> '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "','value'=>'createdBy.username'],\n";
                } else if ($column->name === "updated_by") {
                    echo "            ['attribute'=> '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "','value'=>'updatedBy.username'],\n";
                } else {
                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
        }
        ?>

        [
        'class' => 'kartik\grid\ActionColumn',
        'buttons' => [
			'view' => function ($url, $model, $key) {
				$options = array_merge([
					'title' => Yii::t('yii', 'View'),
					'aria-label' => Yii::t('yii', 'View'),
					'class'=>'show-modal',
					'data-target' => '#modal_view', 
					'data-header' => Yii::t('yii', 'View') . ' ' . <?= $title ?>,
				]);
				return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
			},
			'update' => function ($url, $model, $key) {
				$options = array_merge([
					'title' => Yii::t('yii', 'Update'),
					'aria-label' => Yii::t('yii', 'Update'),
					'class'=>'show-modal',
					'data-target' => '#modal_view', 
					'data-header' => Yii::t('yii', 'Update') . ' ' . <?= $title ?>,
				]);
				return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
			},
        ],
        ],
        ],
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'showPageSummary' => true,
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
    <?= '<?php Pjax::end(); ?>' ?>

</div>
