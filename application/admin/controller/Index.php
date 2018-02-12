<?php
namespace app\admin\controller;

/**
 * 后台-首页
 */
class Index extends Common
{
	/**
     * 首页
     * @access public
     * @return void
     */
    public function index()
    {
        $this->assign('menu', 'index');
        $config = [
            'PHP_OS' => PHP_OS,
            'TIME' => date("Y-n-j H:i:s"),
            'SERVER_SOFTWARE' => $_SERVER["SERVER_SOFTWARE"],
            'PHP_API_NAME' => php_sapi_name(),
            'FILESIZE' => (int)config('upload_max_filesize') . ' M',
            'EXE_TIME' => ini_get('max_execution_time').' 秒',
        ];
        $this->assign('config', $config);
        return $this->fetch();
    }
}
