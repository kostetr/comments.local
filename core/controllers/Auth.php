<?php

namespace core\controllers;

use core\controllers\AbstractController;
use core\models\ModelAuth;
use core\Router;

class Auth extends AbstractController {

    public function __construct() {
        parent::__construct();
        $this->model = new ModelAuth();
        $this->viewer->template = "auth_template.php";
if($_SESSION['login']!==NULL && $_SERVER["REQUEST_URI"]!=='/auth/exit'){
Router::redirect('CP/');
}
    }

    /*
     * Главная страница авторизации
     */

    public function action_index() {
        // Указываем имя файла содержащего контент и отображаем.96
        $this->viewer->content_view = 'auth' . DIRECTORY_SEPARATOR . "auth.php";
        $this->viewer->show();
        //обнуляем переменные с ошибками аунтификаци
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    /*
     * Страница регистрации
     */

    public function action_register() {
        //Делаем выбор с бд gender для отображения в select 
        $this->model->table = 'gender';
        $this->viewer->gender = $this->model->all();
        //Делаем выбор с бд posts для отображения в select 
        $this->model->table = 'posts';
        $this->viewer->posts = $this->model->all();
        // Указываем имя файла содержащего контент и отображаем.
        $this->viewer->content_view = 'auth' . DIRECTORY_SEPARATOR . "register.php";
        $this->viewer->show();
        //обнуляем переменные с ошибками аунтификаци
        $_SESSION['Errors'] = null;
        $_SESSION['message'] = null;
    }

    /*
     * Запись пользователя в БД 
     */

    public function action_adduser() {
        // Записываем в массив значения полей регистрационной формы.
        $user = filter_input_array(INPUT_POST);
        // Валидация массива переменных
        if ($this->user_validate($user)) {
            //проверка на уникальность токена
            do {
                $user['token'] = $this->generateToken();
            } while ($this->model->selectByToken($user['token']));
            //Отправляем письмо Администратору с Токеном для валидации пользователя.

            $message = <<<CONTENT
Фамилия - {$user['surname']}
Имя - {$user['name']}
Отчество - {$user['patronymic']}
Токен - {$user['token']}
http://qqq.zzz.com.ua/verification/?token={$user['token']}
CONTENT;
            $user['snp'] = ucfirst(strtolower($user['surname'])) . " " . ucfirst(mb_substr($user['name'], 0, 1)) . "." . ucfirst(mb_substr($user['patronymic'], 0, 1)) . ".";
            // Дата регистрации пользователя
            $user['registered'] = date('Y-m-d');
            // На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
            // $message = wordwrap($message, 70, "\r\n");
            // Отправляем
            $headers = 'From: admin@qqq.zzz.com.ua' . "\r\n";

            //Шифрование пароля
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            //Запись в массив group_id. Переменная определяет к какой группе будет относиться пользователь (Админ, рут, юзер...) 
            // 1 - root 2 - admin 3 - user .   
            $user['group_id'] = 3;
            //Работа с датой рождения. Меняем формат на Y-m-d            
            $birthday = explode('-', $user['birthday']);
            $user['birthday'] = $birthday[2] . '-' . $birthday[1] . '-' . $birthday[0];
            $user['access_level'] = 200;

            // Меняем таблицу на users и записываем в БД
            $this->model->table = 'users';

            if ($this->model->addUser($user)) {
                $email_to_activate = $this->model->selectEmail()[0]['email'];
                mail($email_to_activate, 'Регистрация пользователя', $message, $headers);
                // Если успешно то в сессии записываем сообщение об успехе и редиректимся на главную страницу Авторизации где будет отображено сообщение.
                $_SESSION['message']['succesRegistr'] = 'Регистрация прошла успешно. Ожидайте активацию учетной записи администратором.';
                Router::redirect('auth/');
            }
        } else {
            
        }

        // Если валидация не пройдена то в сессию записывается массив $user содержащий заполненые поля регистрационной формы.
        //  Чтобы повторно пользователь не заполнял а просто исправил ошибки. И редирект на страницу регистрации 
        $_SESSION['user'] = $user;
        Router::redirect('auth/register');
    }

//Авторизация
    public function action_signin() {
        $user = filter_input_array(INPUT_POST);
        $user_item = $this->model->selectByLogin($user['login']);
        if ($user_item) {
            //Проверка актевинован учетная запись администратором или нет.
            if ($user_item->verified == 2) {
                if (password_verify($user['password'], $user_item->password)) {
                    $_SESSION['id'] = $user_item->id;
                    $_SESSION['login'] = $user_item->login;
                    $_SESSION['surname'] = $user_item->surname;
                    $_SESSION['name'] = $user_item->name;
                    $_SESSION['patronymic'] = $user_item->patronymic;
                    $_SESSION['snp'] = $user_item->snp;
                    $_SESSION['access_level'] = $user_item->access_level;
                    $_SESSION['Errors'] = null;
                    Router::redirect('CP/');
                } else {
                    $_SESSION['Errors']['auth'] = 'Вы ввели неверный пароль!';
                }
            } else {
                if($user_item->verified==1){
                     $_SESSION['Errors']['auth'] = 'Учетная запись заблокирована Администратором!';
                }else{
                    $_SESSION['Errors']['auth'] = 'Ваша учетная запись не активирована Администратором.';
                }
                
            }
        } else {
            $_SESSION['Errors']['auth'] = 'Вы ввели неверный пароль!';
        }
        Router::redirect('auth/');
    }

    /*
     * Валидация регистрационных данных
     */

    private function user_validate(array $user) {
        //Если пароли введены в два поля не одинаковые то в сессию записываем ошибку. 
        //Если одинаковые то null.
        if ($user['password'] !== $user['password_confirm']) {
            $_SESSION['Errors']['registr']['pass'] = 'Пароли не совпадают';
        } else {
            $_SESSION['Errors']['registr']['pass'] = null;
        }
        // Проверка существует ли в БД пользователь с таким же Логином. 
        // Если да то записываем ошибку в сессию. 
        // Если нет то null.
        $user_item = $this->model->selectByLogin($user['login']);
        if ($user_item) {
            $_SESSION['Errors']['registr']['login'] = 'Пользователь с таким логином существует';
        } else {
            $_SESSION['Errors']['registr']['login'] = null;
        }
        // Если одна из переменных массива ошибок будет не равна Null то ретурним False и валидация будет не пройдена.
        if ($_SESSION['Errors']['registr']['pass'] !== null || $_SESSION['Errors']['registr']['login'] !== null) {
            return FALSE;
        } else {
            return true;
        }
    }

    static public function checkValidation() {
        if (empty($_SESSION['login'])) {
            return false;
        }
        return $_SESSION['login'];
    }

    static public function access_level() {
        if ($_SESSION['access_level'] === 100 || $_SESSION['access_level'] === 200) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Генерируем token
    static function generateToken($length = 50) {
        $str = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $numChars = strlen($str);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($str, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

//Выход из сессии
    public function action_exit() {
        if (session_destroy()) {
            Router::redirect('auth/');
        }
    }

}
