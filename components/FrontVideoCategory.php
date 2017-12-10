<?php
/**
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-videofeeds
 * @contact (+62)856-299-4114
 *
 */

class FrontVideoCategory extends CWidget
{

	public function init() {
	}

	public function run() {
		$this->renderContent();
	}

	protected function renderContent() {
		$model = VideoCategory::model()->findAll(array(
			'condition' => 'publish = :publish',
			'params' => array(
				':publish' => 1,
			),
		));

		$this->render('front_video_category',array(
			'model' => $model,
		));	
	}
}
