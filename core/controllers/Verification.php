<?php

namespace core\controllers;

use core\controllers\AbstractController;
use core\models\VerificationModel;
use core\Router;

class Verification extends AbstractController {

    public function __construct() {
        parent::__construct();
        $this->model = new VerificationModel();
        $this->viewer->template = "auth_template.php";
    }

    public function action_index() {
        $this->viewer->content_view = 'auth' . DIRECTORY_SEPARATOR . "verification_view.php";
        $this->viewer->show();
    }

    public function action_add() {
        $token = filter_input_array(INPUT_POST)["token"];
        $this->model->table = 'users';
        $user = $this->model->selectByToken($token);
        if ($user !== NULL) {
            if ($this->model->updateVerified($user->id)) {
                $_SESSION['message']['succesRegistr'] = 'Пользователь подтвержден! И имеет доступ к закрытому ресурсу!';
                Router::redirect('auth/');
            }
        }
    }


}
