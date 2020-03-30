<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class queues_model extends model {
	function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'queues';
		parent::__construct();
	}

	public function getTotalFree() {
		return $this->count('`status` = 0');
	}

	public function getProcessing() {
		return $this->count('`status` = 1') > 0;
	}

	public function markProcessing($id) {
		return $this->update(['status' => 1], 'id = ' . $id);
	}

	public function markFinished($id) {
		return $this->update(['status' => 2], 'id = ' . $id);
	}
}
?>