<?php 
class module_default extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
	}
	
	private function loadConnexion($id){
		$oConnexion=model_connexion::getInstance()->findById($id);
			
		_root::setConfigVar('db.profil.dsn',$oConnexion->dsn);
		_root::setConfigVar('db.profil.sgbd',$oConnexion->findTypeSgbd()->sgbd);
		_root::setConfigVar('db.profil.username',$oConnexion->login);
		_root::setConfigVar('db.profil.password',$oConnexion->pass);
	}
	
	public function _index(){
		
		$tConnexion=model_connexion::getInstance()->getSelect();
		
		$tSave=model_requete::getInstance()->getSelect();
		
		$idConnexion=_root::getParam('connexion');
		
		if($idConnexion){
			$this->loadConnexion($idConnexion);
			
			$sCode=null;
			
			$idRequest=_root::getParam('request');
			$oRequest=model_requete::getInstance()->findById($idRequest);
			if($oRequest){
				$sCode=$oRequest->code;
			}
			
			$oModel=model_bdd::getInstance();
			$oSgbd=$oModel->getSgbd();
			
			$tRichTable=array();
			
			$tTable=$oSgbd->getListTable();
			foreach($tTable as $sTable){
				$tRichTable[$sTable]=$oSgbd->getListColumn($sTable);
			}
			
			$oView=new _view('default::index');
			$oView->tTable=$tTable;
			$oView->tRichTable=$tRichTable;
			
			$oView->tConnexion=$tConnexion;
			$oView->tSave=$tSave;
			
			$oView->sCode=$sCode;
			
			$this->oLayout->add('main',$oView);
			
		}else{
			
			
			$oView=new _view('default::empty');
			$oView->tConnexion=$tConnexion;
			$this->oLayout->add('main',$oView);
			
			//instancier le module
			$oModuleConnexion=new module_connexion;

			//si vous souhaitez indiquer au module integrable des informations sur le module parent
			$oModuleConnexion->setRootLink('default::index');

			//recupere la vue du module
			$oView=$oModuleConnexion->_index();

			//assigner la vue retournee a votre layout
			$this->oLayout->add('main',$oView);
		}
		
		
	}
	
	public function _execute(){
		$idConnexion=_root::getParam('connexion');
		$this->loadConnexion($idConnexion);
		
		$sql=$_POST['sql'];
		
		$sColumn=$_POST['sColumn'];
		$tColumn=preg_split('/,/',$sColumn);
		
		$tRow=model_bdd::getInstance()->findMany($sql);
		
		$oView=new _view('default::execute');
		$oView->tRow=$tRow;
		$oView->tColumn=$tColumn;
		
		echo $oView->show();
		exit;
	}
	
	public function _export(){
		
		$sql=_root::getParam('sql');
		
		$idConnexion=_root::getParam('connexion');
		$this->loadConnexion($idConnexion);
		
		$sColumn=$_POST['sColumn'];
		$tColumn=preg_split('/,/',$sColumn);
		
		$tRow=model_bdd::getInstance()->findMany($sql);
		
		$oView=new _view('default::csv');
		$oView->tRow=$tRow;
		$oView->tColumn=$tColumn;
		
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename=Export.csv');
		echo $oView->show();
		exit;
	}
	
	public function after(){
		$this->oLayout->show();
	}
}
