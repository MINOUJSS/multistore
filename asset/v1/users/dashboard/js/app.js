$(document).ready(function(){
    //toggle side bar
    $('#3bar').on('click',function(e){
        e.preventDefault();
       $('.app-sidebar').toggleClass('side');
    });
    //toggle slid parent link
    $('.sub-btn').on('click',function(){
        $(this).next('.sub-menu').slideToggle();
        $(this).find('.dropdown').toggleClass('rotate');
    });
    //controle active item menu
    const menu_items=document.querySelectorAll('.item');
    menu_items.forEach(menu_item =>{
        menu_item.addEventListener('click',()=>{
            document.querySelector('.active')?.classList.remove('active');
            menu_item.classList.add('active');
        });
    });
});
     
