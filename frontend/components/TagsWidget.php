<?php 
namespace frontend\components;

use yii\Base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
* 
*/
class TagsWidget extends Widget
{
	public $tags;
	
	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$tagStr = '';
		$tpl = [
			'6' => 'danger',
			'5' => 'primary',
			'4' => 'info',
			'3' => 'warning',
			'2' => 'success',
		];
		foreach ($this->tags as $tag => $weight) {
			$tagStr .= "<a href=".Url::to(['post/index', 'PostSearch[tags]' => $tag]).">
			<h".$weight."  style='display:inline-block;'>
			<span class='label label-".$tpl[$weight]."'>".$tag."</span>
			</h".$weight."></a> ";
		}
		return $tagStr;
	}
}