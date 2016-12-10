<?php
/**
 *
 * 首页 - 控制器
 *
 * @package   NiPHPCMS
 * @category  index\controller\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: Index.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/11/25
 */
namespace app\index\controller;
use think\Loader;
use think\Url;
use think\Lang;
use app\index\controller\Common;
class Index extends Common
{
	protected $beforeActionList = [
		'first' => ['index', 'entry'],
	];

	/**
	 * 首页
	 * @access public
	 * @param
	 * @return string
	 */
	public function index()
	{
		return $this->fetch();
	}

	/**
	 * 列表页
	 * @access public
	 * @param
	 * @return string
	 */
	public function entry()
	{
		$model = ['article', 'download', 'picture', 'product'];
		if (in_array($this->table_name, $model)) {
			$model = Loader::model('Article', 'logic');
			$model->setTableModel($this->table_name);
		} else {
			// page link feedback message
			$model = Loader::model($this->table_name, 'logic');
		}

		// feedback or message
		if ($this->request->isPost() && in_array($this->table_name, ['feedback', 'message'])) {
			$result = $this->validate($_POST, ucfirst($this->table_name));
			if (true !== $result) {
				$this->error(Lang::get($result));
			}

			$result = $model->added();
			if (true === $result) {
				$url = Url::build('/entry/' . $this->request->param('cid'));
				$this->success(Lang::get('success ' . $this->table_name . ' added'), $url);
			} else {
				$this->error(Lang::get('error ' . $this->table_name . ' added'));
			}
		}

		$data = $model->getListData();

		$this->assign('data', $data['list']);
		$this->assign('list', $data['list']);
		$this->assign('page', $data['page']);
		$this->assign('count', count($data['list']));

		return $this->fetch('entry/' . $this->table_name);
	}

	/**
	 * 内容页
	 * @access public
	 * @param
	 * @return string
	 */
	public function article()
	{
		$model = Loader::model('Article', 'logic');
		$model->setTableModel($this->table_name);

		$data = $model->getArticle();

		if ($data['is_link']) {
			$this->redirect(Url::build('/jump/' . $data['category_id'] . '/' . $data['id']), 302);
		}

		$this->assign('data', $data);

		$web_info = $this->getCatWebInfo();
		$replace = [
			'__TITLE__'       => $data['title'] . ' - ' . $web_info['title'],
			'__KEYWORDS__'    => $data['keywords'] ? $data['keywords'] : $web_info['keywords'],
			'__DESCRIPTION__' => $data['description'] ?
									$data['description'] :
									$web_info['description'],
		];
		$this->view->replace($replace);

		return $this->fetch('article/' . $this->table_name);
	}

	public function tags()
	{
		return $this->fetch('entry/tags');
	}

	/**
	 * 跳转
	 * @access public
	 * @param
	 * @return string
	 */
	public function jump()
	{
		$model = Loader::model('Jump', 'logic');
		$url = $model->jump($this->table_name);
		$this->redirect($url, 302);
	}

	/**
	 * 首页 列表页 网站标题等数据
	 * @access protected
	 * @param
	 * @return void
	 */
	protected function first()
	{
		if ($this->request->has('cid', 'param')) {
			$web_info = $this->getCatWebInfo();
		} else {
			$web_info = [
				'title' => $this->website_data['website_name'],
				'keywords' => $this->website_data['website_keywords'],
				'description' => $this->website_data['website_description']
			];
		}
		$replace = [
			'__TITLE__' => $web_info['title'],
			'__KEYWORDS__' => $web_info['keywords'],
			'__DESCRIPTION__' => $web_info['description'],
		];
		$this->view->replace($replace);
	}

	/**
	 * 安栏目获得网站标题、关键词、描述
	 * @access protected
	 * @param
	 * @return arrays
	 */
	protected function getCatWebInfo()
	{
		$web_title = $web_keywords = $web_description = '';
		if ($this->request->has('cid', 'param')) {
			$data = $this->common_model->getCategoryData();

			$this->assign('__SUB_TITLE__', $data[0]['name']);

			foreach ($data as $value) {
				$web_title .= $value['seo_title'] ? $value['seo_title'] : $value['name'] . ' - ';
			}

			$web_keywords = $data[0]['seo_keywords'];
			$web_description = $data[0]['seo_description'];

			$web_keywords = $web_keywords ? $web_keywords : $this->website_data['website_keywords'];
			$web_description = $web_description ? $web_description : $this->website_data['website_description'];
		}

		$web_title .= $this->website_data['website_name'];

		return [
			'title' => $web_title,
			'keywords' => $web_keywords,
			'description' => $web_description
		];
	}
}
