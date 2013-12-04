<?php

class IndexController {

    public function index() {
        $view_data['page_title'] = 'Търговска къща - Sorry International';
        if ($_SESSION['is_logged'] && $_SESSION['is_logged'] == true) {
            $view_data['isLogged'] = true;
        } else {
            $view_data['isLogged'] = false;
        }
        include '../models/AuctionModel.php';
        $auction_model = new AuctionModel();
        $view_data['auctions'] = $auction_model->getAuctions();

        View::getInstance()->render('index', $view_data);
    }

    public function bid() {
        if (!$_SESSION['is_logged'] || $_SESSION['is_logged'] !== true) {
            header('Location: ?');
            exit;
        }
        $view_data['page_title'] = 'Наддавай';
        include '../models/AuctionModel.php';
        $auction_model = new AuctionModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $view_data['add_message'] = $auction_model->addPrice($_GET['auction_id'], $_POST['new_price']);
        }
        if ($_GET && $_GET['auction_id']) {
            $view_data['auction'] = $auction_model->loadAuction($_GET['auction_id']);
        }


        View::getInstance()->render('bid', $view_data);
    }

    public function new_auction() {
        if (!$_SESSION['is_logged'] || $_SESSION['is_logged'] !== true) {
            header('Location: ?');
            exit;
        }
        $view_data['page_title'] = 'Нова обява';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include '../models/AuctionModel.php';
            $auction_model = new AuctionModel();
            $result = $auction_model->addAuction($_POST['name'], $_POST['description'], $_POST['date'], $_POST['price']);
            if (!$result['errors']) {
                $view_data['success'] = $result['success'];
            } else {
                $view_data['errors'] = $result['errors'];
            }
        }
        View::getInstance()->render('new_auction', $view_data);
    }

    public function login() {
        $view_data['page_title'] = 'Вход';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include '../models/UserModel.php';
            $user_model = new UserModel();
            $result = $user_model->getUser($_POST['email'], $_POST['pass']);
            if ($result['success'] && $result['data']) {
                $_SESSION['is_logged'] = true;
                $_SESSION['user_data'] = $result['data'];
                header('Location: ?');
                exit;
            } else {
                $view_data['errors'] = $result['error'];
            }
        }
        View::getInstance()->render('login', $view_data);
    }

    public function logout() {
        session_destroy();
        header('Location: ?');
    }

}
