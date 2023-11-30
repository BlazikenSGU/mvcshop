<?php

class Category
{
    public function create($data)
    {
        $db = Database::getInstance();

        $arr['category'] = ucwords($data->data);

        if (!preg_match("/^[a-zA-Z]+$/", trim($arr['category']))) {
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
        $db = Database::getInstance();
        return $db->read("select * from categories");
    }

    public function make_table($cats)
    {

        $result = "";
        if (is_array($cats)) {
            foreach ($cats as $cat_row) {
                $result .= "<tr>";

                $result .= '
                        <td><a href="basic_table.html#">' . $cat_row->category . '</a></td>
                        <td><span class="label label-info label-mini">' . $cat_row->disable . '</span></td>
                        <td>
                            <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                        </td>
                        ';

                $result .= "</tr>";
            }
        }
    }
}

?>