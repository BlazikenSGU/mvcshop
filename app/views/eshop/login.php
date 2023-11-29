<?php $this->view("header", $data) ?>

<section id="form"><!--form-->
	<div class="container">
		<div class="row">

			<?php check_error() ?>

			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2>Login to your account</h2>
					<form method="post">
						<input type="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="email" />
						<input type="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" placeholder="password" />
						<span>
							<input type="checkbox" class="checkbox">
							Keep me signed in

						</span>
						<button type="submit" class="btn btn-default">Login</button>
					</form>
					<br>
					<a href="<?= ROOT ?>signup">Bạn chưa có tài khoản ? Đăng ký ngay.</a>
				</div><!--/login form-->
			</div>


		</div>
	</div>
</section><!--/form-->


<?php $this->view("footer", $data) ?>