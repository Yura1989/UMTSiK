<!-- start: page -->
<section class="body-sign">
    <div class="center-sign">
        <?php if (isset($login)) { ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong><?php print_r ($login); ?></strong>
            </div>
        <?php } ?>

        <a href="/" class="logo pull-left">
            <img src="<?=base_url();?>assets/vendor/images/logo.png" height="54" alt="Porto Admin" />
        </a>
        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right">
                <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i>Авторизация</h2>
            </div>
            <div class="panel-body">
                <form action="<?=base_url();?>" method="post">
                    <div class="form-group mb-lg">
                        <label>Имя пользователя</label>
                        <div class="input-group input-group-icon">
                            <input required name="username" type="text" class="form-control input-lg" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
                        </div>
                    </div>

                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label class="pull-left">Пароль</label>
<!--                            <a href="#" class="pull-right">Забыли пароль?</a>-->
                        </div>
                        <div class="input-group input-group-icon">
                            <input required name="password" type="password" class="form-control input-lg" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="submit" class="btn btn-primary hidden-xs">Войти</button>
                            <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Войти</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end: page -->