<?php
/**
 * SearchController
 * @var $this SearchController
 * @var $model Videos
 * @var $form CActiveForm
 * version: 0.0.1
 * Reference start
 *
 * TOC :
 *	Index
 *	Indexing
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2014 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Video-Albums
 * @contect (+62)856-299-4114
 *
 *----------------------------------------------------------------------------------------------------------
 */

class SearchController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';
	private $_indexFilesPath = 'application.runtime.search.video';

	/**
	 * Initialize public template
	 */
	public function init() 
	{
		$arrThemes = Utility::getCurrentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		
		//load Lucene Library
		Yii::import('application.vendors.*');
		require_once('Zend/Search/Lucene.php');
		parent::init();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionIndex()
	{
		$this->redirect(Yii::app()->createUrl('site/index'));
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndexing()
	{
		ini_set('max_execution_time', 0);
		ob_start();		
		
		$index = new Zend_Search_Lucene(Yii::getPathOfAlias($this->_indexFilesPath), true);
		
		$criteria=new CDbCriteria;
		$criteria->compare('t.publish', 1);
		$criteria->order = 'video_id DESC';
		//$criteria->limit = 10;
		$model = Videos::model()->findAll($criteria);
		foreach($model as $key => $item) {				
			$doc = new Zend_Search_Lucene_Document();
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('id', CHtml::encode($item->video_id), 'utf-8')); 
			$doc->addField(Zend_Search_Lucene_Field::Keyword('category', CHtml::encode(Phrase::trans($item->cat->name,2)), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('media', CHtml::encode('https://www.youtube.com/watch?v='.$item->media), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('title', CHtml::encode($item->title), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('body', CHtml::encode(Utility::hardDecode(Utility::softDecode($item->body))), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::Text('url', CHtml::encode(Utility::getProtocol().'://'.Yii::app()->request->serverName.Yii::app()->createUrl('video/site/view', array('id'=>$item->video_id,'t'=>Utility::getUrlTitle($item->title)))), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('date', CHtml::encode(Utility::dateFormat($item->creation_date, true).' WIB'), 'utf-8'));
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('creation', CHtml::encode($item->user->displayname), 'utf-8'));
			$index->addDocument($doc);
			
		}
		echo 'Video Lucene index created';	
		$index->commit();
		//$this->redirect(Yii::app()->createUrl('album/search/indexing'));
		
		ob_end_flush();		
	}
 
	public function actionResult()
	{
		if(isset($_GET)) {
			$term = $_GET['keyword'];
			$index = new Zend_Search_Lucene(Yii::getPathOfAlias($this->_indexFilesPath));
			$results = $index->find($term);			
			//print_r($results);
			//exit();
			
			if(isset($_GET['type'])) {
				$dataProvider = new CPagination(count($results));
				$currentPage = Yii::app()->getRequest()->getQuery('page', 1);
				$dataProvider->pageSize = 10;
				
				$pager = OFunction::getDataProviderPager($dataProvider, false);
				$get = array_merge($_GET, array($pager['pageVar']=>$pager['nextPage']));
				$nextPager = $pager['nextPage'] != 0 ? OFunction::validHostURL(Yii::app()->controller->createUrl('result', $get)) : '-';
				//print_r($pager);	
				
				$data = '';
				if(!empty($results)) {
					$i = $currentPage * $dataProvider->pageSize - $dataProvider->pageSize;
					$end = $currentPage * $dataProvider->pageSize;
					//foreach($results as $key => $item) {
					for($i=$i; $i<$end; $i++) {
						$data[] = array(						
							'id'=>CHtml::encode($results[$i]->id),
							'category'=>CHtml::encode($results[$i]->category),
							'media'=>CHtml::encode($results[$i]->media),
							'title'=>CHtml::encode($results[$i]->title),
							'body'=>CHtml::encode($results[$i]->body),
							'date'=>CHtml::encode($results[$i]->date),
							'view'=>CHtml::encode($results[$i]->view),
						);			
					}
				} else {
					$data = array();
				}
				
				$return = array(
					'data' => $data,
					'pager' => $pager,
					'nextPager' => $nextPager,
				);
				echo CJSON::encode($return);
				
			} else {
				$query = Zend_Search_Lucene_Search_QueryParser::parse($term);
		
				$this->pageTitleShow = true;
				$this->pageTitle = 'Hasil Pencarian: '.$_GET['keyword'];
				$this->pageDescription = '';
				$this->pageMeta = '';
				
				$this->render('front_result', compact(
					'results', 
					'term', 
					'query'
				));
			}
		} else {
			$this->redirect(Yii::app()->createUrl('site/index'));
		}
	}
}