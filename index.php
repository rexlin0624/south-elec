<?php
/**
 *  index.php PHPCMS 入口
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */
 //PHPCMS根目录

define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
$_GET['siteid'] = (!isset($_GET['siteid']) || empty($_GET['siteid'])) ? 3 : (int)$_GET['siteid'];


include PHPCMS_PATH.'/phpcms/base.php';

pc_base::creat_app();

?>
