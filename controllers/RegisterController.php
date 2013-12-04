<?php

class RegisterController {

    public function __construct() {
        $view_data['page_title'] = 'Регистрация';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include '../models/UserModel.php';
            $user_model = new UserModel();
            $result = $user_model->registeruser($_POST['email'], $_POST['pass'], $_POST['pass2']);
            if ($result['success']) {
                View::getInstance()->render('register_ok', $view_data);
                exit;
            } else {
                $view_data['errors'] = $result['errors'];
            }
        }
        View::getInstance()->render('register', $view_data);
    }

}
