<?php
/**
 * Video Likes (video-likes)
 * @var $this LikesController
 * @var $model VideoLikes
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 5 May 2017, 16:57 WIB
 * @link https://github.com/ommu/Video-Albums
 * @contact (+62)856-299-4114
 *
 */
?>

<?php $form=$this->beginWidget('application.components.system.OActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('like_id'); ?><br/>
			<?php echo $form->textField($model,'like_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('video_id'); ?><br/>
			<?php echo $form->textField($model,'video_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('user_id'); ?><br/>
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('likes_date'); ?><br/>
			<?php echo $form->textField($model,'likes_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('likes_ip'); ?><br/>
			<?php echo $form->textField($model,'likes_ip',array('size'=>20,'maxlength'=>20)); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
	<div class="clear"></div>
<?php $this->endWidget(); ?>
