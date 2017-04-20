<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => '职位名称不得为空'],
            ['name', 'unique', 'message' => '职位名称已存在'],
            [['name'], 'string', 'max' => 10, 'message' => '职位名称过长'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '职位名称',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * 更新和创建前
     * @param bool $insert
     * @return bool
     * Create: 雨鱼
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
                $this->updated_at = time();
            }else {
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }
}
