<?php
/**
 * Video Categories (video-category)
 * @var $this CategoryController
 * @var $model VideoCategory
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Video-Albums
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Video Categories'=>array('manage'),
		$model->name=>array('view','id'=>$model->cat_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>