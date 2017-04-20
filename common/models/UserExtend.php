<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "user_extend".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property string $gender
 * @property integer $post_id
 * @property string $type
 * @property string $id_card
 * @property string $tel
 * @property string $nation
 * @property string $marital_status
 * @property string $entry_status
 * @property integer $entry_date
 * @property integer $dismission_date
 * @property string $politics_status
 * @property string $education
 */
class UserExtend extends \yii\db\ActiveRecord
{
    const STATUS_ENTRY = 1;
    const STATUS_LEAVE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_extend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['marital_status', 'entry_status','number', 'gender', 'post_id', 'type', 'id_card', 'tel', 'nation', 'entry_date', 'politics_status', 'education'], 'required'],

            [['post_id', 'tel', 'id_card'], 'integer'],

            [['entry_date'], 'date', 'format' => 'php:Y-m-d'],

            [['type'], 'string', 'max' => 4],
            [['gender'], 'string', 'max' => 1],

            ['id_card', 'string', 'length' => 18],
            ['tel', 'string', 'length' => 11],
            [['tel', 'id_card'], 'unique'],

            [['nation'], 'string', 'max' => 5],
            [['marital_status', 'entry_status', 'politics_status', 'education'], 'string', 'max' => 2],
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
            'number' => '号码',
            'gender' => '性别',
            'post_id' => '职位',
            'type' => '类型',
            'id_card' => '身份证',
            'tel' => '电话',
            'nation' => '国籍',
            'marital_status' => '婚姻',
            'entry_status' => '在职状态',
            'entry_date' => '入职时间',
            'dismission_date' => '离职时间',
            'politics_status' => '政治面貌',
            'education' => '教育',
        ];
    }

    /**
     * @return string
     * Create: 雨鱼
     */
    public function getJobStatus()
    {
        return $this->entry_status == '1'? '在职': '离职';
    }

    /**
     * @return array
     * Create: 雨鱼
     */
    public function getJobSelect()
    {
        return [self::STATUS_ENTRY=> '在职',  self::STATUS_LEAVE=> '离职'];
    }

    /**
     * @param $attributes
     * @return bool Create: 雨鱼
     * Create: 雨鱼
     * @throws Exception
     */
    public function updateInfo($attributes)
    {
        $this->attributes = $attributes;
        if (! $this->save()) {
            throw new Exception($this->errors);
        }

        return true;
    }

    /**
     * @return string
     * Create: 雨鱼
     */
    public function getMaritalStatus()
    {
        return $this->marital_status == 1? '已婚': '未婚';
    }

    /**
     * @param $attributes
     * @return bool
     * @throws Exception
     * Create: 雨鱼
     */
    public function createUserExtend($attributes)
    {
        $this->attributes = $attributes;
        if (!$this->save()) {
             throw new Exception($this->errors);
        }

        return true;
    }

    /**
     * @return array
     * Create: 雨鱼
     */
    public function getGenderSelect()
    {
        return ['男' => '男', '女' => '女'];
    }

    /**
     * @return array
     * Create: 雨鱼
     */
    public function getMaritalSelect()
    {
        return [1 => '已婚', 0 => '未婚'];
    }
}
