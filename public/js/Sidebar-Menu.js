$("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $("#menu-toggle").toggleClass("toggled");
        if(window.matchMedia("(max-width: 768px)").matches){
            $("#logo-waki").css("display","none");
            $("#list-member").css("display","block");
            $("#form-addMember").css("display","block");
        }
});
$("#MainMenu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $("#menu-toggle").toggleClass("toggled");
    if(window.matchMedia("(max-width: 768px)").matches){
            $("#logo-waki").css("display","inline");
            $("#list-member").css("display","block");
            $("#form-addMember").css("display","block");
        }
});

$(".parent-dropdown").click(function(e) {
        e.preventDefault();
        $(".child-dropdown").toggleClass("toggled");
    if($(".child-dropdown").css("display") == "none"){
        $( "#icon-dropdown" ).removeClass( "fa-caret-down" ).addClass( "fa-caret-right" );
    }
    else
    {
        $( "#icon-dropdown" ).removeClass( "fa-caret-right" ).addClass( "fa-caret-down" );
    }
})