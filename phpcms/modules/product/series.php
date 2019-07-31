<?php
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);

class series extends admin {
    private $db, $db_list;

    public function __construct() {
        parent::__construct();

        $this->db = pc_base::load_model('productions_series_model');
        $this->db_list = pc_base::load_model('productions_series_list_model');
    }

    public function init() {
        $page = 0;
        $infos = $this->db_list->listinfo([], '', $page, 10);

        include $this->admin_tpl('series_list');
    }

    public function add() {
        pc_base::load_sys_class('form','',0);
        $id = (int)$_GET['id'];
        $info = [];

        if (isset($_POST['series'])) {
            $id = (int)$_POST['series']['id'];
            unset($_POST['series']['id']);
            $series = $_POST['series'];

            if ($id > 0) {
                $this->db_list->update($series, ['id' => $id]);

                showmessage('修改成功', '?m=product&c=series&a=init');
            } else {
                $series['created_at'] = time();
                $this->db_list->insert($series, true);
            }
            showmessage('添加成功', '?m=product&c=series&a=init');
        }

        if ($id > 0) {
            $info = $this->db_list->get_one(['id' => $id]);
        }

        include $this->admin_tpl('series_add');
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

        if (isset($_POST['series'])) {
            $id = (int)$_POST['series']['id'];
            unset($_POST['series']['id']);
            $series = $_POST['series'];

            if ($id > 0) {
                $this->db->update($series, ['id' => $id]);
            } else {
                $series['created_at'] = time();

                $this->db->insert($series, true);
            }
            showmessage('配置成功', HTTP_REFERER);
        } else {
            $info = $this->db->get_one(['id' => 1]);
        }

        include $this->admin_tpl('series_setting');
    }
}