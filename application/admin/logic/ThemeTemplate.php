<?php
/**
 *
 * 网站模板 - 设置 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: ThemeTemplate.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use util\File;
use app\admin\model\Config as AdminConfig;

class ThemeTemplate extends Model
{
    protected $request = null;

    protected function initialize()
    {
        parent::initialize();

        $this->request = Request::instance();
    }

    /**
     * 列表数据
     * @access public
     * @param
     * @return array
     */
    public function getListData()
    {
        $config_type = $this->config();

        $type = $this->type();
        $list = File::get(ROOT_PATH . 'public' . DS . 'theme' . DS . $type . DS);

        return ['config' => $config_type, 'list' => $list, 'type' => $type];
    }

    /**
     * 编辑数据
     * @access public
     * @param
     * @return boolean
     */
    public function editor()
    {
        $type = $this->type();

        $map = [
            'name' => $type . '_theme',
            'lang' => Lang::detect()
        ];

        $data = ['value' => $this->request->param('id')];

        $config = new AdminConfig;
        $result =
        $config->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

        return $result ? true : false;
    }

    /**
     * 模板设置
     * @access protected
     * @param
     * @return string
     */
    protected function config()
    {
        $type = $this->type();

        $map = [
            'name' => $type . '_theme',
            'lang' => Lang::detect()
        ];

        $config = new AdminConfig;
        return
        $config->field(true)
        ->where($map)
        ->value('value');
    }

    /**
     * 模板类型
     * @access protected
     * @param
     * @return string
     */
    protected function type()
    {
        $action = $this->request->action();
        if ($action == 'template') {
            $type = 'index';
        } else {
            $type = $action;
        }

        return $type;
    }
}
