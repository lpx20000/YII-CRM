<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $login_count;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim', 'on' => ['update', 'create']],
            ['username', 'unique', 'targetClass' => 'common\models\User', 'on' => ['update', 'create'], 'message' => '用户名已存在'],
            ['username', 'string', 'min' => 2, 'max' => 200, 'on' => ['update', 'create']],
            ['username', 'required', 'message' => '用户名不得为空', 'on' => ['update', 'create']],

            ['email', 'filter', 'filter' => 'trim', 'on' => ['update', 'create']],
            ['email', 'email', 'message' => '邮箱格式不正确', 'on' => ['update', 'create']],
            ['email', 'required', 'message' => '邮箱不得为空', 'on' => ['update', 'create']],
            ['email', 'string', 'max' => 255, 'on' => ['update', 'create']],
            ['email', 'unique', 'targetClass' => 'common\models\User', 'message' => '邮箱已注册', 'on' => ['update', 'create']],

            ['password_hash', 'required', 'message' => '密码不得为空', 'on' => ['create']],
            ['password_hash', 'string', 'min' => 6, 'message' => '密码长度不少于6位', 'on' => ['create']],

            ['password_repeat', 'required', 'message' => '重复密码不得为空', 'on' => ['create']],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_hash',  'on' => ['create'], 'message' => '两次密码不一致'],

            ['status', 'required', 'message' => '请选择状态', 'on' => ['update', 'create']],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名称',
            'email' => '邮箱',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'login_count' => '登录次数',
            'password_hash' => '密码',
            'password_repeat' => '重输密码',
            'login_ip' => '登录IP',
            'login_time' => '上次登录时间'

        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     * Create: 雨鱼
     */
    public function getUserInfo()
    {
        return $this->hasOne(UserInfo::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * Create: 雨鱼
     */
    public function getUserExtend()
    {
        return $this->hasOne(UserExtend::class, ['user_id' => 'id']);
    }
    
    /**
     * @return string
     * Create: 雨鱼
     */
    public function getStatus0()
    {
        return $this->status == self::STATUS_ACTIVE ? '正常': '冻结';
    }

    /**
     * @return bool|null
     * Create: 雨鱼
     */
    public function createUser($attributes)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->attributes = $attributes['User'];
            $this->setPassword($attributes['User']['password_hash']);
            $this->password_repeat = $this->password_hash;
            $this->generateAuthKey();
            if (!$this->save()) {
                throw new Exception($this->errors);
            }

            $userInfo = new UserInfo();
            $userInfo->user_id = $this->id;
            $userInfo->createUserInfo($attributes['UserInfo']);

            $userExtend = new UserExtend();
            $userExtend->user_id = $this->id;
            $userExtend->createUserExtend($attributes['UserExtend']);

            $transaction->commit();
        }catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }

        return $this->id;

    }

    /**
     * @return array
     * Create: 雨鱼
     */
    public function getStatusSelect()
    {
        return [self::STATUS_ACTIVE => '正常', self::STATUS_DELETED => '冻结'];
    }


    /**
     * @return mixed
     * Create: 雨鱼
     */
    public function getUserPost()
    {

        $postId = UserExtend::find()->where(['user_id' => $this->id])->select('post_id')->one();

        return Post::find()->where(['id' => $postId->post_id])->select('name')->one()->name;
    }

    /**
     * @param $attributes
     * @return bool|User
     * Create: 雨鱼
     */
    public function updateMultiInfo($attributes)
    {

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->updated_at = time();
            $this->attributes = $attributes['User'];
            if (!$this->save()) {
                throw new Exception($this->getErrors());
            }

            $userExtend = UserExtend::findOne(['user_id' => $this->id]);
            $userExtend->updateInfo($attributes['UserExtend']);

            $userInfo = UserInfo::findOne(['user_id' => $this->id]);
            $userInfo->updateInfo($attributes['UserInfo']);

            $transaction->commit();
            return $this;
        }catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}
