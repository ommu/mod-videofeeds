<?php
/**
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2014 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/ommu-videofeeds
 *
 */
?>

<?php if($model != null) {?>
<div class="box recent-news-video">
	<h3>Video Terbaru</h3>
	<ul>
		<?php
		$i=0;
		foreach($model as $key => $val) {
		$i++;
			if($i == 1) {?>
				<li <?php echo $val->media != '' ? 'class="solid"' : '';?>>
					<a href="<?php echo Yii::app()->createUrl('video/site/view', array('id'=>$val->video_id, 'slug'=>$this->urlTitle($val->title)))?>" title="<?php echo $val->title?>">
						<?php if($val->media != '') {?><iframe width="230" src="https://www.youtube.com/embed/<?php echo $val->media;?>?disablekb=1&rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe><?php }?>
						<?php echo $val->title?>
					</a>
				</li>
			<?php } else {?>
				<li><a href="<?php echo Yii::app()->createUrl('video/site/view', array('id'=>$val->video_id, 'slug'=>$this->urlTitle($val->title)))?>" title="<?php echo $val->title?>"><?php echo $val->title?></a></li>
			<?php }
		}?>
	</ul>
</div>
<?php }?>