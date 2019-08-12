<?php
/**
 * Video Like Details (video-like-detail)
 * @var $this LikedetailController
 * @var $model VideoLikeDetail
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 5 May 2017, 16:57 WIB
 * @link https://github.com/ommu/ommu-videofeeds
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('id'); ?><br/>
			<?php echo $form->textField($model,'id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('like_id'); ?><br/>
			<?php echo $form->textField($model,'like_id'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('likes_date'); ?><br/>
			<?php echo $form->textField($model,'likes_date'); ?>
		</li>

		<li>
			<?php echo $model->getAttributeLabel('likes_ip'); ?><br/>
			<?php echo $form->textField($model,'likes_ip'); ?>
		</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
