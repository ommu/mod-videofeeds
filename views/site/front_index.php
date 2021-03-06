<?php
/**
 * Videoses (videos)
 * @var $this SiteController
 * @var $model Videos
 * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2014 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/ommu-videofeeds
 *
 */

	$this->breadcrumbs=array(
		'Videoses',
	);
?>

<div class="box list">
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'pager' => array(
			'header' => '',
		), 
		'summaryText' => '',
		'itemsCssClass' => 'items clearfix',
		'pagerCssClass'=>'pager clearfix',
	)); ?>
</div>
