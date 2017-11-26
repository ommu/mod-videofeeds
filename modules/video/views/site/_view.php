<?php
/**
 * Videoses (videos)
 * @var $this SiteController
 * @var $data Videos
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-videofeeds
 * @contact (+62)856-299-4114
 *
 */
?>

<?php if($index == 0) {?>
	<div class="sep full">
		<iframe class="youtube" width="600" height="350" src="https://www.youtube.com/embed/<?php echo $data->media;?>?disablekb=1&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
		<a class="title" href="<?php echo Yii::app()->controller->createUrl('view', array('id'=>$data->video_id,'t'=>Utility::getUrlTitle($data->title)));?>" title="<?php echo $data->title;?>"><?php echo Utility::hardDecode($data->title);?></a>
		<div class="meta-date clearfix">
			<span class="date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Utility::dateFormat($data->creation_date, true);?></span>
			<span class="view"><i class="fa fa-eye"></i>&nbsp;<?php echo $data->view;?></span>
		</div>
		<p><?php echo $data->body != '' ? Utility::shortText(Utility::hardDecode($data->body),250) : '-';?></p>
	</div>
	<div class="clear"></div>
	
<?php } else {?>
	<div class="sep">
		<iframe class="youtube" width="300" height="150" src="https://www.youtube.com/embed/<?php echo $data->media;?>?disablekb=1&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
		<a class="title" href="<?php echo Yii::app()->controller->createUrl('view', array('id'=>$data->video_id,'t'=>Utility::getUrlTitle($data->title)));?>" title="<?php echo $data->title;?>"><?php echo Utility::shortText(Utility::hardDecode($data->title),40);?></a>
		<div class="meta-date clearfix">
			<span class="date"><i class="fa fa-calendar"></i>&nbsp;<?php echo Utility::dateFormat($data->creation_date, true);?></span>
			<span class="view"><i class="fa fa-eye"></i>&nbsp;<?php echo $data->view;?></span>
		</div>
		<p><?php echo $data->body != '' ? Utility::shortText(Utility::hardDecode($data->body),100) : '-';?></p>
	</div>
<?php }?>