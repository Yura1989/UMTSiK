<body>

<section class="body">

    <!-- start: header -->
    <header class="header">
        <div class="logo-container">
            <a href="<?=base_url();?>main/main_page" class="logo">
                <img src="<?=base_url();?>assets/vendor/images/logo.png" height="35" />
            </a>
            <?php
            $_username = $this->session->userdata('username');
            $_actions = $this->session->userdata('actions');
            if (isset ($_username) && (($_actions['admin']) == 1) ) { ?>
            <a href="<?=base_url();?>it" class="logo">
                <img src="<?=base_url();?>assets/vendor/images/logo_it.png" height="35" />
            </a>
            <?php } ?>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <!-- start: search & user box -->
        <div class="header-right">
            <span class="separator"></span>
            <div id="userbox" class="userbox">
                <a href="#" data-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="<?=base_url();?>assets/vendor/images/!logged-user.jpg" alt="Admin" class="img-circle" data-lock-picture="<?=base_url();?>assets/vendor/images/!logged-user.jpg" />
                    </figure>
                    <div class="profile-info" data-lock-name="Admin" data-lock-email="Admin@Admin.com">
                        <span class="name"><?php echo $this->session->userdata('sername');?> <?php echo $this->session->userdata('name'); ?></span>
                        <span class="role"><?php echo $this->session->userdata('position'); ?></span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>

                <div class="dropdown-menu">
                    <ul class="list-unstyled">
                        <li class="divider"></li>
                        <li>
                            <a role="menuitem" tabindex="-1" href="<?=base_url();?>main/exit_session"><i class="fa fa-power-off"></i>Выйти из системы</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end: search & user box -->
    </header>
    <!-- end: header -->

    <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left">

            <div class="sidebar-header">
                <div class="sidebar-title">
                    Навигация
                </div>
                <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                    <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>

            <div class="nano">
                <div class="nano-content">
                    <nav id="menu" class="nav-main" role="navigation">
                        <ul class="nav nav-main">
                            <li>
                                <a href="<?=base_url();?>main/main_page">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>Главная</span>
                                </a>
                            </li>
                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                    <span>Распоряжения</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php

                                    if (isset ($_username) && (($_actions['edit_order']) == 1)) { ?>
                                        <li>
                                            <a href="<?=base_url();?>Main/create_edit_order">Создать Распоряжение</a>
                                        </li>
                                    <?php } ?>
                                    <?php if (isset ($_username) && ((($_actions['edit_order']) == 1) || (($_actions['show_order']) == 1) || (($_actions['show_all_orders']) == 1)) ) { ?>
                                        <li>
                                            <a href="<?=base_url();?>Main/range_date_orders">Просмотр Распоряжений</a>
                                        </li>
                                    <?php } ?>
                                    <?php if (isset ($_username) && (($_actions['print_orders']) == 1) ) { ?>
                                        <li>
                                            <a href="<?=base_url();?>Main/print_orders">Печать Распоряжений</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php if (isset ($_username) && ((($_actions['edit_motion']) == 1) || (($_actions['show_motion']) == 1) || (($_actions['show_all_motions']) == 1)) ) { ?>
                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                                    <span>Информация о движении МТР</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?php if (isset ($_username) && ((($_actions['edit_motion']) == 1) || (($_actions['delete_motion']) == 1)) ) { ?>
                                        <li>
                                            <a href="<?=base_url();?>Main/create_motion">Формирование информации о движении МТР</a>
                                        </li>
                                    <?php } ?>
                                    <?php if (isset ($_username) && (($_actions['filial_edit_motion']) == 1) ) { ?>
                                        <li>
                                            <a href="<?=base_url();?>Main/show_edit_filial_motion">Для участков информация о движении МТР</a>
                                        </li>
                                    <?php } ?>
                                    <?php if (isset ($_username) && (($_actions['show_motion']) == 1) ) { ?>
                                    <li>
                                        <a href="<?=base_url();?>Main/show_motion">Просмотр информация о движении МТР</a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                                <li class="nav-parent">
                                    <a>
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                        <span>Отчеты</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <?php if (isset ($_username)) { ?>
                                            <li>
                                                <a href="<?=base_url();?>Main/reports">Отчеты по распоряжениям</a>
                                            </li>
                                            <li>
                                                <a href="<?=base_url();?>Main/report_motions">Поиск информация о распоряжениях</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php if (isset ($_username) && ((($_actions['admin']) == 1) || (($_actions['edit_datas']) == 1)) ) { ?>
                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-cube" aria-hidden="true"></i>
                                    <span>Справочники</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="<?=base_url();?>main/sklads">Склады</a>
                                    </li>
                                </ul>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="<?=base_url();?>main/objects">Объекты</a>
                                    </li>
                                </ul>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="<?=base_url();?>main/filials">Участки</a>
                                    </li>
                                </ul>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="<?=base_url();?>main/lpu">Филиалы</a>
                                    </li>
                                </ul>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="<?=base_url();?>main/delivery_modes">Режим доставки</a>
                                    </li>
                                </ul>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="<?=base_url();?>main/measures">Единици измерения</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-parent">
                                <a>
                                    <i class="fa fa-wrench" aria-hidden="true"></i>
                                    <span>Параметры</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li>
                                        <a href="<?=base_url();?>main/showUsers">Пользователи</a>
                                    </li>
                                    <li>
                                        <a href="<?=base_url();?>main/departments">Отделы(группы)</a>
                                    </li>
                                </ul>
                            </li>

                                <li>
                                    <a href="<?=base_url();?>main/manual">
                                        <i class="fa fa-mortar-board" aria-hidden="true"></i>
                                        <span>Инструкции</span>
                                    </a>
                                </li>

                            <li>
                                <a href="<?=base_url();?>">
                                    <i class="fa fa-database" aria-hidden="true"></i>
                                    <span>Логи</span>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </aside>
        <!-- end: sidebar -->