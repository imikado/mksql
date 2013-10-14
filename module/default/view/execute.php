<style>
*{
		font-family:arial;
}
table{
	border-collapse:collapse;
}
table td,table th{
	border:1px solid black;
	background:#fff;
}
table th{
	background:#ccc;
}
</style>
<table>
	<?php foreach($this->tColumn as $sColumn):?>
	<th><?php echo $sColumn?></th>
	<?php endforeach;?>
<?php foreach($this->tRow as $oRow):?>
<tr>
	<?php foreach($this->tColumn as $sColumn):?>
	<td><?php echo $oRow->$sColumn?></td>
	<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>
