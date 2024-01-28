function getPkm(){
    var inputSrc=document.getElementById("searchinput").value;
    var formdata = new FormData();
    formdata.append('src', inputSrc);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/home/getPkm.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            // console.log(ajax.responseText);
            var json = JSON.parse(ajax.responseText);
            var res = '<div class="row">'
            json.forEach(function(item){
                res += '<div class="col-2 recuadro" onclick=pkmData('+item.pokemon_id+')>'
                res +='<img class="sprite" src="./resources/sprite/'+item.pokemon_id+'.png" alt="" srcset="">'
                res +='<p class="pkmName">'+item.pokemon_name+'</p></div>'
            });
            res +="</div>"
            document.getElementById("container").innerHTML = res;
        }
    }
    ajax.send(formdata);
}
function pkmData(id){
    var url = "./pkmdata.php?id="+id;
    window.location.href = url;

}