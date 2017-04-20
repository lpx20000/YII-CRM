<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('首页', ['index', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status0',
                'label' => '状态',
            ],
            [
                'attribute' => 'login_count',
                'value' => $model->userInfo->login_count
            ],
            [
                'attribute' => 'userExtend.gender'
            ],
            [
                'attribute' => 'userExtend.post_id',
                'value' => $model->userPost
            ],
            [
                'attribute' => 'userExtend.type',
            ],
            [
                'attribute' => 'userExtend.tel'
            ],
            [
                'attribute' => 'userExtend.id_card'
            ],
            [
                'attribute' => 'userInfo.health'
            ],
            [
                'attribute' => 'userInfo.specialty'
            ],
            [
                'attribute' => 'userInfo.registered'
            ],
            [
                'attribute' => 'userInfo.registered_address'
            ],
            [
                'attribute' => 'userInfo.graduate_date'
            ],
            [
                'attribute' => 'userInfo.graduate_colleages'
            ],
            [
                'attribute' => 'userInfo.intro'
            ],
            [
                'attribute' => 'userInfo.details'
            ],
            [
                'label' => '婚姻状况',
                'attribute' => 'userExtend.maritalStatus',
            ],
            [
                'attribute' => 'userExtend.jobStatus',
                'label' => '是否在职',
            ],
            [
                'attribute' => 'userExtend.entry_date'
            ],
            [
                'attribute' => 'userExtend.dismission_date'
            ],
            [
                'attribute' => 'userExtend.politics_status'
            ],
            [
                'attribute' => 'userExtend.education'
            ],
            [
                'attribute' => 'login_ip',
                'value' => $model->userInfo->login_ip
            ],
            [
                'attribute' => 'login_time',
                'value' => $model->userInfo->login_time,
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date','php:Y-m-d H:i:s']
            ],
        ],
    ]) ?>

</div>
