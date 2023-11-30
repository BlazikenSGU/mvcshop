<?php
class Ajax extends Controller
{
    public function index()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);

        if (is_object($data)) {
            if ($data->data_type == "add_category") {
                $category = $this->load_model("Category");
                $check = $category->create($data);

                if ($_SESSION['error'] != "") {
                    $arr['message'] = $_SESSION['error'];
                    $_SESSION['error'] = "";
                    $arr['message_type'] = "error";
                   

                    $cats = $category->get_all();
                    $arr['data'] = $this->make_table($cats);

                  

                    echo json_encode($arr);
                } else {
                    $arr['message'] = "them danh muc thanh cong";
                    $arr['message_type'] = "info";
                    $arr['data'] = "";

                    echo json_encode($arr);
                }
            }
        }

    }
}
?>