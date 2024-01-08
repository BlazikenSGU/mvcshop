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
        $data["table_rows"] = $table_rows;


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
        $table_rows = $product->make_table($products);
        $data["table_rows"] = $table_rows;


        $data["page_title"] = "Admin";
        $this->view("admin/products", $data);
    }

}
?>