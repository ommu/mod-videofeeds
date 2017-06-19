<?php
/**
 * Videoses (videos)
 * @var $this SiteController
 * @var $model Videos
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-video-album
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Videoses'=>array('manage'),
		$model->title,
	);
?>

<div class="meta-date clearfix">
	<span class="tag"><i class="fa fa-tag"></i>&nbsp;<?php echo Phrase::trans($model->cat->name,2);?></span>
	<span class="date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Utility::dateFormat($model->creation_date, true);?></span>
	<span class="by"><i class="fa fa-user"></i>&nbsp;<?php echo $model->user->displayname;?></span>
	<span class="view"><i class="fa fa-eye"></i>&nbsp;<?php echo $model->view;?></span>
</div>

<?php if($model->media != '') {?>
	<iframe class="headline" width="600" height="350" src="https://www.youtube.com/embed/<?php echo $model->media;?>?disablekb=1&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
<?php }?>

<div class="box-content clearfix">
	<?php echo $model->body;?>
</div>