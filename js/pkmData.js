var audio = new Audio('./resources/audio/1.ogg');
var backBtn = document.getElementById("backBtn");
backBtn.addEventListener("click",()=>{window.location.href = "./";})
function playCry(id){
    audio.src = `./resources/audio/${id}.ogg`
    audio.play();
}

// document.querySelectorAll("input").addEventListener("change",()=>{getStats()})
document.getElementById("natu").addEventListener("change",()=>{getStats()})
document.getElementById("lvl").addEventListener("keyup",()=>{getStats()})
document.getElementById("lvl").addEventListener("change",()=>{getStats()})
// HP
document.getElementById("hprange").addEventListener("change",()=>{getStats()})
document.getElementById("hpEv").addEventListener("keyup",()=>{getStats()})
document.getElementById("hpIv").addEventListener("keyup",()=>{getStats()})
document.getElementById("hpEv").addEventListener("change",()=>{getStats()})
document.getElementById("hpIv").addEventListener("change",()=>{getStats()})
hpTotal=document.getElementById("hpTotal");
// Ataque
document.getElementById("Atkrange").addEventListener("change",()=>{getStats()})
document.getElementById("AtkEv").addEventListener("keyup",()=>{getStats()})
document.getElementById("AtkIv").addEventListener("keyup",()=>{getStats()})
document.getElementById("AtkEv").addEventListener("change",()=>{getStats()})
document.getElementById("AtkIv").addEventListener("change",()=>{getStats()})
AtkTotal=document.getElementById("AtkTotal");
// Defensa
document.getElementById("defrange").addEventListener("change",()=>{getStats()})
document.getElementById("defEv").addEventListener("keyup",()=>{getStats()})
document.getElementById("defIv").addEventListener("keyup",()=>{getStats()})
document.getElementById("defEv").addEventListener("change",()=>{getStats()})
document.getElementById("defIv").addEventListener("change",()=>{getStats()})
AtkTotal=document.getElementById("defTotal");
// Ataque especial
document.getElementById("sparange").addEventListener("change",()=>{getStats()})
document.getElementById("spaEv").addEventListener("keyup",()=>{getStats()})
document.getElementById("spaIv").addEventListener("keyup",()=>{getStats()})
document.getElementById("spaEv").addEventListener("change",()=>{getStats()})
document.getElementById("spaIv").addEventListener("change",()=>{getStats()})
AtkTotal=document.getElementById("spaTotal");
// Defensa especial
document.getElementById("spdrange").addEventListener("change",()=>{getStats()})
document.getElementById("spdEv").addEventListener("keyup",()=>{getStats()})
document.getElementById("spdIv").addEventListener("keyup",()=>{getStats()})
document.getElementById("spdEv").addEventListener("change",()=>{getStats()})
document.getElementById("spdIv").addEventListener("change",()=>{getStats()})
AtkTotal=document.getElementById("spdTotal");
// Velocidad
document.getElementById("sperange").addEventListener("change",()=>{getStats()})
document.getElementById("speEv").addEventListener("keyup",()=>{getStats()})
document.getElementById("speIv").addEventListener("keyup",()=>{getStats()})
document.getElementById("speEv").addEventListener("change",()=>{getStats()})
document.getElementById("speIv").addEventListener("change",()=>{getStats()})
AtkTotal=document.getElementById("speTotal");

function getStats(){
    // Naturaleza
    var natu = document.getElementById("natu").value;
    natu = natu.split("-");
    var natMult=parseFloat(1);
    // Vida
    var lvl = parseInt(document.getElementById("lvl").value);
    var vida = parseInt(document.getElementById("vida").value);
    var hpEv = parseInt(document.getElementById("hpEv").value);
    var hpIv = parseInt(document.getElementById("hpIv").value);
    var hpTotal = document.getElementById("hpTotal");
    hpTotal.value= Math.trunc(((((2*vida)+hpIv+(hpEv/4))*lvl)/100)+lvl+10);
    natMult=parseFloat(1);
    // Ataque
    var ataque = parseInt(document.getElementById("atk").value);
    var atkEv = parseInt(document.getElementById("AtkEv").value);
    var atkIv = parseInt(document.getElementById("AtkIv").value);
    var atkTotal = document.getElementById("AtkTotal");
    if(natu[0]=="Atk"){
        natMult = parseFloat(1.1)
    }else if(natu[1]=="Atk"){
        natMult = parseFloat(0.9)
    }
    atkTotal.value = Math.trunc((Math.trunc(((((2*ataque)+atkIv+Math.trunc((atkEv/4)))*lvl)/100))+5)*natMult);
    natMult=parseFloat(1);
    // Defensa
    var defensa = parseInt(document.getElementById("def").value);
    var defEv = parseInt(document.getElementById("defEv").value);
    var defIv = parseInt(document.getElementById("defIv").value);
    var defTotal = document.getElementById("defTotal");
    if(natu[0]=="Def"){
        natMult = parseFloat(1.1)
    }else if(natu[1]=="Def"){
        natMult = parseFloat(0.9)
    }
    defTotal.value = Math.trunc((Math.trunc(((((2*defensa)+defIv+Math.trunc((defEv/4)))*lvl)/100))+5)*natMult);
    natMult=parseFloat(1);
    // Atk esp
    var spa = parseInt(document.getElementById("spa").value);
    var spaEv = parseInt(document.getElementById("spaEv").value);
    var spaIv = parseInt(document.getElementById("spaIv").value);
    var spaTotal = document.getElementById("spaTotal");
    if(natu[0]=="SpA"){
        natMult = parseFloat(1.1)
    }else if(natu[1]=="SpA"){
        natMult = parseFloat(0.9)
    }
    spaTotal.value = Math.trunc((Math.trunc(((((2*spa)+spaIv+Math.trunc((spaEv/4)))*lvl)/100))+5)*natMult);
    natMult=parseFloat(1);
    // Def esp
    var spd = parseInt(document.getElementById("spd").value);
    var spdEv = parseInt(document.getElementById("spdEv").value);
    var spdIv = parseInt(document.getElementById("spdIv").value);
    var spdTotal = document.getElementById("spdTotal");
    if(natu[0]=="SpD"){
        natMult = parseFloat(1.1)
    }else if(natu[1]=="SpD"){
        natMult = parseFloat(0.9)
    }
    spdTotal.value = Math.trunc((Math.trunc(((((2*spd)+spdIv+Math.trunc((spdEv/4)))*lvl)/100))+5)*natMult);
    natMult=parseFloat(1);
    // Velocidad
    var spe = parseInt(document.getElementById("spe").value);
    var speEv = parseInt(document.getElementById("speEv").value);
    var speIv = parseInt(document.getElementById("speIv").value);
    var speTotal = document.getElementById("speTotal");
    if(natu[0]=="Vel"){
        natMult = parseFloat(1.1)
    }else if(natu[1]=="Vel"){
        natMult = parseFloat(0.9)
    }
    speTotal.value = Math.trunc((Math.trunc(((((2*spe)+speIv+Math.trunc((speEv/4)))*lvl)/100))+5)*natMult);
    updateTotal();
}
function updateTotal(){
    // Evs totales
    var hpEv = parseInt(document.getElementById("hpEv").value);
    var atkEv = parseInt(document.getElementById("AtkEv").value);
    var defEv = parseInt(document.getElementById("defEv").value);
    var spaEv = parseInt(document.getElementById("spaEv").value);
    var spdEv = parseInt(document.getElementById("spdEv").value);
    var speEv = parseInt(document.getElementById("speEv").value);
    document.getElementById("totalEv").value = hpEv + atkEv + defEv + spaEv + spdEv + speEv;
    // stats totales
    var hpTotal = parseInt(document.getElementById("hpTotal").value);
    var atkTotal = parseInt(document.getElementById("AtkTotal").value);
    var defTotal = parseInt(document.getElementById("defTotal").value);
    var spdTotal = parseInt(document.getElementById("spdTotal").value);
    var spdTotal = parseInt(document.getElementById("spdTotal").value);
    var speTotal = parseInt(document.getElementById("speTotal").value);
    document.getElementById("total").value = hpTotal+atkTotal+defTotal+spdTotal+speTotal;

}