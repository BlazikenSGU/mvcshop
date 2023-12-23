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

    .edit_category {
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
                <h4><i class="fa fa-angle-right"></i> Danh muc san pham </h4>
                <button class="btn btn-primary btn-xs" onclick="show_add_new(event)"><i class="fa fa-plus"></i> Them
                    danh muc</button>

                <div class="add_new hide">

                    <h4 class="mb"><i class="fa fa-angle-right"></i> Them danh muc</h4>
                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Ten danh muc</label>
                            <div class="col-sm-10">
                                <input id="category" name="category" type="text" class="form-control" autofocus>
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
                <!-- edit category -->
                <div class="edit_category hide">

                    <h4 class="mb"><i class="fa fa-angle-right"></i> Edit danh muc</h4>
                    <form class="form-horizontal style-form" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">Ten danh muc</label>
                            <div class="col-sm-10">
                                <input id="category_edit" name="category" type="text" class="form-control" autofocus>
                            </div>
                        </div>
                        <button class="btn btn-warning" onclick="show_edit_category(0,'', event)"
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
                        <th><i class="fa fa-bullhorn"></i> Category</th>
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
        var category_input = document.querySelector("#category");

        if (show_edit_box.classList.contains('hide')) {
            show_edit_box.classList.remove('hide');
            category_input.focus();
        } else {
            show_edit_box.classList.add('hide');
            category_input.value = "";
        }
    }

    function show_edit_category(id, category, e) {

        EDIT_ID = id;
        var show_add_box = document.querySelector(".edit_category");
        // show_add_box.style.left = (e.clientX - 700) + "px";
        show_add_box.style.top = (e.clientY - 140) + "px";

        var category_input = document.querySelector("#category_edit");
        category_input.value = category;

        if (show_add_box.classList.contains('hide')) {
            show_add_box.classList.remove('hide');
            category_input.focus();
        } else {
            show_add_box.classList.add('hide');
            category_input.value = "";
        }
    }

    function collect_data(e) {
        var category_input = document.querySelector("#category");
      
        if (category_input.value.trim() == "" || !isNaN(category_input.value.trim())) {
            // alert("vui long nhap du lieu");
        }

        var data = category_input.value.trim();
        send_data({
            data: data,
            data_type: 'add_category'
        });
    }

    function collect_edit_data(e) {
        var category_input = document.querySelector("#category_edit");
        if (category_input.value.trim() == "" || !isNaN(category_input.value.trim())) {
           // alert("vui long nhap du lieu");
        }

        var data = category_input.value.trim();
        send_data({
            id: EDIT_ID,
            category: data,
            data_type: 'edit_category'
        });
    }

    function send_data(data = {}) {

        var ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function () {
            if (ajax.readyState == 4 && ajax.status == 200) {
                handle_result(ajax.responseText);
            }
        })

        ajax.open("POST", "<?= ROOT ?>ajax", true);
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
                } else if (obj.data_type == "edit_category") {

                
                    show_edit_category(0,'', false);

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