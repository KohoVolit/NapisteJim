<?php

require_once SMARTY_DIR . 'Smarty.class.php';

class SmartyNapisteJim extends Smarty
{
	public function __construct()
	{
		parent::__construct();

		$this->template_dir = NJ_DIR . '/smarty/templates';
		$this->compile_dir  = NJ_DIR . '/smarty/templates_c';
		$this->config_dir   = NJ_DIR . '/smarty/configs';
		$this->cache_dir    = NJ_DIR . '/smarty/cache';

		$this->clearAllAssign();
	}

	public function clearAllAssign()
	{
		global $locale;

		parent::clearAllAssign();
		$this->assign('locale', $locale);
	}
}

?>
