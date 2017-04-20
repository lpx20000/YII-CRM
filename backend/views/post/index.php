<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '职位';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增职位', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute'=>'id',
                'contentOptions'=>['width'=>'30px', 'text-align' => 'center'],
            ],
            'name',
            [
                'attribute'=>'created_at',
                'format'=>['date','php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {approve}  {delete}',
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
                        'delete' => function($url, $model, $key) {
                            $options = [
                                'title' => Yii::t('yii', 'View'),
                                'aria-label' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                                'data-confirm' => Yii::t('yii', '确定要删除?'),
                                'data-method' => 'post',
                            ];
                            return Html::a('<button type="button" class="btn btn-danger">删除</button>',$url,$options);
                        }
                ]
            ],
        ],
    ]); ?>
</div>
