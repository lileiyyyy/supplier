<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap4\Alert;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo Html::a('导出', '#', [
        'id' => 'create',
        'data-toggle' => 'modal',
        'data-target' => '#page-modal',
        'class' => 'btn btn-success',
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'grid',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            [
                'attribute' => 'id',
                'label' => 'id',
                'filter' => Html::activeDropDownList($searchModel, 'id', \app\models\Supplier::getIdList(), [
                        'prompt' => 'ALL',
                        'class' => 'form-control'
                    ]
                ),
                'value' => function ($model) {
                    return $model->id;
                },
                'format' => 'raw',
            ],
            'name',
            'code',
            [
                'attribute' => 't_status',
                'label' => 't_status',
                'filter' => Html::activeDropDownList($searchModel, 't_status', \app\models\Supplier::getTStatusList(), [
                        'prompt' => 'ALL',
                        'class' => 'form-control'
                    ]
                ),
                'value' => function ($model) {
                    return $model->t_status;
                },
                'format' => 'raw',
            ],
        ],
        'pager' => [
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'firstPageLabel' => '第一页',
            'lastPageLabel' => '最后一页',
            'options' => ['style' => 'margin-left:200px;', 'class' => "pagination"],
        ],
    ]); ?>
    <div class="offset-lg-1 for-select-all" style="color:#999;display: none;">
        <span style="font-weight: bold;">All <?= $dataProvider->getCount() ?></span> conversations on this page have
        been selected . <a onclick="selectAll()" style="color: dodgerblue" href="javascript:void(0);">Select
            all conversations
            that match this search</a>
    </div>
    <div class="offset-lg-1 for-clear-selection" style="color:#999;display: none">
        All conversations in this search have been selected. <a onclick="clearSelection()" style="color: dodgerblue"
                                                                href="javascript:void(0);">clear
            selection</a>
    </div>
    <?php
    Modal::begin([
        'id' => 'page-modal',
        'title' => '注意',
    ]);
    echo $this->render('_export');
    echo Html::a('确定', "javascript:void(0);", ['class' => 'btn btn-primary']);
    Modal::end();
    ?>
</div>
<script>
    var isSelectAll = false;
    var pageSelectAll = false;
    var supplierSearchParams = '<?=$supplierSearchParams?>';
    $("#grid input[name='selection[]']").on("click", function () {
        var ids = $("#grid").yiiGridView("getSelectedRows");
        noticeMsg(ids.length === <?=$dataProvider->getCount()?>);
    });
    $("#grid input[name='selection_all']").on("click", function () {
        noticeMsg($(this).prop('checked'))
    });
    $(document).on("click", ".btn-primary", function () {
        var ids = $("#grid").yiiGridView("getSelectedRows");
        if (ids.length === 0) {
            alert("请至少选择一行数据");
            return false;
        }
        var header = [];
        $("#exportForm").find("input[name='exportField[]']:checked").each(function () {
            header.push($(this).val());
        });
        var headerStr = header.join(',');
        var idStr = ids.join(',');
        var url = "<?=Url::to(['supplier/export'])?>";
        url = url + '&' + supplierSearchParams + '&header=' + headerStr + '&ids=' + idStr + '&isSelectAll=' + isSelectAll;
        console.log(url);
        window.location.href = url;
    });

    function noticeMsg(selectAll) {
        pageSelectAll = selectAll
        if (selectAll) {
            if (!isSelectAll) {
                $('.for-select-all').show();
            }
        } else {
            $('.for-select-all').hide();
            $('.for-clear-selection').hide();
            isSelectAll = false;
        }
    }

    function selectAll() {
        isSelectAll = true;
        $('.for-select-all').hide();
        $('.for-clear-selection').show();
    }

    function clearSelection() {
        isSelectAll = false;
        if (pageSelectAll) {
            $('.for-select-all').show();
        }
        $('.for-clear-selection').hide();
    }

</script>
