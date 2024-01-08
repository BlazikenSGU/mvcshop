<?php

class Product
{
    public function create($data)
    {
        $db = Database::newInstance();
        $arr['description'] = ucwords($data->data);



        if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['description']))) {
            $_SESSION['error'] = "vui long nhap mo ta danh cho san pham";
        }



        if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            $query = "insert into products (description) values (:description)";
            $check = $db->write($query, $arr);



            if ($check) {
                return true;
            }
        }
        return false;

    }

    public function edit($id, $description)
    {
        $db = Database::newInstance();
        $arr['id'] = $id;
        $arr['description'] = $description;
        $query = "update products set description = :description where id = :id limit 1";
        return $db->write($query, $arr);
    }

    public function delete($id)
    {
        $db = Database::newInstance();
        $id = (int) $id;
        $query = "delete from products where id = '$id' limit 1";
        return $db->write($query);
    }

    public function get_all()
    {
        $db = Database::newInstance();
        return $db->read("select * from products order by id desc");
    }

    public function make_table($cats)
    {
        $result = "";

        if (is_array($cats)) {
            foreach ($cats as $cat_row) {
                //code
                // $color = $cat_row->disabled ? "#ae7c04" : "#5bc0de";
                // $cat_row->disabled = $cat_row->disabled ? "Disabled" : "Enabled";

                // $args = $cat_row->id . ",'" . $cat_row->disabled . "'";
                $edit_args = $cat_row->id . ",'" . $cat_row->description . "'";

                $result .= "<tr>";

                $result .= '
                        <td><a href="basic_table.html#">' . $cat_row->description . '</a></td>
                       <td></td>
                        <td>
                            <button onclick="show_edit_description(' . $edit_args . ',event)" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
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