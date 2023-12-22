<?php
class Ajax extends Controller
{
    public function index()
    {

        $data = file_get_contents("php://input");
        $data = json_decode($data);

        if (is_object($data) && isset($data->data_type)) {

            $DB = Database::getInstance();
            $category = $this->load_model('Category');

            if ($data->data_type == 'add_category') {

                //add new category
                $check = $category->create($data);

                if ($_SESSION['error'] != "") {

                    $arr['message'] = $_SESSION['error'];
                    $_SESSION['error'] = "";
                    $arr['message_type'] = "error";
                    $arr['data'] = "";
                    $arr['data_type'] = "add_new";

                    echo json_encode($arr);
                } else {

                    $arr['message'] = "them thanh cong";
                    $arr['message_type'] = "info";
                    $cats = $category->get_all();
                    $arr['data'] = $category->make_table($cats);
                    $arr['data_type'] = "add_new";

                    echo json_encode($arr);
                }
            } else if ($data->data_type == 'disable_row') {

                $disabled = ($data->current_state == "Enabled") ? 1 : 0;
                $id = $data->id;
                $query = "update categories set disabled = '$disabled' where id = '$id' limit 1";
                $DB->write($query);

                $arr['message'] = "";
                $_SESSION['error'] = "";
                $arr['message_type'] = "info";

                $cats = $category->get_all();
                $arr['data'] = $category->make_table($cats);

                $arr['data_type'] = "disable_row";

                echo json_encode($arr);

            } else if ($data->data_type == 'delete_row') {

                $arr['message'] = "Xoa thanh cong";
                $_SESSION['error'] = "";
                $arr['message_type'] = "info";
                $arr['data'] = "";
                $arr['data_type'] = "delete_row";

                echo json_encode($arr);
            }
        }

    }
}
?>