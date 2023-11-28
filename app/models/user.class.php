<?php
class User
{

    private $error = "";

    public function signup($POST)
    {
        $data = array();
        $db = Database::getInstance();

        $data['name'] = trim($POST["name"]);
        $data['email'] = trim($POST["email"]);
        $data['password'] = trim($POST["password"]);
        $password2 = trim($POST["password2"]);

        if (empty($data['email']) || !preg_match("/^[a-zA-Z_-]+@[a-zA-Z]+.[a-zA-Z]+$/", $data['email'])) {
            $this->error .= "vui long nhap lai email hop le";
        }

        if (empty($data['name']) || !preg_match("/^[a-zA-Z]+$/", $data['name'])) {
            $this->error .= "vui long nhap lai ten hop le";
        }

        if ($data['password'] !== $password2) {
            $this->error .= "password khong trung, vui long nhap lai";
        }

        if (strlen($data['password']) < 6) {
            $this->error .= "password phai dai hon 6 ky tu";
        }

        //check email if it already exist
        $sql = "select * from users where email  = :email limit 1";
        $arr['email'] = $data['email'];
        $check = $db->read($sql, $arr);
        if (is_array($check)) {
            $this->error .= 'email nay da duoc su dung <br>';
        }



        if ($this->error == "") {
            //save data
            $data['rank'] = "customer";
            $data['url_address'] = $this->get_random_string_max(60);
            $data['date'] = date("Y-m-d H:i:s");

            $query = "insert into users (url_address,name,email,password,date,rank) values (:url_address, :name, :email, :password, :date, :rank)";

            $result = $db->write($query, $data);

            if ($result) {
                header("Location: " . ROOT . "login");
                die;
            }
        }


    }
    public function login($POST)
    {

    }

    public function get_user($url)
    {

    }

    private function get_random_string_max($length)
    {
        $array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $text = "";

        $length = rand(4, $length);

        for ($i = 0; $i < $length; $i++) {
            $random = rand(0, 61);
            $text .= $array[$random];
        }

        return $text;
    }


}