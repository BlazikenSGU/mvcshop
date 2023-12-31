<?php $this->view("header", $data) ?>

<section id="main-content">
    <section class="wrapper">

        <div style="min-height: 300px;">
            <div class="col-md-4 mb" style="background-color:gray; text-align: center;">
                <!-- WHITE PANEL - TOP USER -->
                <div class="white-panel pn">
                    <div class="white-header">
                        <h5>Tai khoan cua toi</h5>
                    </div>
                    <p><img src="<?= ASSETS . THEME ?>admin/img/ui-zac.jpg" class="img-circle" width="80"></p>
                    <p><b>
                            <?= $data['user_data']->name ?>
                        </b></p>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small mt">MEMBER SINCE</p>
                            <p>
                                <?= date("jS M Y", strtotime($data['user_data']->date)) ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="small mt">TOTAL SPEND</p>
                            <p>$ 47,60</p>
                        </div>
                    </div>
                    <hr style="opacity: 0.3">
                    <div class="row">
                        <div class="col-md-6">
                            <p id="user-text" class="small mt">EDIT</p>
                        </div>

                        <div class="col-md-6">
                            <p id="user-text" class="small mt">DELETE</p>
                        </div>
                    </div>
                </div>
            </div><!-- /col-md-4 -->
        </div>

    </section>
</section>


<?php $this->view("footer", $data) ?>