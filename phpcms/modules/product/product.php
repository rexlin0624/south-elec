<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);

class product extends admin {
    public function __construct() {
        parent::__construct();
    }

    public function config_list() {
        include $this->admin_tpl('product_list');
    }

    public function add() {
        pc_base::load_sys_class('form','',0);

        include $this->admin_tpl('product_add');
    }
}