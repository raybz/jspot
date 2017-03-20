<?php 
namespace console\controllers;

use yii\console\Controller;
/**
* 
*/
class DataController extends Controller
{
	public $rev;
	public function options()
	{
		return ['rev'];
	}
	// public function optionAliases()
	// {
	// 	return ['r' => 'rev'];
	// }
	public function actionHello()
	{
		echo 'hello world';
	}
	// ./yii data/world a b
	public function actionWorld($hello, $world)
	{
		echo $hello.$world;
	}
	// ./yii data/index a,b,c
	public function actionIndex(array $data)
	{
		var_dump($data);
	}

	public function actionHi()
	{
		if ($this->rev == 1){
			echo 333;
		} else {
			echo 444;
		}
	}
}