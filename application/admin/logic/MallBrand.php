<?php
/**
 *
 * 品牌 - 商城 - 逻辑层
 *
 * @package   NiPHPCMS
 * @category  admin\logic\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: MallBrand.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2017/01/03
 */
namespace app\admin\logic;

use think\Model;
use think\Request;
use think\Lang;
use think\Cache;
use app\admin\model\MallBrand as AdminMallBrand;

class MallBrand extends Model
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
        $map = [
            'lang' => Lang::detect()
        ];

        if ($key = $this->request->param('key')) {
            $map['name'] = ['LIKE', '%' . $key . '%'];
        }

        $brand = new AdminMallBrand;
        $result =
        $brand->field(true)
        ->where($map)
        ->order('id DESC')
        ->paginate();

        $list = [];
        foreach ($result as $value) {
            $list[] = $value->toArray();
        }

        $page = $result->render();

        return ['list' => $list, 'page' => $page];
    }


    /**
     * 添加数据
     * @access public
     * @param
     * @return boolean
     */
    public function added()
    {
        $data = [
            'name'  => $this->request->post('name'),
            'image' => $this->request->post('image'),
            'pid'   => $this->request->post('pid/f', 0),
            'lang'  => Lang::detect(),
        ];

        $brand = new AdminMallBrand;
        $brand->data($data)
        ->allowField(true)
        ->isUpdate(false)
        ->save();

        return $brand->id ? true : false;
    }

    /**
     * 查询编辑数据
     * @access public
     * @param
     * @return array
     */
    public function getEditorData()
    {
        $map = ['id' => $this->request->param('id/f')];

        $brand = new AdminMallBrand;
        $result =
        $brand->field(true)
        ->where($map)
        ->find();

        return !empty($result) ? $result->toArray() : [];
    }

    /**
     * 编辑数据
     * @access public
     * @param
     * @return boolean
     */
    public function editor()
    {
        $data = [
            'name'  => $this->request->post('name'),
            'image' => $this->request->post('image'),
            'lang'  => Lang::detect(),
        ];
        $map = ['id' => $this->request->post('id/f')];

        $brand = new AdminMallBrand;
        $result =
        $brand->allowField(true)
        ->isUpdate(true)
        ->save($data, $map);

        return $result ? true : false;
    }

    /**
     * 删除数据
     * @access public
     * @param
     * @return boolean
     */
    public function remove()
    {
        $id = $this->request->param('id/f');
        $map = ['pid' => $id];

        $brand = new AdminMallBrand;
        $result =
        $brand->where($map)
        ->delete();

        return $result ? true : false;
    }

    /**
     * 排序
     * @access public
     * @param
     * @return boolean
     */
    public function listSort()
    {
        $post = $this->request->post('sort/a');
        foreach ($post as $key => $value) {
            $data[] = [
                'id' => $key,
                'sort' => $value,
            ];
        }

        $brand = new AdminMallBrand;
        $result =
        $brand->saveAll($data);

        return true;
    }
}