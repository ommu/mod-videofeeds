<?php
/**
 * Video Settings (video-setting)
 * @var $this SettingController * @var $model VideoSetting *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link http://company.ommu.co
 * @contect (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Video Settings'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);
?>

<?php //begin.Search ?>
<div class="search-form">
<?php $this->renderPartial('/category/_search',array(
	'model'=>$category,
)); ?>
</div>
<?php //end.Search ?>

<?php //begin.Grid Option ?>
<div class="grid-form">
<?php $this->renderPartial('/category/_option_form',array(
	'model'=>$category,
)); ?>
</div>
<?php //end.Grid Option ?>

<div id="partial-video-category">
	<?php //begin.Messages ?>
	<div id="ajax-message">
	<?php
	if(Yii::app()->user->hasFlash('error'))
		echo Utility::flashError(Yii::app()->user->getFlash('error'));
	if(Yii::app()->user->hasFlash('success'))
		echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
	?>
	</div>
	<?php //begin.Messages ?>

	<div class="boxed">
		<h3><?php echo Phrase::trans(25014,1); ?></h3>
		<?php //begin.Grid Item ?>
		<?php 
			$columnData   = $columns;
			array_push($columnData, array(
				'header' => Phrase::trans(151,0),
				'class'=>'CButtonColumn',
				'buttons' => array(
					'view' => array(
						'label' => 'view',
						'options' => array(							
							'class' => 'view',
						),
						'url' => 'Yii::app()->controller->createUrl("category/view",array("id"=>$data->primaryKey))'),
					'update' => array(
						'label' => 'update',
						'options' => array(
							'class' => 'update'
						),
						'url' => 'Yii::app()->controller->createUrl("category/edit",array("id"=>$data->primaryKey))'),
					'delete' => array(
						'label' => 'delete',
						'options' => array(
							'class' => 'delete'
						),
						'url' => 'Yii::app()->controller->createUrl("category/delete",array("id"=>$data->primaryKey))')
				),
				'template' => '{update}|{delete}',
			));

			$this->widget('application.components.system.OGridView', array(
				'id'=>'video-category-grid',
				'dataProvider'=>$category->search(),
				'filter'=>$category,
				'columns' => $columnData,
				'pager' => array('header' => ''),
			));
		?>
		<?php //end.Grid Item ?>
	</div>
</div>

<div class="form mt-15" name="post-on">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
