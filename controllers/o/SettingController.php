<?php
/**
 * SettingController
 * @var $this SettingController
 * @var $model VideoSetting
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Edit
 *	Manual
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2014 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/ommu-videofeeds
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SettingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		if(!Yii::app()->user->isGuest) {
			if(in_array(Yii::app()->user->level, array(1,2))) {
				$arrThemes = $this->currentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
				//'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level != 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('edit'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 1)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manual'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (in_array(Yii::app()->user->level, array(1,2)))',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('edit'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionEdit() 
	{
		if(Yii::app()->user->level != 1)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		
		$category=new VideoCategory('search');
		$category->unsetAttributes();	// clear any default values
		if(isset($_GET['VideoCategory'])) {
			$category->attributes=$_GET['VideoCategory'];
		}

		$columns = $category->getGridColumn($this->gridColumnTemp());
		
		$model = VideoSetting::model()->findByPk(1);
		if($model == null)
			$model=new VideoSetting;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['VideoSetting'])) {
			$model->attributes=$_POST['VideoSetting'];
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 0,
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Video setting success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();			
		}
		
		$this->pageTitle = Yii::t('phrase', 'Video Feeder Settings');
		$this->pageDescription = Yii::t('phrase', 'This page contains general video feeder settings that affect your entire social network.');
		$this->pageMeta = '';
		$this->render('admin_edit', array(
			'model'=>$model,
			'category' => $category,
			'columns' => $columns,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionManual() 
	{
		$manual_path = $this->module->basePath.'/assets/manual';
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('o/admin/manage');
		$this->dialogWidth = 400;
		
		$this->pageTitle = Yii::t('phrase', 'Video Feeder Manual');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manual', array(
			'manual_path'=>$manual_path,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = VideoSetting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='video-setting-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
