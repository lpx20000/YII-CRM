<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nav".
 *
 * @property integer $id
 * @property string $text
 * @property string $url
 * @property string $iconCls
 * @property integer $pid
 * @property integer $created_at
 * @property integer $updated_at
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nav';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'url', 'iconCls', 'created_at', 'updated_at'], 'required'],
            [['pid', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string', 'max' => 10],
            [['url', 'iconCls'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'url' => 'Url',
            'iconCls' => 'Icon Cls',
            'pid' => 'Pid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
