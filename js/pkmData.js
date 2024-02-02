var audio = new Audio('./resources/audio/1.ogg');
var backBtn = document.getElementById("backBtn");
backBtn.addEventListener("click",()=>{window.location.href = "./";})
console.log(audio);
function playCry(id){
    audio.src = `./resources/audio/${id}.ogg`
    audio.play();

}