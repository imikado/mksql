<?php $oPluginHtml=new plugin_html?>
<form action="" method="POST" >
<input type="hidden" name="formmodule" value="connexion" />

<table class="tb_edit">
	
	<tr>
		<th>dsn</th>
		<td><input name="dsn" value="<?php echo $this->oConnexion->dsn ?>" /><?php if($this->tMessage and isset($this->tMessage['dsn'])): echo implode(',',$this->tMessage['dsn']); endif;?></td>
	</tr>

	<tr>
		<th>login</th>
		<td><input name="login" value="<?php echo $this->oConnexion->login ?>" /><?php if($this->tMessage and isset($this->tMessage['login'])): echo implode(',',$this->tMessage['login']); endif;?></td>
	</tr>

	<tr>
		<th>pass</th>
		<td><input name="pass" value="<?php echo $this->oConnexion->pass ?>" /><?php if($this->tMessage and isset($this->tMessage['pass'])): echo implode(',',$this->tMessage['pass']); endif;?></td>
	</tr>

	<tr>
		<th>type</th>
		<td><?php echo $oPluginHtml->getSelect('type',$this->tJoinmodel_type,$this->oConnexion->type)?><?php if($this->tMessage and isset($this->tMessage['type'])): echo implode(',',$this->tMessage['type']); endif;?></td>
	</tr>

	<tr>
		<th>nom</th>
		<td><input name="nom" value="<?php echo $this->oConnexion->nom ?>" /><?php if($this->tMessage and isset($this->tMessage['nom'])): echo implode(',',$this->tMessage['nom']); endif;?></td>
	</tr>

</table>

<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Modifier" /> <a href="<?php echo module_connexion::getLink('list')?>">Annuler</a>
</form>

