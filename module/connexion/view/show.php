<table class="tb_show">
	
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
<p><a href="<?php echo module_connexion::getLink('list')?>">Retour</a></p>

