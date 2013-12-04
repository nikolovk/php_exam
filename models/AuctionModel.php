<?php

include '../system/BaseModel.php';

class AuctionModel extends BaseModel {

    public function addAuction($name, $description, $date, $price) {
        $result = $this->isValid($name, $description, $date, $price);
        $success = false;
        if ($result['isValid'] === true) {
            $this->db_connection->query('INSERT INTO `auctions`(`user_id`, `date_created`, `minimum_price`, 
                `date_end`, `action_title`, `auction_desc`) VALUES 
                (' . $_SESSION['user_data']['user_id'] . ',' . strtotime("now") . ',' . $price . ',' . $date
                    . ',"' . $name . '","' . $description . '")');
            if ($this->db_connection->insert_id > 0) {
                $success = 'Обявата е публикувана успешно!';
            }
        }

        return array('success' => $success, 'errors' => $result['errors']);
    }

    private function isValid(&$name, &$description, &$date, &$price) {
        $name = mysqli_real_escape_string($this->db_connection, trim($name));
        $description = mysqli_real_escape_string($this->db_connection, trim($description));
        $date = strtotime($date);
        $price = (int) $price;

        $errors = array();
        if (empty($name) || mb_strlen($name) < 4) {
            $errors['name'] = 'Името трябва да бъде поне 4 символа!';
        }
        if (empty($description) || mb_strlen($description) < 10) {
            $errors['description'] = 'Описанието трябва да бъде поне 10 символа!';
        }
        if ($date == FALSE || $date <= strtotime("now")) {
            $errors['date'] = 'Краят на аукциона не може да бъде в миналото!';
        }
        if ($price <= 0) {
            $errors['price'] = 'Цената трябва да бъде положително число!';
        }
        if (count($errors) > 0) {
            $isValid = false;
        } else {
            $isValid = true;
        }

        return array('isValid' => $isValid, 'errors' => $errors);
    }

    public function getAuctions() {
        $query = $this->db_connection->query('SELECT  `auction_id` ,  `date_end` ,  `action_title` ,  `auction_desc` ,  
            `minimum_price`,`users`.`email` 
                FROM  `auctions` 
                JOIN  `users` ON  `auctions`.`user_id` =  `users`.`user_id` 
                WHERE `auctions`.`date_end` > ' . strtotime("now") . '
                ORDER BY  `date_end`');
        $auctions = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $auctions[] = $row;
        }
        foreach ($auctions as $key =>$auction) {
            $query = $this->db_connection->query('SELECT COALESCE( MAX( price ) , 0 ) AS max_price
                                        FROM  `auction_prices` 
                                        WHERE auction_id =' . (int) $auction['auction_id']);
            if ($row = mysqli_fetch_assoc($query)) {
                if ($row['max_price'] > $auction['minimum_price']){
                    $auctions[$key]['minimum_price'] = $row['max_price'];
                }
            }
        }


        return $auctions;
    }

    public function loadAuction($auction_id) {
        $query = $this->db_connection->query('SELECT a.`auction_id` ,  `action_title` ,  `auction_desc` ,  
                    `minimum_price` ,  `users`.`email` , COALESCE( MAX( ap.price ) , 0 ) AS max_price
                FROM  `auctions` AS a
                JOIN  `users` ON a.`user_id` =  `users`.`user_id` 
                LEFT JOIN auction_prices AS ap ON ap.auction_id = a.`auction_id` 
                WHERE a.`date_end` > ' . strtotime("now") . '
                AND a.`auction_id` = ' . (int) $auction_id);
        while ($row = mysqli_fetch_assoc($query)) {
            $auction = $row;
        }

        return $auction;
    }

    public function addPrice($auctionId, $new_price) {
        $query = $this->db_connection->query('SELECT COALESCE( MAX( price ) , 0 ) AS max_price
                                        FROM  `auction_prices` 
                                        WHERE auction_id =' . (int) $auctionId);
        if ($row = mysqli_fetch_assoc($query)) {
            $max_price = $row['max_price'];
        }
        $new_price = (int) $new_price;
        if ($new_price > $max_price) {
            $query = $this->db_connection->query('INSERT INTO `auction_prices`(`auction_id`, `user_id`, `price`, 
                    `date_added`) VALUES 
                    (' . $auctionId . ',' . $_SESSION['user_data']['user_id'] . ',' . $new_price . ',' . strtotime("now") . ')');
            if ($query) {
                $result = 'Вашата оферта е добавена';
            } else {
                $result = 'Грешка';
            }
        } else {
            $result = 'Цената е по ниска от настоящата';
        }

        return $result;
    }

}
