<?php 
foreach($this->tColumn as $sColumn):
	echo $sColumn?>;<?php 
endforeach;
echo "\n";
foreach($this->tRow as $oRow):
	foreach($this->tColumn as $sColumn):
		echo $oRow->$sColumn?>;<?php 
	endforeach;
	echo "\n";
endforeach;
