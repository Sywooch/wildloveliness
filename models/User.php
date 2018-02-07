<?php

namespace app\models;

use app\helpers\DevHelper;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\Assignment;
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

    public $role;

    public function attributeLabels()
    {
        return [
            'status' => Yii::t('forms', 'Status'),
            'role' => Yii::t('forms', 'Role'),
        ];
    }

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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['role'], 'string', 'max' => 50],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('forms', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 70],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('forms', 'This email address has already been taken.')],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $auth = Yii::$app->authManager;
            $newRole = $this->defineNewRole($auth);
            $auth->assign($newRole, $this->id);

            return true;
        } else {
            return false;
        }
    }

    protected function defineNewRole($auth){
        if($this->getAssignments()) {
            // удаляем все роли у юзера
            $auth->revokeAll($this->id);
        }
        // get new RoleName from form
        if($this->role)
            $newRole = $auth->getRole($this->role);
        else
            $newRole = $auth->getRole('user');

        return $newRole;
    }

    protected function getAssignments(){
        return Yii::$app->authManager->getAssignments($this->id);
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

    //-------------------------------------- password reset ------------------------------------------------------------

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

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }





    /**
     * Finds all user statuses
     *
     * @return array
     */
    public function getAllStatuses(){
        return [self::STATUS_DELETED => 'Удален', self::STATUS_ACTIVE => 'Активен'];
    }


    //------------------------------------ check user roles ------------------------------------------------------------

    // проверка на наличие ролей (пользователь - не гость(зарегистрированный) может обязательно будет иметь роль "гость", а также может иметь другие)
    public function isRegistereduser(){
        return reset(Yii::$app->authManager->getRolesByUser($this->id))->name == 'guest';
    }

    public function isManager(){
        return reset(Yii::$app->authManager->getRolesByUser($this->id))->name == 'manager';
    }

    public function isAdmin(){
        return reset(Yii::$app->authManager->getRolesByUser($this->id))->name == 'admin';
    }

    public function getUserPermissions($userId){
        $userId = $userId ? $userId : Yii::$app->user->id;
        $permissions = Yii::$app->authManager->getPermissionsByUser($userId);

        return $permissions;
    }



}