<?php
/**
 * Videoses (videos)
 * @var $this AdminController
 * @var $model Videos
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/Video-Albums
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Videoses'=>array('manage'),
		'Create',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>