<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $health
 * @property string $specialty
 * @property string $registered
 * @property string $registered_address
 * @property string $graduate_date
 * @property string $graduate_colleages
 * @property string $intro
 * @property string $details
 * @property integer $login_time
 * @property integer $login_ip
 * @property integer $login_count
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'graduate_date', 'health', 'specialty', 'registered', 'graduate_colleages', 'registered_address', 'intro', 'graduate_date', 'details'], 'required'],
            [['user_id', 'login_count'], 'integer'],

            ['health', 'string', 'max' => 30],

            [['specialty', 'graduate_colleages'], 'string', 'max' => 20],

            [['specialty', 'graduate_colleages', 'health'], 'filter', 'filter' => 'trim'],

            [['registered', 'graduate_date'], 'date', 'format' => 'php:Y-m-d'],

            [['details'], 'string'],


            [['registered_address'], 'string', 'max' => 50],
            [['intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'login_time' => '登录时间',
            'login_ip' => '登录IP',
            'login_count' => '登录次数',
            'health' => '健康状况',
            'specialty' => '专业',
            'registered' => '注册时间',
            'registered_address' => '注册地址',
            'graduate_date' => '毕业时间',
            'graduate_colleages' => '毕业学校',
            'intro' => '简介',
            'details' => '详情',
        ];
    }

    /**
     * @param $attributes
     * @return bool|null Create: 雨鱼
     * Create: 雨鱼
     * @throws Exception
     * @internal param $id
     */
    public function createUserInfo($attributes)
    {
        $this->attributes = $attributes;
        $this->login_time = time();
        $this->login_ip = '127.0.0.1';
        $this->login_count = 1;
        if (!$this->save()) {
                throw new Exception($this->errors);
        }
        return true;
    }

    /**
     * @param $attributes
     * @return bool
     * @throws Exception
     * Create: 雨鱼
     */
    public function updateInfo($attributes)
    {
            $this->attributes = $attributes;
            if (! $this->save()) {
                throw new Exception($this->errors);
            }
        return true;
    }
}
