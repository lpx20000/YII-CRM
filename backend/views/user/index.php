<?php

use common\models\User;
use common\models\UserExtend;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '账号';
$this->params['breadcrumbs'][] = $this->title;
$userExtend = new UserExtend();
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建账号', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '30px'],
            ],
            [
                'label' => '用户名',
                'attribute' => 'username',
                'contentOptions' => ['width' => '150px']
            ],
             [
//                 'email:email',
                 'attribute' => 'email',
                'contentOptions' => ['width' => '200px']
             ],
            [
                'label' => '性别',
                'value' => 'userExtend.gender',
                'attribute' => 'user_extend.gender',
                'contentOptions' => ['width' => '80px'],
                'filter' => $userExtend->getGenderSelect(),
            ],
             [
                 'label' => '职位',
                 'attribute' => 'user_extend.post_id',
                 'value' => 'userPost',

             ],
             [
                 'label' => '类型',
                 'value' => 'userExtend.type',
                 'attribute' => 'user_extend.type',
             ],
             [
                 'label' => '电话',
                'attribute' => 'user_extend.tel',
                 'value' => 'userExtend.tel',
             ],
            [
                'label' => '在职状态',
                'attribute' => 'user_extend.entry_status',
                'value' => 'userExtend.jobStatus',
                'filter' => $userExtend->getJobSelect(),
                'contentOptions' => ['width' => '80px'],

            ],
            [
                'label' => '入职日期',
                'attribute' => 'user_extend.entry_date',
                'value' => 'userExtend.entry_date',
                'contentOptions' => ['width' => '100px']
            ],
            [
                'label' => '学历',
                'attribute' => 'user_extend.education',
                'value' => 'userExtend.education'
            ],
             [
                 'attribute' => 'status',
                 'value' => 'status0',
                 'filter' => (new User)->getStatusSelect(),
                 'contentOptions' => function ($model) {
                       return $model->status0 == '正常'?
                           ['class' => 'label-success']:
                           ['class' => 'label-danger'];
                 }
             ],
            [
                'label' => '登录时间',
                'attribute'=>'user_info.login_time',
                'value'=>'userInfo.login_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
                'filter' => DatePicker::widget([    // 日期组件
//                   // inline too, not bad
                    'name' => 'userInfo.'.'login_time',
                    'inline' => true,
                    'language' => 'zh-CN' , //--设置为中文
                    'clientOptions' => [
                        'autoclose' => false,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            [
              'label' => '登录IP',
                'attribute' => 'user_info.login_ip',
                'value' => 'userInfo.login_ip',
            ],
            [
                'label' => '登录次数',
                'attribute' => 'user_info.login_count',
                'value' => 'userInfo.login_count',
                'contentOptions' => ['width' => '100px']
        ],
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',

                'template' => '{view} {update} {approve}{delete}',
                'buttons' => [
                        'view' => function ($url, $model, $key){
                            $options = [
                                'title' => Yii::t('yii', '查看'),
                                'aria-label' => Yii::t('yii', '审核'),
                                'data-method' => 'get',
                                'data-pjax' => '0',
                            ];
                            return Html::a('<button type="button" class="btn btn-success">查看</button>',$url,$options);
                        },
                        'update' => function ($url, $model, $key){
                            $options = [
                                'title' => Yii::t('yii', '更新'),
                                'aria-label' => Yii::t('yii', '更新'),
                                'data-method' => 'get',
                                'data-pjax' => '0',
                            ];
                            return Html::a('<button type="button" class="btn btn-primary">更新</button>',$url,$options);
                        },
                        'approve' => function ($url, $model, $key) {
                            $options=[
                                'title'=>Yii::t('yii', '审核'),
                                'aria-label'=>Yii::t('yii','审核'),
                                'data-method'=>'post',
                                'data-pjax'=>'0',
                            ];
                            if ($model->status0 == '正常') {
                                $options['data-confirm'] = Yii::t('yii','你确定通冻结该账号吗？');
                                return Html::a('<button type="button" class="btn btn-warning">冻结</button>',$url,$options);
                            }
                            $options['data-confirm'] = Yii::t('yii','你确定激活该账号吗？');
                            return Html::a('<button type="button" class="btn btn-warning">激活</button>',$url,$options);
                        },
                        'delete' => function ($url, $model, $key){
                            $options = [
                                'title' => Yii::t('yii', 'View'),
                                'aria-label' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                                'data-confirm' => Yii::t('yii', '确定要删除?'),
                                'data-method' => 'post',
                            ];
                            return Html::a('<button type="button" class="btn btn-danger">删除</button>',$url,$options);
                        },
                ]
            ],
        ],
    ]); ?>
</div>
