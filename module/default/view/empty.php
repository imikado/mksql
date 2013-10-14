<script>
function chooseConnexion(id){
	document.location.href='index.php?:default::index&connexion='+id;
}
</script>


<p>S&eacute;l&eacute;ctionnez une connexion

<select onchange="chooseConnexion(this.value)">
	<option></option>
	<?php foreach($this->tConnexion as $id => $nom):?>
	<option value="<?php echo $id?>"><?php echo $nom?></option>
	<?php endforeach;?>
</select>
</p>

<h1>Gestion des connexions</h1>
