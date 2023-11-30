<?php
class User
{

    private $error = "";

    public function signup($POST)
    {
        $data = array();
        $db = Database::getInstance();

        $data['name'] = trim($POST['name']);
        $data['email'] = trim($POST['email']);
        $data['password'] = trim($POST['password']);
        $password2 = trim($POST['password2']);

        if (empty($data['email']) || !preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $data['email'])) {
            $this->error .= "vui long nhap lai email hop le <br>";
        }

        if (empty($data['name']) || !preg_match("/^[a-zA-Z]+$/", $data['name'])) {
            $this->error .= "vui long nhap lai ten hop le <br>";
        }

        if ($data['password'] !== $password2) {
            $this->error .= "password khong trung, vui long nhap lai <br>";
        }

        if (strlen($data['password']) < 6) {
            $this->error .= "password phai dai hon 6 ky tu <br>";
        }

        //check email if it already exist
        $sql = "select * from users where email  = :email limit 1";
        $arr['email'] = $data['email'];
        $check = $db->read($sql, $arr);

        if (is_array($check)) {
            $this->error .= 'email nay da duoc su dung <br>';
        }


        //check for url
        $data['url_address'] = $this->get_random_string_max(60);
        $arr = false;
        $sql = "select * from users where url_address = :url_address limit 1 ";
        $arr['url_address'] = $data['url_address'];
        $check = $db->read($sql, $arr);
        if (is_array($check)) {
            $data['url_address'] = $this->get_random_string_max(60);
        }


        if (empty($this->error)) {
            //save data
            $data['rank'] = "customer";
            $data['date'] = date("Y-m-d H:i:s");
            $data['password'] = hash('sha1', $data['password']);
            $query = "insert into users (url_address,name,email,password,date,rank) values (:url_address, :name, :email, :password, :date, :rank)";

            $result = $db->write($query, $data);

            if ($result) {
                header("Location: " . ROOT . "login");
                die;
            }
        }
        $_SESSION['error'] = $this->error;
    }

    public function login($POST)
    {
        $data = array();
        $db = Database::getInstance();

        $data['email'] = trim($POST['email']);
        $data['password'] = trim($POST['password']);

        if (empty($data['email']) || !preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $data['email'])) {
            $this->error .= "vui long nhap lai email hop le <br>";
        }

        if (strlen($data['password']) < 6) {
            $this->error .= "password phai dai hon 6 ky tu <br>";
        }

        if (empty($this->error)) {
            //confirm and login to page home
            $data['password'] = hash('sha1', $data['password']);

            $sql = "select * from users where email  = :email and password = :password limit 1";
            $result = $db->read($sql, $data);
            if (is_array($result)) {

                $_SESSION['user_url'] = $result[0]->url_address;
                header("Location: " . ROOT . "home");
                die;
            }

            $this->error .= "sai tai khoan hoac mat khau! <br>";

        }

        $_SESSION['error'] = $this->error;
    }

    public function get_user($url)
    {

    }

    private function get_random_string_max($length)
    {
        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", 'A');
        $text = "";

        $length = rand(4, $length);

        for ($i = 0; $i < $length; $i++) {
            $random = rand(0, count($array) - 1);
            $text .= $array[$random];
        }

        return $text;
    }

    public function check_login($redirect = false, $allowed = array())
    {

        $db = Database::getInstance();

        if (count($allowed) > 0) {
            $arr['url'] = $_SESSION['user_url'];
            $query = "select * from users where url_address = :url limit 1";
            $result = $db->read($query, $arr);
            if (is_array($result)) {
                $result = $result[0];
                if (in_array($result->rank, $allowed)) {
                    return $result;
                }

            }
            header("Location: " . ROOT . "login");
            die;


        } else {
            if (isset($_SESSION["user_url"])) {
                $arr = false;
                $arr['url'] = $_SESSION['user_url'];
                $query = "select * from users where url_address = :url limit 1";


                $result = $db->read($query, $arr);
                if (is_array($result)) {
                    return $result[0];
                }
            }

            if ($redirect) {
                header("Location: " . ROOT . "login");
                die;
            }
        }

        return false;
    }

    public function logout()
    {
        if (isset($_SESSION["user_url"])) {
            unset($_SESSION["user_url"]);
        }

        header("Location: " . ROOT . "home");
        die;
    }

}