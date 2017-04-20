<?php

use common\models\UserExtend;
use common\models\UserInfo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */


$userExtend = UserExtend::findOne(['user_id' => $model->id]);
$userInfo = UserInfo::findOne(['user_id' => $model->id]);

$this->title = '用户更新: ' . $model->username;

$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'userExtend' => $userExtend,
        'form' => $form,
        'userInfo' => $userInfo
    ]) ?>

    <?php ActiveForm::end(); ?>


</div>
