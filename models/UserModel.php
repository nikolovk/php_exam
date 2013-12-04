<?php
include '../system/BaseModel.php';

class UserModel extends BaseModel {

    public function registeruser($email, $pass, $pass2) {
        $email = trim($email);
        $pass = trim($pass);
        $pass2 = trim($pass2);
        //it's better to send errors using exceptions, and try/catch
        $errors = array();
        //corect way to check for valid email in php
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = true;
        }
        if (mb_strlen($pass) < 5) {
            $errors['password_length'] = true;
        }
        if ($pass != $pass2) {
            $errors['password_mach'] = true;
        }

        $query = $this->db_connection->query('SELECT * FROM users WHERE email="' . mysqli_real_escape_string($this->db_connection, $email) . '"');
        if ($query->num_rows > 0) {
            $errors['email_taken'] = true;
        }

        if (count($errors) > 0) {
            return array('success' => false, 'errors' => $errors);
        }

        //we can add user
        //we have to use BCrypt to store password, not just SHA1        
        $this->db_connection->query('INSERT INTO users (email,password,date_registered) '
                . 'VALUES("' . mysqli_real_escape_string($this->db_connection, $email) . '",'
                . '"' . sha1(sha1($pass)) . '",' . time() . ' )');

        return array('success' => true, 'user_id' => $this->db_connection->insert_id);
    }

    public function getUser($email, $pass) {
        $email = trim($email);
        $pass = sha1(sha1(trim($pass)));
        $query = $this->db_connection->query('SELECT * FROM users WHERE email="' .
                mysqli_real_escape_string($this->db_connection, $email) . '" AND password="' . $pass . '"');
        if ($query->num_rows != 1) {
            return array('success' => false, 'error' => 'no_record');
        }
        return array('success' => true, 'data' => $query->fetch_assoc());
    }

}
