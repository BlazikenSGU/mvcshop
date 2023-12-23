<?php
class Admin extends Controller
{
    public function index()
    {
        $User = $this->load_model("User");
        $user_data = $User->check_login(true, ["admin"]);

        if (is_object($user_data)) {
            $data["user_data"] = $user_data;
        }

        $data["page_title"] = "Admin";
        $this->view("admin/index", $data);
    }


    public function categories()
    {
        $User = $this->load_model('User');
        $user_data = $User->check_login(true, ["admin"]);
        if (is_object($user_data)) {
            $data['user_data'] = $user_data;
        }

        //show danh muc category
        $db = Database::newInstance();
        $categories = $db->read("select * from categories order by id desc");

        $category = $this->load_model("Category");
        $table_rows = $category->make_table($categories);

        if (is_array($categories)) {
            $data["table_rows"] = $table_rows;
        }

        $data["page_title"] = "Admin";
        $this->view("admin/categories", $data);
    }

    public function products()
    {
        $User = $this->load_model('User');
        $user_data = $User->check_login(true, ["admin"]);
        if (is_object($user_data)) {
            $data['user_data'] = $user_data;
        }

        //show danh muc category
        $db = Database::newInstance();
        $products = $db->read("select * from products order by id desc");

        $product = $this->load_model("Product");
        $table_rows = $this->make_table($products);

        if (is_array($products)) {
            $data["table_rows"] = $table_rows;
        }

        $data["page_title"] = "Admin";
        $this->view("admin/products", $data);
    }

    private function make_table($cats)
    {
        $result = "";

        if (is_array($cats)) {
            foreach ($cats as $cat_row) {
                //code
                $color = $cat_row->disabled ? "#ae7c04" : "#5bc0de";
                $cat_row->disabled = $cat_row->disabled ? "Disabled" : "Enabled";

                $args = $cat_row->id . ",'" . $cat_row->disabled . "'";
                $edit_args = $cat_row->id . ",'" . $cat_row->category . "'";

                $result .= "<tr>";

                $result .= '
                        <td><a href="basic_table.html#">' . $cat_row->category . '</a></td>
                        <td><span onclick="disable_row(' . $args . ')"  class="label label-info label-mini" style="cursor:pointer; background-color: ' . $color . ';">' . $cat_row->disabled . '</span></td>
                        <td>
                            <button onclick="show_edit_category(' . $edit_args . ',event)" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
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