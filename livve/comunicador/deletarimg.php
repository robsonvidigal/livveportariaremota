<?php

$dir ='/comunicador/img_enviada/';
//$dir ='/comunicador/img_enviada/';  
$aberto = @opendir($dir);//abre o diretorio 
while($arq = @readdir($aberto)) {//le o diretorio
	if(($arq != '.') && ($arq != '..')) {//desconsidera subdiretorios
		@unlink('img_enviada/'.$arq); //apaga as imagens
	}
}
@closedir($aberto);
?>