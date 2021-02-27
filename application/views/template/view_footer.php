

        <aside id="sidebar-right" class="sidebar-right">
            <div class="nano">
                <div class="nano-content">
            <!--        <a href="#" class="mobile-close visible-xs">-->
            <!--            Collapse <i class="fa fa-chevron-right"></i>-->
            <!--        </a>-->
                    <div class="sidebar-right-wrapper">

                        <div class="sidebar-widget widget-calendar">
                            <h6>Календарь</h6>
                            <div data-plugin-datepicker data-plugin-skin="dark" ></div>

                            <ul>
                                <li>
                                    <time datetime="<?php echo(date('d-F-Y, H:i:s')); ?>"><?php echo(date('d-F-Y, H:i:s')); ?></time>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>

        <div class="panel-footer-content panel-footer-btn-group">
                <div class="col-md-12 text-muted  text-right">
                    <small >Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?> Version 1.0.0</small>
                       <small >&copy; УМТСиК г.Югорск <?php echo date("Y"); ?> г.</small>
                    </br>
                </div>
        </div>


<!--Модальное окно, при удалении позиции-->
<div id="dialog" class="modal-block mfp-hide">
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Удалить</h2>
        </header>
        <div class="panel-body">
            <div class="modal-wrapper">
                <div class="modal-text">
                    <p>Вы уверенны что хотите удалить эту позицию?</p>
                </div>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="dialogConfirm" class="btn btn-primary">Да</button>
                    <button id="dialogCancel" class="btn btn-default">Отмена</button>
                </div>
            </div>
        </footer>
    </section>
</div>

<script src="<?=base_url();?>assets/vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?=base_url();?>assets/vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?=base_url();?>assets/vendor/magnific-popup/magnific-popup.js"></script>
<script src="<?=base_url();?>assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="<?=base_url();?>assets/vendor/jquery-validation/jquery.validate.js"></script>
<!--<script src="--><?//=base_url();?><!--assets/javascripts/forms/examples.validation.js"></script>-->

<!-- Theme Base, Components and Settings -->
<script src="<?=base_url();?>assets/vendor/javascripts/theme.js"></script>

<!-- Theme Initialization Files -->
<script src="<?=base_url();?>assets/vendor/javascripts/theme.init.js"></script>

</body>
</html>