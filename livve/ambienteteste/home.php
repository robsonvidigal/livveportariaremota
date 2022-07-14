<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Boletim - Livve Portária</title>
		<link rel="stylesheet" type="text/css" href="../css/estilo.css"/>
		<script type="text/javascript" src="../javascript/ajax.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
				
				<div id="hms" class="hora" onload="showTime()"></div>
		
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

					Nome:<br>
					<input type="text" name="nome" class="campo" maxlength="40" required autofocus><br>
					E-mail:<br>
					<input type="email" name="email" class="campo" maxlength="50" required><br>
					Sexo:<br>
					<input type="text" name="sexo" class="campo" maxlength="10" required><br>
					Profissão:<br>
					<input type="text" name="profissao" class="campo" maxlength="40" required>
				</form>
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
		
	
	<script src="../javascript/funcoes.js"></script>
	<script src="../javascript/relogio.js"></script>
</body>
</html>