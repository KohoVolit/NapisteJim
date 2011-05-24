<?php

require_once SMARTY_DIR . 'Smarty.class.php';

class SmartyNapisteJimCz extends Smarty
{
	public function __construct()
	{
		parent::__construct();

		$this->template_dir = WTT_DIR . '/smarty/templates';
		$this->compile_dir  = WTT_DIR . '/smarty/templates_c';
		$this->config_dir   = WTT_DIR . '/smarty/configs';
		$this->cache_dir    = WTT_DIR . '/smarty/cache';

//		$this->caching = 2;

		$this->clearAllAssign();
	}
	
	public function clearAllAssign()
	{
		parent::clearAllAssign();
		$this->assign('locale', LOCALE);
	}
}

?>
