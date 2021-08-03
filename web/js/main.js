let elementPosition = $('#navigation').offset();

$(window).scroll(function(){
    if($(window).scrollTop() > elementPosition.top){
        $('#navigation').removeClass('navigation-static').addClass('navigation-fixed');
    } else {
        $('#navigation').removeClass('navigation-fixed').addClass('navigation-static');
    }
});