<?php
/*
This file is part of Mkframework.

Mkframework is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License.

Mkframework is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Mkframework.  If not, see <http://www.gnu.org/licenses/>.

*/
/** 
* plugin_tpl classe d'aide de template
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_template{

	private $sHtml;
	private $oFileTpl;
	private $oTplApp;
	
	static protected $tAlternate;
	
	/** la classe est cree par _tpl, donc cette partie n'est pas a connaitre en principe
	* constructeur
	* @access public
	* @param string $sRessource adresse de la vue cible (fichier produit par le plugin)
	*/
	public function __construct($sRessource){
		$this->oFileTpl=new _file($sRessource);
		if($this->oFileTpl->exist() and _root::getConfigVar('site.mode')!='dev'){ return; }
		
		if(_root::getConfigVar('template.class_app',null)!=''){
			$sClass=_root::getConfigVar('template.class_app');
			$this->oTplApp=new $sClass;
		}
		$this->parse($sRessource._root::getConfigVar('template.extension'));
	}
	
	/** retourne en alternance une valeur du tableau $tab, 
	 * un deuxieme argument (optionnel) permet d'avoir plusieurs lots d'alternance
	* @access public
	* @param array $tab tableau contenant les valeurs a alterner
	* @param string $uRef
	*/
	public static function alternate($tab,$uRef=0){
		if(!isset(self::$tAlternate[$uRef])){
			self::$tAlternate[$uRef]=0;
		}else{
			self::$tAlternate[$uRef]+=1;
		}
		if(self::$tAlternate[$uRef] >= count($tab)){
			self::$tAlternate[$uRef]=0;
		}
		return $tab[self::$tAlternate[$uRef] ];
	}
	
	
	private function parseContent($sContent){
		$sContent=preg_replace('/\{\{(.*)\}\}/','<?php echo $1?>',$sContent);
		return $sContent;
	}

	private function getCode($sLigne){
		
		$sPhp='[a-zA-Z0-9\s\n\r\-_\:;\/\+\=\<\>\(\)\$\[\]]*';
		//$sPhp='.*';

		$tPattern=array(
			array('/<!--foreach('.$sPhp.')-->/' 	, '<?php foreach($1):?>'),
			array('/<!--endforeach('.$sPhp.')-->/'	, '<?php endforeach;?>'),
			array('/<!--for('.$sPhp.')-->/'		, '<?php for($1):?>'),
			array('/<!--endforeach('.$sPhp.')-->/'	, '<?php endfor;?>'),
			array('/<!--php('.$sPhp.')-->/'		, '<?php $1 ?>'),
			array('/<!--echo('.$sPhp.')-->/'		, '<?php echo $1 ?>'),

			array('/<!--if('.$sPhp.')-->/'		, '<?php if($1):?>'),
			array('/<!--elsif('.$sPhp.')-->/'	, '<?php elsif($1):?>'),
			array('/<!--else('.$sPhp.')-->/'		, '<?php else:?>'),
			array('/<!--endif('.$sPhp.')-->/'	, '<?php endif;?>'),
		
		);
	

		foreach($tPattern as $tRendu){
			$sPattern=$tRendu[0];
			$sRendu=$tRendu[1];
		
			$sLigne= preg_replace($sPattern,$sRendu,$sLigne);
		}
		return $sLigne;
	}
	private function parse($sFileXml){
		
		$oFile=new _file($sFileXml);
		
		$this->sHtml.=$this->getCode( $oFile->getContent() );
		
		$this->oFileTpl->setContent($this->sHtml);
		$this->oFileTpl->save();
	
	}
	
	

}
