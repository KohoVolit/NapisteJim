<?php

require_once SMARTY_DIR . 'Smarty.class.php';

class SmartyNapisteJimCz extends Smarty
{
	public function __construct()
	{
		parent::__construct();

		$this->template_dir = NAPISTEJIM_ROOT . '/smarty/templates';
		$this->compile_dir  = NAPISTEJIM_ROOT . '/smarty/templates_c';
		$this->config_dir   = NAPISTEJIM_ROOT . '/smarty/configs';
		$this->cache_dir    = NAPISTEJIM_ROOT . '/smarty/cache';

//		$this->caching = 2;
	}
}

?>
