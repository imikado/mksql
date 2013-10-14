<table class="tb_delete">
	
	<tr>
		<th>dsn</th>
		<td><?php echo $this->oConnexion->dsn ?></td>
	</tr>

	<tr>
		<th>login</th>
		<td><?php echo $this->oConnexion->login ?></td>
	</tr>

	<tr>
		<th>pass</th>
		<td><?php echo $this->oConnexion->pass ?></td>
	</tr>

	<tr>
		<th>type</th>
		<td><?php echo $this->tJoinmodel_type[$this->oConnexion->type]?></td>
	</tr>

	<tr>
		<th>nom</th>
		<td><?php echo $this->oConnexion->nom ?></td>
	</tr>

</table>

<form action="" method="POST">
<input type="hidden" name="formmodule" value="connexion" />
<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>

<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo module_connexion::getLink('list')?>">Annuler</a>
</form>

