function getPkm(){
    var inputSrc=document.getElementById("searchinput").value;
    var formdata = new FormData();
    formdata.append('src', inputSrc);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/home/getPkm.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            // Cargamos los datos
            if(ajax.responseText != "Sin resultados"){
                var json = JSON.parse(ajax.responseText);
                fetch('./config.json')
                .then((response) => response.json())
                .then((json) => readjson(json));
                function readjson(config){
                    container = document.getElementById("container");
                    if(config["columnas"] >6 || config["columnas"]<4){
                        config["columnas"] = 5;
                    }
                    if(config["columnas"] == 4){
                        container.style.paddingLeft = "15%"
                    }else if(config["columnas"] == 6){
                        container.style.paddingLeft = "9%"
                    }else{
                        container.style.paddingLeft = "10%"
                    }
                    // Cargamos cada recuadro
                    var res = '<div class="fila">'
                    json.forEach(function(item){
                        res += '<div class="column'+config["columnas"]+' recuadro alturaCuadro'+config["columnas"]+'" onclick=pkmData('+item.pokemon_id+')>'
                        res +='<img class="sprite" src="./resources/sprite/'+item.pokemon_id+'.png" alt="" srcset="">'
                        res +='<p class="pkmName">'+item.pokemon_name+'</p></div>'
                    });
                    res +="</div>"
                    document.getElementById("container").innerHTML = res;
                }
            }else{
                // No hay resultados
                var res = "<p id='sinResultados'> No se han encontrado resultados</p>";
                document.getElementById("container").innerHTML = res;
            }
        }
    }
    ajax.send(formdata);
}
configBtn = document.getElementById("configBtn");
configBtn.addEventListener("mouseover",()=>{configBtn.style.animationPlayState = "running"})
configBtn.addEventListener("mouseout",()=>{configBtn.style.animationPlayState = "paused"})
function modal(){
    const configModal = document.getElementById('configModal')
    const configBtn = document.getElementById('configBtn')
    configModal.addEventListener('shown.bs.modal', () => {
    configBtn.focus()
    })
}
function pkmData(id){
    var url = "./pkmdata.php?id="+id;
    window.location.href = url;
}
var saveConfig = document.getElementById("saveConfig");
saveConfig.addEventListener("click",()=>{
    const xhttp = new XMLHttpRequest();
    var formdata = new FormData();
    formdata.append('columns', document.getElementById("column-list").value);
    formdata.append('frame', document.querySelector('input[name="frames"]:checked').value);
    xhttp.open('POST', "./proc/home/updateConfig.php");
    xhttp.onload = function() {
        // document.getElementById("cerrarBtn").click();
        getPkm();
        updateFrame();
    }
    xhttp.send(formdata);
})

window.onload = ()=>{
    updateFrame();
    modal();
    getPkm();

    fetch('./config.json')
    .then((response) => response.json())
    .then((json) => readjson(json));
    function readjson(config){
        var columnas = config['columnas'];
        var marco = config['marco']
        var columnsList = document.getElementById("column-list");
        var frames = document.getElementsByClassName("framechk");
        for (let i = 0; i < frames.length; i++) {
            if(frames[i].value == marco){
                frames[i].checked = true;
            }
        }
        columnsList.value = columnas
    }
}
