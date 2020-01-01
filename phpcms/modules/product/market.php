<?php
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);

class market extends admin {
    private $db, $db_list;
    private $db_functions_list;

    public function __construct() {
        parent::__construct();

        $this->db = pc_base::load_model('productions_market_model');
        $this->db_list = pc_base::load_model('productions_market_list_model');

        $this->db_functions_list = pc_base::load_model('productions_functions_list_model');
    }

    public function init() {
        $page = 0;
        $infos = $this->db_list->listinfo([], '', $page, 100);

        $functions = $this->db_functions_list->listinfo([], '', $page, 100);
        $map_functions = [];
        foreach ($functions as $function) {
            $map_functions[$function['id']] = $function['title'];
        }

        include $this->admin_tpl('market_list');
    }

    public function add() {
        pc_base::load_sys_class('form','',0);
        $id = (int)$_GET['id'];
        $info = [];

        $functions = $this->db_functions_list->listinfo();

        if (isset($_POST['market'])) {
            $id = (int)$_POST['market']['id'];
            unset($_POST['market']['id']);
            $market = $_POST['market'];
            $market['functions'] = implode(',', $market['functions']);

            if ($id > 0) {
                $this->db_list->update($market, ['id' => $id]);

                showmessage('修改成功', '?m=product&c=market&a=init');
            } else {
                $market['created_at'] = time();
                $this->db_list->insert($market, true);
            }
            showmessage('添加成功', '?m=product&c=market&a=init');
        }

        if ($id > 0) {
            $info = $this->db_list->get_one(['id' => $id]);
        }

        include $this->admin_tpl('market_add');
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

        if (isset($_POST['market'])) {
            $id = (int)$_POST['market']['id'];
            unset($_POST['market']['id']);
            $market = $_POST['market'];

            if ($id > 0) {
                $this->db->update($market, ['id' => $id]);
            } else {
                $market['created_at'] = time();

                $this->db->insert($market, true);
            }
            showmessage('市场配置成功', HTTP_REFERER);
        } else {
            $info = $this->db->get_one(['id' => 1]);
        }

        include $this->admin_tpl('market_setting');
    }
}