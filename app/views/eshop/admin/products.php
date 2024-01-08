<?php $this->view("admin/header", $data) ?>
<?php $this->view("admin/sidebar", $data) ?>

<style type="text/css">
    .add_new {
        width: 500px;
        height: 300px;
        background-color: #cecccc;
        position: absolute;
        padding: 6px;
    }

    .edit_product {
        width: 500px;
        height: 300px;
        background-color: #cecccc;
        position: absolute;
        padding: 6px;

    }

    .show {
        display: block;
    }

    .hide {
        display: none;
    }
</style>

<div class="row mt">
    <div class="col-md-12">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4><i class="fa fa-angle-right"></i> San pham </h4>
                <button class="btn btn-primary btn-xs" onclick="show_add_new(event)"><i class="fa fa-plus"></i> Them san pham</button>

                <div class="add_new hide">

                    <h4 class="mb"><i class="fa fa-angle-right"></i> Them San pham</h4>
                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Ten san pham</label>
                            <div class="col-sm-10">
                                <input id="product" name="product" type="text" class="form-control" autofocus>
                            </div>
                        </div>
                        <button class="btn btn-warning" onclick="show_add_new(event)"
                            style="position: absolute; bottom: 20px; left: 20px;">Huy</button>
                        <button class="btn btn-primary" onclick="collect_data(event)"
                            style="position: absolute; bottom: 20px; right: 20px;">Luu</button>
                    </form>
                    <br>
                    <br>

                </div>
                <!-- edit product -->
                <div class="edit_product hide">

                    <h4 class="mb"><i class="fa fa-angle-right"></i> Edit danh muc</h4>
                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Ten danh muc</label>
                            <div class="col-sm-10">
                                <input id="product_edit" name="product" type="text" class="form-control" autofocus>
                            </div>
                        </div>
                        <button class="btn btn-warning" onclick="show_edit_product(0,'', event)"
                            style="position: absolute; bottom: 20px; left: 20px;">Cancel</button>
                        <button class="btn btn-primary" onclick="collect_edit_data(event)"
                            style="position: absolute; bottom: 20px; right: 20px;">Luu</button>
                    </form>
                    <br>
                    <br>

                </div>
                <!-- end edit -->


                <hr>

                <thead>
                    <tr>
                        <th><i class="fa fa-bullhorn"></i> Product</th>
                        <th><i class=" fa fa-edit"></i> Status</th>
                        <th><i class=" fa fa-edit"></i> Action</th>
                    </tr>
                </thead>
                <tbody id="table_body">
                    <?php

                    echo $data['table_rows'];

                    ?>
                </tbody>
            </table>
        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->
</div><!-- /row -->
</section>

<script type="text/javascript">

    var EDIT_ID = 0;

    function show_add_new() {
        var show_edit_box = document.querySelector(".add_new");
        var product_input = document.querySelector("#product");

        if (show_edit_box.classList.contains('hide')) {
            show_edit_box.classList.remove('hide');
            product_input.focus();
        } else {
            show_edit_box.classList.add('hide');
            product_input.value = "";
        }
    }

    function show_edit_product(id, product, e) {

        EDIT_ID = id;
        var show_add_box = document.querySelector(".edit_product");
        // show_add_box.style.left = (e.clientX - 700) + "px";
        show_add_box.style.top = (e.clientY - 140) + "px";

        var product_input = document.querySelector("#product_edit");
        product_input.value = product;

        if (show_add_box.classList.contains('hide')) {
            show_add_box.classList.remove('hide');
            product_input.focus();
        } else {
            show_add_box.classList.add('hide');
            product_input.value = "";
        }
    }

    function collect_data(e) {
        var product_input = document.querySelector("#product");
      
        if (product_input.value.trim() == "" || !isNaN(product_input.value.trim())) {
            alert("vui long nhap du lieu");
        }

        var data = product_input.value.trim();
        send_data({
            data: data,
            data_type: 'add_product'
        });
    }

    function collect_edit_data(e) {
        var product_input = document.querySelector("#product_edit");
        if (product_input.value.trim() == "" || !isNaN(product_input.value.trim())) {
           // alert("vui long nhap du lieu");
        }

        var data = product_input.value.trim();
        send_data({
            id: EDIT_ID,
            product: data,
            data_type: 'edit_product'
        });
    }

    function send_data(data = {}) {

        var ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        })

        ajax.open("POST", "<?= ROOT ?>ajax_product", true);
        ajax.send(JSON.stringify(data));
    }

    function handle_result(result) {

        if (result != "") {
            var obj = JSON.parse(result);

            if (typeof obj.data_type != 'undefined') {

                if (obj.data_type == "add_new") {
                    if (obj.message_type == "info") {
                        alert(obj.message);
                        show_add_new();

                        var table_body = document.querySelector('#table_body');
                        table_body.innerHTML = obj.data;

                    } else {
                        alert(obj.message);
                    }
                } else if (obj.data_type == "edit_product") {

                
                    show_edit_product(0,'', false);

                    var table_body = document.querySelector('#table_body');
                    table_body.innerHTML = obj.data;
                  

                } else if (obj.data_type == "disable_row") {

                    var table_body = document.querySelector('#table_body');
                    table_body.innerHTML = obj.data;

                } else if (obj.data_type == "delete_row") {

                    var table_body = document.querySelector('#table_body');
                    table_body.innerHTML = obj.data;
                    alert(obj.message);

                }

            }
        }
    }

    function edit_row(id) {

        send_data({
            data_type: ""
        });
    }

    function delete_row(id) {

        if (!confirm("ban that su muon xoa dong nay ?")) {
            return;
        }

        send_data({
            data_type: "delete_row",
            id: id
        });
    }

    function disable_row(id, state) {
        send_data({
            data_type: "disable_row",
            id: id,
            current_state: state
        });
    }


</script>

<?php $this->view("admin/footer", $data) ?>