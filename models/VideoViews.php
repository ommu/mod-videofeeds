<?php
/**
 * VideoViews
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co) 
 * @created date 5 May 2017, 12:54 WIB
 * @link https://github.com/ommu/ommu-videofeeds
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_video_views".
 *
 * The followings are the available columns in table 'ommu_video_views':
 * @property string $view_id
 * @property integer $publish
 * @property string $video_id
 * @property string $user_id
 * @property integer $views
 * @property string $view_date
 * @property string $view_ip
 * @property string $deleted_date
 */
class VideoViews extends CActiveRecord
{
	public $defaultColumns = array();
	
	// Variable Search
	public $category_search;
	public $video_search;
	public $user_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VideoViews the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_video_views';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('publish, video_id, user_id', 'required'),
			array('publish, views', 'numerical', 'integerOnly'=>true),
			array('video_id, user_id, views', 'length', 'max'=>11),
			array('view_ip', 'length', 'max'=>20),
			array('', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('view_id, publish, video_id, user_id, views, view_date, view_ip, deleted_date,
				category_search, video_search, user_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'video' => array(self::BELONGS_TO, 'Videos', 'video_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'view_id' => Yii::t('attribute', 'View'),
			'publish' => Yii::t('attribute', 'Publish'),
			'video_id' => Yii::t('attribute', 'Video'),
			'user_id' => Yii::t('attribute', 'User'),
			'views' => Yii::t('attribute', 'Views'),
			'view_date' => Yii::t('attribute', 'View Date'),
			'view_ip' => Yii::t('attribute', 'View Ip'),
			'deleted_date' => Yii::t('attribute', 'Deleted Date'),
			'category_search' => Yii::t('attribute', 'Category'),
			'video_search' => Yii::t('attribute', 'Video'),
			'user_search' => Yii::t('attribute', 'User'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		// Custom Search
		$criteria->with = array(
			'video' => array(
				'alias'=>'video',
				'select'=>'publish, cat_id, title'
			),
			'user' => array(
				'alias'=>'user',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.view_id',$this->view_id);
		if(isset($_GET['type']) && $_GET['type'] == 'publish')
			$criteria->compare('t.publish',1);
		elseif(isset($_GET['type']) && $_GET['type'] == 'unpublish')
			$criteria->compare('t.publish',0);
		elseif(isset($_GET['type']) && $_GET['type'] == 'trash')
			$criteria->compare('t.publish',2);
		else {
			$criteria->addInCondition('t.publish',array(0,1));
			$criteria->compare('t.publish',$this->publish);
		}
		if(isset($_GET['video']))
			$criteria->compare('t.video_id',$_GET['video']);
		else
			$criteria->compare('t.video_id',$this->video_id);
		if(isset($_GET['user']))
			$criteria->compare('t.user_id',$_GET['user']);
		else
			$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.views',$this->views);
		if($this->view_date != null && !in_array($this->view_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.view_date)',date('Y-m-d', strtotime($this->view_date)));
		$criteria->compare('t.view_ip',strtolower($this->view_ip),true);
		if($this->deleted_date != null && !in_array($this->deleted_date, array('0000-00-00 00:00:00', '0000-00-00')))
			$criteria->compare('date(t.deleted_date)',date('Y-m-d', strtotime($this->deleted_date)));
		
		$criteria->compare('video.cat_id',$this->category_search);
		$criteria->compare('video.title',strtolower($this->video_search),true);
		if(isset($_GET['video']) && isset($_GET['publish']))
			$criteria->compare('video.publish',$_GET['publish']);
		$criteria->compare('user.displayname',strtolower($this->user_search),true);

		if(!isset($_GET['VideoViews_sort']))
			$criteria->order = 't.view_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'view_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'video_id';
			$this->defaultColumns[] = 'user_id';
			$this->defaultColumns[] = 'views';
			$this->defaultColumns[] = 'view_date';
			$this->defaultColumns[] = 'view_ip';
			$this->defaultColumns[] = 'deleted_date';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			if(!isset($_GET['video'])) {
				$this->defaultColumns[] = array(
					'name' => 'category_search',
					'value' => 'Phrase::trans($data->video->cat->name)',
					'filter'=> VideoCategory::getCategory(),
					'type' => 'raw',
				);
				$this->defaultColumns[] = array(
					'name' => 'video_search',
					'value' => '$data->video->title',
				);
			}
			if(!isset($_GET['user'])) {
				$this->defaultColumns[] = array(
					'name' => 'user_search',
					'value' => '$data->user_id != 0 ? $data->user->displayname : "-"',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'views',
				'value' => 'CHtml::link($data->views ? $data->views : 0, Yii::app()->controller->createUrl("o/viewdetail/manage",array(\'view\'=>$data->view_id)))',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			);
			$this->defaultColumns[] = array(
				'name' => 'view_date',
				'value' => 'Utility::dateFormat($data->view_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'view_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'view_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'dd-mm-yy',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			$this->defaultColumns[] = array(
				'name' => 'view_ip',
				'value' => '$data->view_ip',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			if(!isset($_GET['type'])) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->view_id)), $data->publish, 1)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id,array(
				'select' => $column
			));
			return $model->$column;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;			
		}
	}

	/**
	 * User get information
	 */
	public static function insertView($video_id)
	{
		$criteria=new CDbCriteria;
		$criteria->select = 't.view_id, t.publish, t.video_id, t.user_id, t.views';
		$criteria->compare('t.publish', 1);
		$criteria->compare('t.video_id', $video_id);
		$criteria->compare('t.user_id', !Yii::app()->user->isGuest ? Yii::app()->user->id : '0');
		$findView = self::model()->find($criteria);
		
		if($findView != null)
			self::model()->updateByPk($findView->view_id, array('views'=>$findView->views + 1, 'view_ip'=>$_SERVER['REMOTE_ADDR']));
		
		else {
			$view=new VideoViews;
			$view->video_id = $video_id;
			$view->save();
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->user_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : null;
			
			$this->view_ip = $_SERVER['REMOTE_ADDR'];
		}
		return true;
	}

}