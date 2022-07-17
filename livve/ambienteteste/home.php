<?php

	include_once('../funcaophp/consultvisitas.php')

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Boletim - Livve Portária</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css"/>
		<script src="../javascript/jquery-1.11.2.js"></script>
    	<script type="text/javascript" src="../javascript/datetime.js"></script>
	</head>
<body>

	<!-- MENU FIXO  -->

	<div id="menugeral">
	
		<header id="header">
			
			<div class="logo">
				<img src="../img/logo_pq.png" alt="Logo Boletim Opeacional">
			</div>
			<nav id="nav">
				<button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-controls="menu" aria-expanded="false">Menu
			<sapn id="hamburger"></sapn>
		</button>
				<ul id="menu" role="menu">
					<li><a href="../index.html">Inicio</a></li>
					<li><a href="home.html">Contato</a></li>
					<li><a href="">N.A. Open</a></li>
					<li><a href="">N.A. Consulta</a></li>
					<li><a href="">Administrativo</a></li>
				</ul>
			</nav>
		</header>

		<div id="cont_ge_menu">
			<div class="fundo_titulo_menu">
						
				<div class="menu_logo2">
					<img src="../img/logo_livve_pq.png" alt="Livve Portaria Remota">
				</div> 
	
				<div class="menu_logo3">
					<img src="../img/logo_century_pq.png" alt="Century Seguraça Eletrônica">
				</div>
			
			</div>
			
			<div id="relogio_menu">
					
				<div id="showtime" class="hora">

				<output id="hora"></output>\ - /<output id="data"></output>
				        		
				</div>
		
			</div>
			
		</div>	
	</div>

	<!-- INICIO DA ESTRUTURA DO CONTEUDO GERAL -->

	<div id="conteudogeraldapagina">
		
		<div class="container_infor">

			<section id="sessao">
				<h1>Cadastro de Usúarios</h1>
				
				<hr><br>

				<form method="post" action="processa.php">
					<input type="submit" value="Salvar" class="btn-post">
					<input type="reset" value="Limpar" class="btn-post">
					<br><br>

					Hora/Data Registro: 
					<output id="horavisivel"></output> - <output id="datavisivel"></output>
					<input type="hidden" id="datadb" name="d_registro" class="campo" require maxlength="11" value="">
					<input type="hidden" id="horadb" name="h_registro" class="campo" required maxlength="9" value="">
					<input type="hidden" name="ip_registro" class="campo" required maxlength="16" value="<?php echo "$ip" ?>"><br><br>
					Nome:<br>
					<input type="text" name="nome" class="campo" maxlength="40" required autofocus><br>
					E-mail:<br>
					<input type="email" name="email" class="campo" maxlength="50" required><br>
					Sexo:<br>
					<input type="text" name="sexo" class="campo" maxlength="10" required><br>
					Profissão:<br>
					<input type="text" name="profissao" class="campo" maxlength="40" required>
					
					
				<br><br>
			</section>

			<nav id="navtwo">
				<ul class="menutwo">
					<a href="home.php"><li>Cadastro</li></a>
					<a href="consulta.php"><li>Consultas</li></a>
				</ul>
			</nav>
			
		</div>
	</div>	

	
	
</body>
		<script src="../javascript/funcoes.js"></script>
</html>