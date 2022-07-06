<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<style></style>

<div>
    <div class="form-group" id="exportForm">
        <label class="control-label">请选择需要导出的字段</label>
        <div>
            <label><input type="checkbox" name="exportField[]" checked disabled value="id">ID</label>
            <label><input type="checkbox" name="exportField[]" value="name"> name</label>
            <label><input type="checkbox" name="exportField[]" value="code"> code</label>
            <label><input type="checkbox" name="exportField[]" value="t_status"> t_status</label>
        </div>
        <div class="help-block"></div>
    </div>
</div>
