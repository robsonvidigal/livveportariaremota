//Estrutura hora e data

       jQuery(window).load(function($){
				atualizaRelogio();
			});


            function atualizaRelogio(){ 
                var momentoAtual = new Date();
                
                var vhora = momentoAtual.getHours();
                var vminuto = momentoAtual.getMinutes();
                var vsegundo = momentoAtual.getSeconds();
                
                var vdia = momentoAtual.getDate();
                var vmes = momentoAtual.getMonth() + 1;
                var vano = momentoAtual.getFullYear();
                
                if (vdia < 10){ vdia = "0" + vdia;}
                if (vmes < 10){ vmes = "0" + vmes;}
                if (vhora < 10){ vhora = "0" + vhora;}
                if (vminuto < 10){ vminuto = "0" + vminuto;}
                if (vsegundo < 10){ vsegundo = "0" + vsegundo;}

                //Estrutura da Data   

            //Dias da semana
            diaNome = new Array ("domingo", "segunda-feira", "terça-feira", "quarta-feira", "quinta-feira", "sexta-feira", "sábado");
            mesNome = new Array ("janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
            agora = new Date ();
    
                dataFormat = diaNome[agora.getDay()] + ", " + agora.getDate() + " de " + mesNome[agora.getMonth()] + " de " + agora.getFullYear();
                horaFormat = vhora + ":" + vminuto + ":" + vsegundo + "   ";
                dataVisFormat = vdia + "/" + vmes + "/" + vano;
                horaVisFormat = vhora + ":" + vminuto + ":" + vsegundo;
                dataSqlFormat = vdia + "/" + vmes + "/"+ vano;
                horaSqlFormat = vhora + ":" + vminuto + ":" + vsegundo;
    
                document.getElementById("data").innerHTML = dataFormat;
                document.getElementById("hora").innerHTML = horaFormat;
                document.getElementById("datadb").value = dataSqlFormat;
                document.getElementById("horadb").value = horaSqlFormat;
                document.getElementById("datavisivel").innerHTML = dataVisFormat;                
                document.getElementById("horavisivel").innerHTML = horaVisFormat;
    
                setTimeout("atualizaRelogio()",1000);
            }
