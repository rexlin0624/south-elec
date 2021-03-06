<?php
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);

class functions extends admin {
    private $db, $db_list, $db_market, $db_series;

    public function __construct() {
        parent::__construct();

        $this->db = pc_base::load_model('productions_functions_model');
        $this->db_list = pc_base::load_model('productions_functions_list_model');

        $this->db_market = pc_base::load_model('productions_market_list_model');
        $this->db_series = pc_base::load_model('productions_series_list_model');
    }

    public function init() {
        $page = 0;
        $infos = $this->db_list->listinfo([], 'id DESC', $page, 10);

        include $this->admin_tpl('functions_list');
    }

    public function add() {
        pc_base::load_sys_class('form','',0);
        $id = (int)$_GET['id'];
        $info = [];

        if (isset($_POST['functions'])) {
            $id = (int)$_POST['functions']['id'];
            unset($_POST['functions']['id']);
            $functions = $_POST['functions'];

            if ($id > 0) {
                $this->db_list->update($functions, ['id' => $id]);

                showmessage('修改成功', '?m=product&c=functions&a=init');
            } else {
                $functions['created_at'] = time();
                $this->db_list->insert($functions, true);
            }
            showmessage('添加成功', '?m=product&c=functions&a=init');
        } else {
            $markets = $this->db_market->listinfo([], '', 1, 10);
            $series = $this->db_series->listinfo([], '', 1, 10);
        }

        if ($id > 0) {
            $info = $this->db_list->get_one(['id' => $id]);
        }

        include $this->admin_tpl('functions_add');
    }

    public function delete()
    {
        $id = (int)$_GET['id'];
        if (!$id) {
            showmessage('参数错误', HTTP_REFERER);
        }

        $this->db_list->delete(['id' => $id]);
        showmessage('删除成功', HTTP_REFERER);
    }

    public function setting() {
        pc_base::load_sys_class('form','',0);

        if (isset($_POST['functions'])) {
            $id = (int)$_POST['functions']['id'];
            unset($_POST['functions']['id']);
            $functions = $_POST['functions'];

            if ($id > 0) {
                $this->db->update($functions, ['id' => $id]);
            } else {
                $functions['created_at'] = time();

                $this->db->insert($functions, true);
            }
            showmessage('配置成功', HTTP_REFERER);
        } else {
            $info = $this->db->get_one(['id' => 1]);
        }

        include $this->admin_tpl('functions_setting');
    }
}