<?php 
class module_connexion extends abstract_moduleembedded{
	
	public static $sModuleName='connexion';
	public static $sRootModule;
	public static $tRootParams;
	
	public function __construct(){
		self::setRootLink(_root::getParamNav(),null);
	}
	public static function setRootLink($sRootModule,$tRootParams=null){
		self::$sRootModule=$sRootModule;
		self::$tRootParams=$tRootParams;
	}
	public static function getLink($sAction,$tParam=null){
		return parent::_getLink(self::$sRootModule,self::$tRootParams,self::$sModuleName,$sAction,$tParam);
	}
	public static function getParam($sVar,$uDefault=null){
		return parent::_getParam(self::$sModuleName,$sVar,$uDefault);
	}
	public static function redirect($sModuleAction,$tModuleParam=null){
		return parent::_redirect(self::$sRootModule,self::$tRootParams,self::$sModuleName,$sModuleAction,$tModuleParam);
	}
	
	/*
	Pour integrer au sein d'un autre module:
	
	//instancier le module
	$oModuleConnexion=new module_connexion();
	
	//si vous souhaitez indiquer au module integrable des informations sur le module parent
	//$oModuleConnexion->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
	
	//recupere la vue du module
	$oViewModule=$oModuleConnexion->_index();
	
	//assigner la vue retournee a votre layout
	$this->oLayout->add('main',$oViewModule);
	*/
	
	
	public function _index(){
		$sAction='_'.self::getParam('Action','list');
		return $this->$sAction();
	}
	
	public function _list(){
		
		$tConnexion=model_connexion::getInstance()->findAll();
		
		$oView=new _view('connexion::list');
		$oView->tConnexion=$tConnexion;
		
				$oView->tJoinmodel_type=model_type::getInstance()->getSelect();

		return $oView;
	}
	

	public function _new(){
		$tMessage=$this->save();
	
		$oConnexion=new row_connexion;
		
		$oView=new _view('connexion::new');
		$oView->oConnexion=$oConnexion;
		
				$oView->tJoinmodel_type=model_type::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}
	
	
	public function _edit(){
		$tMessage=$this->save();
		
		$oConnexion=model_connexion::getInstance()->findById( module_connexion::getParam('id') );
		
		$oView=new _view('connexion::edit');
		$oView->oConnexion=$oConnexion;
		$oView->tId=model_connexion::getInstance()->getIdTab();
		
				$oView->tJoinmodel_type=model_type::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}

	public function _show(){
		$oConnexion=model_connexion::getInstance()->findById( module_connexion::getParam('id') );
		
		$oView=new _view('connexion::show');
		$oView->oConnexion=$oConnexion;
		
				$oView->tJoinmodel_type=model_type::getInstance()->getSelect();
		return $oView;
	}
	
	public function _delete(){
		$tMessage=$this->delete();

		$oConnexion=model_connexion::getInstance()->findById( module_connexion::getParam('id') );
		
		$oView=new _view('connexion::delete');
		$oView->oConnexion=$oConnexion;
		
				$oView->tJoinmodel_type=model_type::getInstance()->getSelect();

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}

	public function save(){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$iId=module_connexion::getParam('id',null);
		if($iId==null){
			$oConnexion=new row_connexion;	
		}else{
			$oConnexion=model_connexion::getInstance()->findById( module_connexion::getParam('id',null) );
		}
		
		$tId=model_connexion::getInstance()->getIdTab();
		$tColumn=model_connexion::getInstance()->getListColumn();
		foreach($tColumn as $sColumn){
			 $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oConnexion->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else  if( _root::getParam($sColumn,null) === null ){ 
				continue;
			}else if( in_array($sColumn,$tId)){
				 continue;
			}
			
			$oConnexion->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		if($oConnexion->save()){
			//une fois enregistre on redirige (vers la page liste)
			$this->redirect('list');
		}else{
			return $oConnexion->getListError();
		}
		
	}

	public function delete(){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oConnexion=model_connexion::getInstance()->findById( module_connexion::getParam('id',null) );
				
		$oConnexion->delete();
		//une fois enregistre on redirige (vers la page liste)
		$this->redirect('list');
		
	}
	
	
	
	
}

/*variables
#select		$oView->tJoinconnexion=connexion::getInstance()->getSelect();#fin_select
#uploadsave $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oConnexion->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave
variables*/

