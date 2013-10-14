<style>
.popup{
	top:0px;
	right:0px;
	position:absolute;
	border:2px solid black;
	width:300px;
	background:#fff;
	z-index:10;
}
.popup p{
	margin-top:0px;
	background:black;
	color:white;
}

.popup2{
 	border:2px solid black;
	width:210px;
	background:#fff;
	position:absolute;
	z-index:10;
}
.popup2 p{
	margin-top:0px;
	background:black;
	color:white;
	text-align:center;
	padding:6px;
}
.popup2 p a{
	color:white;
	text-decoration:none;
}
.popup2 .column{
	padding:8px;
}
.link{
	list-style:none;
	padding:4px;
}
.link li{
	margin-left:0px;
}
.link li a{
	padding:4px;
	text-decoration:none;
	display:block;
	border:1px solid gray;
	background:#ddd;
	margin-bottom:4px;
}
.link li a:hover{
	background:#bbb;
}
.popup h1{
	margin-top:0px;
	background:#ddd;
}
table td{
	border-collapse:collapse;
}
</style>
<script>
var tTable=new Array();
var tColumn=new Array();
var tColumnSimple=new Array();
var tWhere=new Array();

var tColumnWhere=new Array();
var itColumnWhere=0;

var tJoin=new Array();
var iJoin=0;

var uid=0;
var iColumnJoin=0;
var iColumnWhere=0;
var iFieldJoinToShow=0;
var iFieldSelectToShow=0;

function chooseConnexion(id){
	document.location.href='index.php?:default::index&connexion='+id;
}
function chooseSave(id){
	document.location.href='index.php?:default::index&connexion=<?php echo _root::getParam('connexion')?>&request='+id;
}

function addTable(id){
	//var a=getById('orig'+id).innerHTML;
	var dv = document.createElement("div");
	
	var sDiv='<div id="table'+id+'" class="popup2" style="top:0px;left:0px">';
	sDiv+='<p style="cursor:move" onmousedown="dragg(\''+id+'\')" onmouseup="drawJoin()">'+id+'</p>';
	sDiv+='<div class="column">';
			sDiv+='<table>';
				sDiv+='<tr>';
					sDiv+='<th style="background:#fff;" id="fieldSelectToShow_'+iFieldSelectToShow+'">Show</th>';
					iFieldSelectToShow+=1;
					sDiv+='<th style="background:#fff;display:none" id="fieldJoinToShow_'+iFieldJoinToShow+'">FK</th>';
					iFieldJoinToShow+=1;
					sDiv+='<th style="background:#fff;"></th>';
					sDiv+='<th style="background:#fff" id="fieldSelectToShow_'+iFieldSelectToShow+'">WHERE</th>';
					iFieldSelectToShow+=1;
				sDiv+='</tr>';
				
				
				
				sDiv+='<tr >';
					sDiv+='<td id="fieldSelectToShow_'+iFieldSelectToShow+'">';
						sDiv+='<input  type="checkbox" onclick="selectColumn(\''+id+'\',\'*\',this.checked)" />';
					sDiv+='</td>';
					iFieldSelectToShow+=1;
					
					sDiv+='<td style="display:none" id="fieldJoinToShow_'+iFieldJoinToShow+'"></td>';
					iFieldJoinToShow+=1;
					
					sDiv+='<td>';
						sDiv+='*';
					sDiv+='</td>';
					sDiv+='<td id="fieldSelectToShow_'+iFieldSelectToShow+'">';
						//sDiv+='<input style="display:none" id="joinTableColumn_'+iColumnJoin+'" type="checkbox" onclick="selectColumnJoin(\''+id+'\',\''+sColumn+'\',this.checked)" />';
					sDiv+='</td>';
					iFieldSelectToShow+=1;
					//sDiv+='<td></td>';
				sDiv+='</tr>';
				
				
			for(var i=0;i<tColumnTable[id].length;i++){
				if(tColumnTable[id][i]){
					var sColumn=tColumnTable[id][i];
					
					var sCheck='';
					if(tColumn.indexOf(id+'.'+sColumn) >-1){
						sCheck='checked="checked"';
					}
					console.log( 'table '+id+' itColumnWhere:'+itColumnWhere);
					var sWhereValue='';
					for(var k=0;k<itColumnWhere;k++){
						if(tColumnWhere[k]['column']==id+'.'+sColumn){
							sWhereValue=tColumnWhere[k]['value'];
							console.log( tColumnWhere[k]['column'] +'=='+ id+'.'+sColumn);
							break;
						}else{
							//console.log( tColumnWhere[j]['column'] +'=='+ id+'.'+sColumn);
						}
					}
				
					sDiv+='<tr>';
						sDiv+='<td id="fieldSelectToShow_'+iFieldSelectToShow+'">';
							sDiv+='<input type="checkbox" '+sCheck+' id="showColumn_'+iColumnWhere+'" onclick="selectColumn(\''+id+'\',\''+sColumn+'\',this.checked)" />';
						sDiv+='</td>';
						iFieldSelectToShow+=1;
						
						sDiv+='<td style="display:none" id="fieldJoinToShow_'+iFieldJoinToShow+'">';
							sDiv+='<input type="checkbox" onclick="selectColumnJoin(\''+id+'\',\''+sColumn+'\',this.checked)" />';
						sDiv+='</td>';
						iFieldJoinToShow+=1;
						
						sDiv+='<td>';
							sDiv+=sColumn;
						sDiv+='</td>';
						
						sDiv+='<td id="fieldSelectToShow_'+iFieldSelectToShow+'">';
							sDiv+='<input type="hidden" id="whereColumn_'+iColumnWhere+'" value="'+id+'.'+sColumn+'" />';
							sDiv+='<input style="width:54px;" id="whereValue_'+iColumnWhere+'" value="'+sWhereValue+'" onBlur="clearWhereColumn();generateSql()"/>';
						sDiv+='</td>';
						iFieldSelectToShow+=1;
					sDiv+='</tr>';
					
					iColumnJoin+=1;
					iColumnWhere+=1;
					
					
				}
			}
			sDiv+='</table>';
		sDiv+='</div>';
	sDiv+='</div>';
	
	

	
	dv.innerHTML+=sDiv;	
	getById('content').appendChild(dv);
	
	uid+=1;
	tTable.push(id);
	
	generateSql();
}
function dragg(sid){
	$(function() {
		$( '#table'+sid ).draggable();
	});
}
function dragg2(sid){
	$(function() {
		$( '#'+sid ).draggable();
	});
}
function selectColumn(sTable,sColumn,bCheck){
	if(bCheck){
		tColumn.push(sTable+'.'+sColumn);
		tColumnSimple.push(sColumn);
	}else{
		removeColumn(sTable,sColumn);
	}
	generateSql();
}
function removeColumn(sTable,sColumn){
	var tmpColumn=new Array();
	var tmpColumnSimple=new Array();
	
	for(var i=0;i<tColumn.length;i++){
		if(tColumn[i] && tColumn[i]==sTable+'.'+sColumn){
			 
		}else if(tColumn[i]){
			tmpColumn.push(tColumn[i]);
			tmpColumnSimple.push(tColumnSimple[i]);
		}
	}
	tColumn=new Array();
	tColumnSimple=new Array();
	
	tColumn=tmpColumn;
	tColumnSimple=tmpColumnSimple;
	
	
}
function clearWhereColumn(){
	itColumnWhere=0;
	tColumnWhere=new Array();
}
function generateSql(){
	
	
	loadWhere();
	
	var sql='';
	sql='SELECT ';
	sql+=tColumn.join(',');
	sql+=' FROM  ';
	sql+=tTable.join(',');
	
	for(var i=0;i<iColumnWhere;i++){
		var a=getById('whereValue_'+i);
		if(a && a.value!=''){
			var sColumnWhere=getById('whereColumn_'+i).value;
			tWhere.push(sColumnWhere+'='+a.value);
			
			tColumnWhere[itColumnWhere]=new Array();
			tColumnWhere[itColumnWhere]['column']=sColumnWhere;
			tColumnWhere[itColumnWhere]['value']=a.value;
			
			itColumnWhere+=1;
			
		}
	}
	
	if(tWhere.length > 0){
		sql+=' WHERE '+tWhere.join(' AND ');
	}
	
	getById('sql').value=sql;
	
	getById('sColumn').value=tColumnSimple.join(',');
	
}
var tmpJoin=null;

function addJoin(iUid,sId){
	if(tmpJoin==null){
		tJoin[iJoin]=new Array();
		tJoin[iJoin]['from']=new Array(iUid,sId);
		
		getById('fromJoin').value=sId;
		
		tmpJoin=1;
	}else{
		tJoin[iJoin]['to']=new Array(iUid,sId);
		
		getById('fromTo').value=sId;
		
		tmpJoin=null;
		iJoin+=1;
		
		drawJoin();
	}
	
}
function drawJoin(){
	
	
	// get the canvas element using the DOM
  var canvas = document.getElementById('myCanvas');
 
  // Make sure we don't execute when canvas isn't supported
  if (canvas.getContext('2d')){
 
    // use getContext to use the canvas for drawing
    var ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
 
	for(var i=0;i<=tJoin.length;i++){
		
		if(tJoin[i]){
		
			var oFrom=getById('table'+tJoin[i]['from']);
			var iFromY=parseInt(oFrom.style.top)+10;
			var iFromX=parseInt(oFrom.style.left)+100;
			
			var oTo=getById('table'+tJoin[i]['to']);
			var iToY=parseInt(oTo.style.top)+10;
			var iToX=parseInt(oTo.style.left)+100;
			
			ctx.beginPath();
			ctx.moveTo(iFromX,iFromY);
			ctx.lineTo(iToX,iToY);
			ctx.closePath();
			ctx.stroke();
			
			var newX=(iFromX+iToX)/2-20;
			var newY=(iFromY+iToY)/2;
			
			ctx.font = "12px Arial";
			
			var metrics=ctx.measureText(tJoin[i]['link']);
			
			ctx.beginPath();
			ctx.rect( newX,newY, metrics.width+10, 20);
			ctx.fillStyle = 'black';
			ctx.fill();
			ctx.strokeStyle = 'black';
			ctx.stroke();
			
			ctx.strokeStyle = 'white';
			
			
			ctx.fillStyle = 'white';
			ctx.fillText(tJoin[i]['link'],newX+4,newY+15);
			
			ctx.strokeStyle = 'black';
			
			//alert(iFromY+' '+iFromX+' & '+iToY+' '+iToX);
			
			//alert('draw');
		}
	}
  
    /*
    // Stroked triangle
    ctx.beginPath();
    ctx.moveTo(125,125);
    ctx.lineTo(125,45);
    ctx.closePath();
    ctx.stroke();*/
    
    
 
  } else {
    alert('You need Safari or Firefox 1.5+ to see this demo.');
  }
}
function addJoinPopup(){
	getById('popupJoin').style.display="block";
	getById('fromJoin').value=null;
	getById('fromJoinField').value=null;
	getById('toJoin').value=null;
	getById('toJoinField').value=null;
	
	showAllJoinButton();
}
function showAllJoinButton(){
	/*for(var i=0;i<iColumnJoin;i++){
		var a=getById('joinTableColumn_'+i);
		if(a){
			a.style.visibility="visible";
			a.checked=false;
		}
		var b=getById('whereValue_'+i);
		if(b){
			b.style.visibility="hidden";
		}
		var c=getById('showColumn_'+i);
		if(c){
			c.style.visibility="hidden";
		}
	}	*/
	for(var i=0;i<iFieldSelectToShow;i++){
		var a=getById('fieldSelectToShow_'+i);
		if(a){
			a.style.display="none";
		}
	}
	for(var i=0;i<iFieldJoinToShow;i++){
		var a=getById('fieldJoinToShow_'+i);
		if(a){
			a.style.display="block";
		}
	}
}
function hideAllJoinButton(){
	/*for(var i=0;i<iColumnJoin;i++){
		var a=getById('joinTableColumn_'+i);
		if(a){
			a.style.visibility="hidden";
		}
		var b=getById('whereValue_'+i);
		if(b){
			b.style.visibility="visible";
		}
		var c=getById('showColumn_'+i);
		if(c){
			c.style.visibility="visible";
		}
	}*/
	for(var i=0;i<iFieldSelectToShow;i++){
		var a=getById('fieldSelectToShow_'+i);
		if(a){
			a.style.display="block";
		}
	}
	for(var i=0;i<iFieldJoinToShow;i++){
		var a=getById('fieldJoinToShow_'+i);
		if(a){
			a.style.display="none";
		}
	}
}
var sJoinColumn=null;
function selectColumnJoin(sTable,sColumn,bChecked){
	
	if(sJoinColumn==null){
		getById('fromJoin').value=sTable;
		getById('fromJoinField').value=sColumn;
		
		sJoinColumn=1;
	}else{
		getById('toJoin').value=sTable;
		getById('toJoinField').value=sColumn;
		sJoinColumn=null;
	}
}
function addJoinSql(){
	var sLink=getById('fromJoin').value+'.'+getById('fromJoinField').value+'='+ getById('toJoin').value+'.'+getById('toJoinField').value;
	
	tJoin[iJoin]=new Array();
	tJoin[iJoin]['from']=getById('fromJoin').value;
	tJoin[iJoin]['to']=getById('toJoin').value;
	tJoin[iJoin]['link']=sLink;
	
	iJoin+=1;
	
	generateSql();
	drawJoin();
	
	getById('popupJoin').style.display='none';
	
	hideAllJoinButton();
	
	showJoinLinks();
}
function hidePopupJoinSql(){
	getById('popupJoin').style.display='none';
	
	hideAllJoinButton();
}

function disable(obj){
	obj.style.display="none";
}
function disableById(id){
	var obj=getById(id);
	if(obj){
		obj.style.display="none";
	}
}
function showJoinLinks(){
	var sHtml='<h1>Jointures</h1>';
	
	for(var i=0;i<tJoin.length;i++){
		var sLink=tJoin[i]['link'];
		sHtml+='<p style="background:#fff"><input id="joinLink_'+i+'" style="width:250px" value="'+sLink+'"/> </p>';
	}
	sHtml+='<p style="background:#fff;text-align:right"><input onclick="updateJoinLinks()" type="button" value="Modifier les liens"/></p>';
	getById('popupJoinLinks').innerHTML=sHtml;
	
	getById('popupJoinLinks').style.display="block";
}
function updateJoinLinks(){
	loadWhere();
	
	generateSql();
	drawJoin();
}
function loadWhere(){
	tWhere=new Array();
	
	for(var i=0;i<tJoin.length;i++){
		var a=getById('joinLink_'+i);
		if(a){
			tJoin[i]['link']=a.value;
		}
		tWhere.push(tJoin[i]['link']);
	}
}

function save(){
	
		var sNext='__NEXT__'; 
		var sSep='__SEP__';
		var sSection="\n";

		var sSave='';
		
			sSave+='tTable:';
			sSave+=tTable.join(sNext);
		
		sSave+=sSection;
		
			sSave+='tCoord:';
			for(var i=0;i<tTable.length;i++){
				var a=getById('table'+tTable[i]);
				
				if(a && a.style){
					sSave+='table'+tTable[i];
					sSave+=sSep;
					sSave+=a.style.top;
					sSave+=sSep;
					sSave+=a.style.left;
					sSave+=sNext;
				}
			}
			
		sSave+=sSection;
		
			sSave+='tJoin:';
			for(var i=0;i<tJoin.length;i++){
				if(tJoin[i]){
					sSave+=tJoin[i]['from'];
					sSave+=sSep;
					sSave+=tJoin[i]['to'];
					sSave+=sSep;
					sSave+=tJoin[i]['link'];
					sSave+=sNext;
				}				
			}
		
		sSave+=sSection;
			
			sSave+='tColumn:';
			for(var i=0;i<tColumn.length;i++){
				if(tColumn[i]){
					sSave+=tColumn[i];
					sSave+=sSep;
				}
			}
		sSave+=sSection;
			
			sSave+='tColumnSimple:';
			for(var i=0;i<tColumnSimple.length;i++){
				if(tColumnSimple[i]){
					sSave+=tColumnSimple[i];
					sSave+=sSep;
				}
			}
			
			
			
		sSave+=sSection;
			sSave+='tColumnWhere:';
			for(var i=0;i<itColumnWhere;i++){
				if(tColumnWhere[i]){
					sSave+=tColumnWhere[i]['column'];
					sSave+=sSep;
					sSave+=tColumnWhere[i]['value'];
					sSave+=sNext;
				}
			}

		sSave+=sSection;
		
		getById('txtsave').value=sSave;
		
		var sRequestName=prompt('Enregistrer sous',getById('requestName').value);
		
		getById('requestName').value=sRequestName;
		
		getById('saveForm').submit();
}
function loadsql(){
		getById('sqlForCsv').value=getById('sql').value;
		getById('sColumnForCsv').value=getById('sColumn').value;
}

var tColumnTable=new Array();
<?php foreach($this->tRichTable as $sTable => $tColumn):?>
tColumnTable['<?php echo $sTable?>']=new Array();
	<?php foreach($tColumn as $sColumn):?>
		tColumnTable['<?php echo $sTable?>'].push('<?php echo $sColumn?>');
	<?php endforeach;?>
<?php endforeach;?>
</script>


<canvas id="myCanvas" width="1200" height="500" style="position:absolute;z-index:1;top:1px;left:1px;border:1px solid #000000;">
</canvas>



<div id="content"></div>
<div style="position:absolute;top:500px;left:0px;">
	<form action="index.php?:nav=default::execute" method="POST" target="execute">
		<input type="hidden" name="sColumn" id="sColumn"/>
		<input type="hidden" name="connexion" value="<?php echo _root::getParam('connexion')?>"/>
		<textarea name="sql" style="width:1200px;height:100px" id="sql"></textarea>
		<p style="margin:0px;text-align:right"><input type="submit" value="Execute"></p>
	</form>
	<form style="float:right" action="index.php?:nav=default::export" method="POST" target="_blank" onsubmit="loadsql()">
		<input type="hidden" name="connexion" value="<?php echo _root::getParam('connexion')?>"/>
		<input type="hidden" name="sColumn" id="sColumnForCsv"/>
		<textarea name="sql" id="sqlForCsv" style="display:none" ></textarea>
		<input type="submit" value="Export to Csv"/>
	</form>
</div>


<div style="position:absolute;top:700px;left:0px;">

	<iframe src="" style="width:1200px;border:1px solid gray;background:#eee" id="execute" name="execute"></iframe>
</div>


<?php /*
<?php foreach($this->tRichTable as $sTable => $tColumn):?>
<div id="orig<?php echo $sTable?>" style="display:none">
	
		
		<div class="column">
			<table>
				<tr>
					<th style="background:#fff;text-align:left" colspan="2">Champ &agrave; afficher</th>
					<th style="background:#fff" >FK</th>
				</tr>
				
			<?php foreach($tColumn as $sColumn):?>
				<tr>
					<td>
						<input type="checkbox" onclick="selectColumn('<?php echo $sTable?>','<?php echo $sColumn?>',this.checked)" />
					</td>
					<td>
						<?php echo $sColumn?>
					</td>
					<td>
						<input type="checkbox" onclick="selectColumnJoin('<?php echo $sTable?>','<?php echo $sColumn?>',this.checked)" />
					</td>
				</tr>
			<?php endforeach;?>
			</table>
		</div>
		
	</div>
</div>
<?php endforeach;?>
*/?>




<div class="popup" id="popupAddTable" style="top:30px">
<p  class="fermer" style="cursor:move" onmousedown="dragg2('popupAddTable')">&nbsp;</p>
<ul class="link">
	<?php foreach($this->tTable as $sTable):?>
	<li><a href="#" id="link<?php echo $sTable?>" onclick="addTable('<?php echo $sTable?>');disable(this)"><?php echo $sTable?></a></li>
	<?php endforeach;?>
	
	<li style="margin-top:20px"><a href="#" onclick="addJoinPopup()">Ajouter jointure</a></li>
</ul>
</div>

<div class="popup" style="display:none;top:300px;" id="popupJoin">
	<p class="fermer"  style="cursor:move;text-align:right" onmousedown="dragg2('popupJoin')"><a href="#" style="color:white" onclick="hidePopupJoinSql();return false;">Fermer</a></p>
	<p style="background:#fff;color:#000">Select the fields to join : click on checkbox</p>
	<table>
		<tr>
			<th style="background:#fff">
				From <input type="hiddena" id="fromJoin"/><input id="fromJoinField"/>
			</th>
			
			<th style="background:#fff">
				 to<input type="hiddena" id="toJoin"/> <input id="toJoinField"/>

			</th>
		</tr>
		
	</table>
	<p style="background:#fff;text-align:right"><input type="button" onclick="addJoinSql()" value="Ajouter"/></p>
</div>

<div class="popup" style="top:420px;display:none;" id="popupJoinLinks"></div>

<div style="position:absolute;right:0px;top:0px">
Connexion
<select onchange="chooseConnexion(this.value)">
	<option value="">Retour &agrave; la liste des connexions</option>
	<?php foreach($this->tConnexion as $id => $nom):?>
	<option <?php if($id==_root::getParam('connexion')):?>selected="selected"<?php endif;?> value="<?php echo $id?>"><?php echo $nom?></option>
	<?php endforeach;?>
</select>

&nbsp; | &nbsp; Sauvegarde
<?php $sRequestName=null;?>
<select onchange="chooseSave(this.value)">
	<option value="">Nouveau</option>
	<?php foreach($this->tSave as $id => $sSave):?>
	<option <?php if($id==_root::getParam('request')):?>selected="selected"<?php endif;?> value="<?php echo $id?>"><?php echo $sSave?></option>
	<?php if($id==_root::getParam('request')): $sRequestName=$sSave; endif;?>
	<?php endforeach;?>
</select>
<input type="button" value="Enregistrer" onclick="save()"/>
</div>
<form id="saveForm" action="<?php echo _root::getLink('api::requestsave')?>" method="POST" target="frame">
<input type="hidden" name="request" value="<?php echo _root::getParam('request')?>"/>
<input type="hidden" name="requestName" id="requestName" value="<?php echo $sRequestName?>"/>
<textarea name="txtsave" id="txtsave" style="display:none;width:400px;height:200px" id="save"></textarea>
</form>
<iframe style="visibility:hidden;width:1px;height:1px;bottom:0px;right:0px" id="frame" name="frame"></iframe>
<?php if($this->sCode!=''):?>
<script>
	<?php 
	$tCode=preg_split('/\n/',$this->sCode);
	foreach($tCode as $line):
		list($sType,$sDetail)=preg_split('/:/',$line);
		if($sType=='tColumn'):
			$tColumn=preg_split('/__SEP__/',$sDetail);
			foreach($tColumn as $sColumn):
				if($sColumn=='') continue;
				?>
				tColumn.push('<?php echo $sColumn?>');
				<?php
			endforeach;
		elseif($sType=='tColumnSimple'):
			$tColumnSimple=preg_split('/__SEP__/',$sDetail);
			foreach($tColumnSimple as $sColumn):
				if($sColumn=='') continue;
				?>
				tColumnSimple.push('<?php echo $sColumn?>');
				<?php
			endforeach;	
			
		elseif($sType=='tColumnWhere'):
			$tColumnWhere=preg_split('/__NEXT__/',$sDetail);
			foreach($tColumnWhere as $sDetail):
				if(!preg_match('/__SEP__/',$sDetail)){ continue; }
				list($sColumn,$sValue)=preg_split('/__SEP__/',$sDetail);
				?>
				tColumnWhere[itColumnWhere]=new Array();
				tColumnWhere[itColumnWhere]['column']='<?php echo $sColumn?>';
				tColumnWhere[itColumnWhere]['value']='<?php echo $sValue?>';
				
				itColumnWhere+=1;
				<?php
			endforeach;
		endif;
	endforeach;
	
	foreach($tCode as $line):
		list($sType,$sDetail)=preg_split('/:/',$line);
		if($sType=='tTable'):
				$tTable=preg_split('/__NEXT__/',$sDetail);
				foreach($tTable as $sTable):
					?>
					addTable('<?php echo $sTable?>');
					disableById('link<?php echo $sTable?>');
					<?php
				endforeach;
		elseif($sType=='tCoord'):
			$tCoord=preg_split('/__NEXT__/',$sDetail);
			foreach($tCoord as $sDetail):
				if(!preg_match('/__SEP__/',$sDetail)){ continue; }
				list($sTable,$sTop,$sLeft)=preg_split('/__SEP__/',$sDetail);
				?>
				getById('<?php echo $sTable?>').style.top='<?php echo $sTop?>';
				getById('<?php echo $sTable?>').style.left='<?php echo $sLeft?>';
				<?php
			endforeach;
		elseif($sType=='tJoin'):
			$tJoin=preg_split('/__NEXT__/',$sDetail);
			foreach($tJoin as $sDetail):
				if(!preg_match('/__SEP__/',$sDetail)){ continue; }
				list($sFrom,$sTo,$sLink)=preg_split('/__SEP__/',$sDetail);
				?>
				tJoin[iJoin]=new Array();
				tJoin[iJoin]['from']='<?php echo $sFrom?>';
				tJoin[iJoin]['to']='<?php echo $sTo?>';
				tJoin[iJoin]['link']='<?php echo $sLink?>';
				
				iJoin+=1;
				<?php
			endforeach;
			
			?>					
			showJoinLinks();
			<?php
		endif;
	endforeach;
	?>
	generateSql();
	drawJoin();
</script>
<?php endif;?>
