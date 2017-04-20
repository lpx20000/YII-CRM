<?php
namespace backend\components;
use common\models\Nav;
use dmstr\widgets\Menu;
use Yii;

/**
 * Created by PhpStorm.
 * User: 雨鱼
 * Date: 2017/4/10
 * Time: 15:45
 */
class NavWidget extends Menu
{
    /**
     * 侧边菜单
     * @return string
     * Create: 雨鱼
     */
    public static function menu()
    {
        $navs = Nav::find()->all();
        $info = self::getTreeNav($navs);
        $config['options'] = ['class' => 'sidebar-menu'];
        $config['items'] = $info;

//        $config = [
//            'options' => ['class' => 'sidebar-menu'],
//            'items' => [
//                ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
//                ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                ['label' => 'Login', 'url' => ['index/login'], 'visible' => Yii::$app->user->isGuest],
//                [
//                    'label' => 'Same tools',
//                    'icon' => 'share',
//                    'url' => '#',
//                    'items' => [
//                        ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                        ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                        [
//                            'label' => 'Level One',
//                            'icon' => 'circle-o',
//                            'url' => '#',
//                            'items' => [
//                                ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                [
//                                    'label' => 'Level Two',
//                                    'icon' => 'circle-o',
//                                    'url' => '#',
//                                    'items' => [
//                                        ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ];
//        print_r($config);die;
        return parent::widget($config);
    }

    /**
     * 树形结构
     * @param $navs
     * @param int $id
     * @return array
     * Create: 雨鱼
     */
    protected static function getTreeNav($navs, $id = 0)
    {
            $config = [];
            foreach ($navs as $nav) {
                if ($nav->pid == $id) {
                        $children = self::getTreeNav($navs, $nav->id);
                        $temple = [
                            'label' => $nav->text,
                            'icon' => $nav->iconCls,
                            'url' => $nav->url?[$nav->url]:'#',
                        ];
                        if ($children) {
                            $temple['items'] = $children;
                        }
                        $config[] = $temple;

                }
            }
//            $config[] = [
//                'label' => '工具',
//                'icon' => 'share',
//                'url' => '#',
//                'items' => [
//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                    [
//                        'label' => 'Level One',
//                        'icon' => 'circle-o',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                            [
//                                'label' => 'Level Two',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                    ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//            ];
            return $config;
        }
    }