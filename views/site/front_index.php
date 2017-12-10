<?php
/**
 * Videoses (videos)
 * @var $this SiteController
 * @var $model Videos
 * @var $dataProvider CActiveDataProvider
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-videofeeds
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Videoses',
	);
?>

<div class="box list">
	<?php $this->widget('application.libraries.core.components.system.FListView', array(
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