$(function(){
    var x = 0;
    var y = 0;
    setInterval(function(){
       if( y == 600){
           x=0;
           y=0;
       }
        x-=1;
        y+=1;
        $('body').css('background-position', x + 'px ' + y + 'px');
    }, 60);
})