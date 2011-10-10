<?php

require_once SMARTY_DIR . 'Smarty.class.php';

class SmartyWtt extends Smarty
{
	public function __construct()
	{
		parent::__construct();

		$this->template_dir = WTT_DIR . '/smarty/templates';
		$this->compile_dir  = WTT_DIR . '/smarty/templates_c';
		$this->config_dir   = WTT_DIR . '/smarty/configs';
		$this->cache_dir    = WTT_DIR . '/smarty/cache';

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
