<?php

use common\models\Post;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $userExtend common\models\UserExtend */
/* @var $userInfo common\models\UserInfo */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-form">


    <?= $form->field($model, 'status')->dropDownList([$model::STATUS_ACTIVE => '正常', $model::STATUS_DELETED => '冻结'], ['prompt' => '请选择状态']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userExtend, 'entry_status')->dropDownList($userExtend->getJobSelect(), ['prompt' => '请选择状态']) ?>

    <?= $form->field($userExtend, 'marital_status')->dropDownList($userExtend->getMaritalSelect(), ['prompt' => '婚姻状况']) ?>

    <?= $form->field($userExtend, 'gender')->dropDownList($userExtend->getGenderSelect(), ['prompt' => '请选择性别']) ?>

    <?= $form->field($userExtend, 'post_id')->dropDownList(Post::find()
        ->select(['name','id'])
        ->orderBy('id')
        ->indexBy('id')
        ->column(),
        ['prompt'=>'请选择状态']) ?>

    <?= $form->field($userExtend, 'tel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userExtend, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userExtend, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userExtend, 'id_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userExtend, 'nation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userExtend, 'entry_date')->widget(
        DatePicker::className(), [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-dd'
            ]
        ]
    ) ?>

    <?= $form->field($userExtend, 'dismission_date')->widget(
        DatePicker::className(), [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-dd'
            ]
        ]
    ) ?>

    <?= $form->field($userExtend, 'politics_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userExtend, 'education')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userInfo, 'health')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userInfo, 'specialty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userInfo, 'registered')->widget(
        DatePicker::className(), [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-dd'
            ]
        ]
    ) ?>

    <?= $form->field($userInfo, 'registered_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userInfo, 'graduate_date')->widget(
        DatePicker::className(), [
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-dd'
            ]
        ]
    ) ?>

    <?= $form->field($userInfo, 'graduate_colleages')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userInfo, 'intro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userInfo, 'details')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>



</div>
