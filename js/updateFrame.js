function updateFrame(){
    var panelfixed = document.getElementById("panelfixed");
    fetch('./config.json')
    .then((response) => response.json())
    .then((json) => readjson(json));
    function readjson(config){
        var clase = `marco${config["marco"]}`
        panelfixed.classList.remove("marco1");
        panelfixed.classList.remove("marco2");
        panelfixed.classList.add(clase)
    }
}