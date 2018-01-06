<?php
/**
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2014 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-videofeeds
 *
 */
?>

<?php if($model != null) {?>
<div class="boxed">
	<h3><?php echo Yii::t('phrase', 'Video Categories');?></h3>
	<ul class="category">
	<?php 
	echo '<li><a href="'.Yii::app()->controller->createUrl('index').'" title="'.Yii::t('phrase', 'All').'">'.Yii::t('phrase', 'All').'</a></li>';
	foreach($model as $key => $val) {
		echo '<li><a href="'.Yii::app()->controller->createUrl('index', array('cat'=>$val->cat_id, 'slug'=>Phrase::trans($val->name))).'" title="'.Phrase::trans($val->name).'">'.Phrase::trans($val->name).'</a></li>';
	}?>
	</ul>
</div>
<?php }?>
