// Estrutura do relógio

        //Inicio da function showTime 

    function showTime () {
        var date = new Date();
        var hora = date.getHours();
        var minuto = date.getMinutes();
        var segundo = date.getSeconds();
        var session = "AM";

        //Condição da utilização de saudação - Bom dia/Boa Tarde e Boa noite.
             if(hora==0){
                hora=12;
            }

             if(hora>12){
                hora = hora - 12;
                session = "PM"
            }

    hora = (hora<10) ? "0" + hora : hora;
    minuto = (minuto<10) ? "0" + minuto : minuto;
    segundo = (segundo<10) ? "0" + segundo : segundo;

        //Estrutura da Data   

            //Dias da semana
            diaNome = new Array ("domingo", "segunda-feira", "terça-feira", "quarta-feira", "quinta-feira", "sexta-feira", "sábado");
            mesNome = new Array ("janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
            agora = new Date ();


    var time = hora + ":" + minuto + ":" + segundo + " " + session + " / " + diaNome[agora.getDay()] + ", " + agora.getDate() + " de " + mesNome[agora.getMonth()] + " de " + agora.getFullYear();
    document.getElementById("hms").innerHTML = time;
    document.getElementById("hms").textContent = time;

    setTimeout(showTime, 1000);

    }

    showTime();