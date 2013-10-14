<?php 
class module_api extends abstract_module{
	
	public function _requestsave(){
		
		$id=_root::getParam('request');
		$oRequest=model_requete::getInstance()->findById($id);
		if(!$oRequest){
			$oRequest=new row_requete;
		}
		
		$oRequest->code=_root::getParam('txtsave');
		$oRequest->nom=_root::getParam('requestName');
		$oRequest->save();
		
		print "save";
	}
	
}
