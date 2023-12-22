<?php

class Category
{
    public function create($data)
    {
        $db = Database::getInstance();
        $arr['category'] = ucwords($data->data);

        if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['category']))) {
            $_SESSION['error'] = "vui long nhap ten danh muc hop le";
        }

        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "insert into categories (category) values (:category)";
            $check = $db->write($query, $arr);

            if ($check) {
                return true;
            }
        }
        return false;

    }

    public function edit($data)
    {

    }

    public function delete($data)
    {

    }

    public function get_all()
    {
        $db = Database::newInstance();
        return $db->read("select * from categories order by id desc");
    }

    public function make_table($cats)
    {
        $result = "";
        
        if (is_array($cats)) {
            foreach ($cats as $cat_row) {
                //code
                $color = $cat_row->disabled ? "#ae7c04" : "#5bc0de";
                $cat_row->disabled = $cat_row->disabled ? "Disabled" : "Enabled";
                
                $args = $cat_row->id . ",'" . $cat_row->disabled . "'";

                $result .= "<tr>";

                $result .= '
                        <td><a href="basic_table.html#">' . $cat_row->category . '</a></td>
                        <td><span onclick="disable_row(' . $args . ')"  class="label label-info label-mini" style="cursor:pointer; background-color: ' . $color . ';">' . $cat_row->disabled . '</span></td>
                        <td>
                            <button onclick="edit_row(' . $cat_row->id . ')" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                            <button onclick="delete_row(' . $cat_row->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                        </td>
                        ';

                $result .= "</tr>";
            }
        }
        return $result;
    }
}

?>