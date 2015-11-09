<?php

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
