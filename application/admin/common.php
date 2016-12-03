<?php
/**
 *
 * 模块公共（函数）文件
 *
 * @package   NiPHPCMS
 * @category  admin\
 * @author    失眠小枕头 [levisun.mail@gmail.com]
 * @copyright Copyright (c) 2013, 失眠小枕头, All rights reserved.
 * @version   CVS: $Id: common.php v1.0.1 $
 * @link      http://www.NiPHP.com
 * @since     2016/10/22
 */

/**
 * 自定义字段类型转换
 * @param  array $data_
 * @return string
 */
function toFieldsType($data_)
{
	switch ($data_['field_type']) {
		case 'number':
		case 'email':
		case 'phone':
			$input = '<input type="' . $data_['field_type'] . '"';
			$input .= ' name="fields[' . $data_['id'] . ']"';
			$input .= ' id="fields-' . $data_['id'] . '"';
			$input .= ' value="' . $data_['field_data'] . '"';
			$input .= ' class="form-control">';
			break;

		case 'url':
		case 'currency':
		case 'abc':
		case 'idcards':
		case 'landline':
		case 'age':
			$input = '<input type="text"';
			$input .= ' name="fields[' . $data_['id'] . ']"';
			$input .= ' id="fields-' . $data_['id'] . '"';
			$input .= ' value="' . $data_['field_data'] . '"';
			$input .= ' class="form-control">';
			break;

		case 'date':
			$input = '<input type="text"';
			$input .= ' name="fields[' . $data_['id'] . ']"';
			$input .= ' id="fields-' . $data_['id'] . '"';
			$input .= ' value="' . date('Y-m-d', $data_['field_data']) . '"';
			$input .= ' class="form-control">';

			$input .= '<script type="text/javascript">
				$(function () {
					$("#fields-' . $data_['id'] . '").datetimepicker(
						{format: "Y-M-D"}
						);
				});
				</script>';
			break;

		case 'text':
			$input = '<textarea name="fields[' . $data_['id'] . ']"';
			$input .= ' id="fields-' . $data_['id'] . '"';
			$input .= ' class="form-control">';
			$input .= $data_['field_data'];
			$input .= '</textarea>';
			break;
	}

	return $input;
}

/**
 * 上传文件返回js代码
 * @param  array  $file_ 上传返回文件地址等数据
 * @return string
 */
function upload_to_javasecipt($file_)
{
	$domain = \think\Config::get('view_replace_str.__DOMAIN__');
	$request = \think\Request::instance();
	if ($request->param('type') == 'ckeditor') {
		// 编辑器
		$ckefn = $request->param('CKEditorFuncNum');
		$javascript = '<script type="text/javascript">';
		$javascript .= 'window.parent.CKEDITOR.tools.callFunction(';
		$javascript .= $ckefn . ',\'' . $file_['file_name'] . '\',';
		$javascript .= '\'' . \think\Lang::get('success upload') . '\'';
		$javascript .= ');';
		$javascript .= '</script>';
	} elseif ($request->param('type') == 'album') {
		// 相册
		$id = $request->post('id');
		$javascript = '<script type="text/javascript">';
		$javascript .= 'opener.document.getElementById("album-image-' . $id . '").value="' . $file_['file_name'] . '";';
		$javascript .= 'opener.document.getElementById("album-thumb-' . $id . '").value="' . $file_['file_thumb_name'] . '";';
		$javascript .= 'opener.document.getElementById("img-album-' . $id . '").style.display="";';
		$javascript .= 'opener.document.getElementById("img-album-' . $id . '").src="' . $domain . $file_['file_thumb_name'] . '";';
		$javascript .= 'window.close();';
		$javascript .= '</script>';
	} else {
		// 普通缩略图
		$id = $request->post('id');
		$javascript = '<script type="text/javascript">';
		$javascript .= 'opener.document.getElementById("' . $id . '").value="' . $file_['file_thumb_name'] . '";';
		$javascript .= 'opener.document.getElementById("img-' . $id . '").style.display="";';
		$javascript .= 'opener.document.getElementById("img-' . $id . '").src="' . $domain . $file_['file_thumb_name'] . '";';
		$javascript .= 'window.close();';
		$javascript .= '</script>';
	}
	return $javascript;
}