<?php


namespace app\models;
use Yii;
use app\models\User;
use yii\base\Model;


class SignupForm extends Model
{
    public $login;
    public $password;
    public $email;

    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required'],
            ['login', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Пользователь уже существует.'],
            ['login', 'string', 'min' => 5, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'Пользователь с таким email уже существует.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 255],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() && $this->sendEmail($user);


    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom(['testishop2@ukr.net' => 'Письмо с сайта'])
            ->setTo($this->email)
            ->setSubject('Account registration at ')
            ->send();
    }


}