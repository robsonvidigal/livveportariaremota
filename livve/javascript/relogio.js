// Estrutura do relógio

        //Inicio da function showTime 

    function showTime () {
        var date = new Date();
        var hora = date.getHours();
        var minuto = date.getMinutes();
        var segundo = date.getSeconds();
        var session = "AM";

        //Condição da utilização de AM PM
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

    var time = hora + ":" + minuto + ":" + segundo + " " + session;
    document.getElementById("hms").innerHTML = time;
    document.getElementById("hms").textContent = time;

    setTimeout(showTime, 1000);

    }

    showTime();


//Créditos: Feature Code
//font: https://github.com/tluis9/relogioWeb
//      https://www.youtube.com/watch?v=O2t1brzQ6NE