<table class="tb_list">
	<tr>
		
		<th>dsn</th>

		<th>type</th>

		<th>nom</th>

		<th></th>
	</tr>
	<?php if($this->tConnexion):?>
	<?php foreach($this->tConnexion as $oConnexion):?>
	<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
		
		<td><?php echo $oConnexion->dsn ?></td>

		<td><?php if(isset($this->tJoinmodel_type[$oConnexion->type])){ echo $this->tJoinmodel_type[$oConnexion->type];}else{ echo $oConnexion->type ;}?></td>

		<td><?php echo $oConnexion->nom ?></td>

		<td>
			
			<a href="<?php echo module_connexion::getLink('edit',array(
													'id'=>$oConnexion->getId()
												) 
										)?>">Editer</a>
			|
			<a href="<?php echo module_connexion::getLink('show',array(
													'id'=>$oConnexion->getId()
												) 
										)?>">Afficher</a>
			|
			<a href="<?php echo module_connexion::getLink('delete',array(
													'id'=>$oConnexion->getId()
												) 
										)?>">Supprimer</a>
		</td>
	</tr>	
	<?php endforeach;?>
	<?php endif;?>
</table>
<p><a href="<?php echo module_connexion::getLink('new') ?>">Nouvelle connexion</a></p>

