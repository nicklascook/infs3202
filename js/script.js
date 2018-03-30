$(document).ready(function(){

    // Page Setup events
    $(".accountName").click(function(){ 
        $(".accountDropdown").slideToggle(100);
        $(".accountArrow").toggleClass("icon-chevron-up")
        $(".accountArrow").toggleClass("icon-chevron-down")
    });

    $("#bidRadio").focus(function(){
        $(this).parent().addClass("pricingBlock-active");
        $("#buyRadio").parent().removeClass("pricingBlock-active");
    });
    $("#buyRadio").focus(function(){
        $(this).parent().addClass("pricingBlock-active");
        $("#bidRadio").parent().removeClass("pricingBlock-active");
    });
    $("#bidPrice").focus(function(){
        $(this).parent().parent().addClass("pricingBlock-active");
        $("#bidRadio").prop("checked", true);
        $("#bidRadio").change();
        $(this).parent().addClass("pricingBlock-active");
        $("#buyRadio").parent().removeClass("pricingBlock-active");
        $("#buyPrice").parent().removeClass("pricingBlock-active");
    });
    $("#buyPrice").focus(function(){
        $(this).parent().parent().addClass("pricingBlock-active");
        $("#buyRadio").prop("checked", true);
        $("#buyRadio").change();
        $(this).parent().addClass("pricingBlock-active");
        $("#bidRadio").parent().removeClass("pricingBlock-active");
        $("#bidPrice").parent().removeClass("pricingBlock-active");
    });

    $("#itemNameInput").keyup(function(){
        var length = $(this).val().length;
        $(".barFill").width(0.5 * length + 10);

        if (length < 20){
            $(".barFill").css({backgroundColor: "#f4511e"});
            $(".bar").css({ backgroundColor: "#ffccbc"});
            $(".nameInputIndicatorText").text("Too short");
            $(".nameInputIndicatorDetail").text("Include details such as brand, colour, size, condition.");
        } else if(length < 30){
            $(".barFill").css({ backgroundColor: "#ffc107" });
            $(".bar").css({ backgroundColor: "#ffecb3" });
            $(".nameInputIndicatorText").text("Getting there");
            $(".nameInputIndicatorDetail").text("Include details such as brand, colour, size, condition.");
        } else if(length < 40){
            $(".barFill").css({ backgroundColor: "#8bc34a" });
            $(".bar").css({ backgroundColor: "#dcedc8" });
            $(".nameInputIndicatorText").text("Great length");
            $(".nameInputIndicatorDetail").text("Don't stop there. Keep adding details.");
        } else if(length < 60){
            $(".barFill").css({ backgroundColor: "#9fa8da" });
            $(".bar").css({ backgroundColor: "#d1d9ff" });
            $(".nameInputIndicatorDetail").text(60 - length + " characters left.");

        } else if(length == 60){
            $(".barFill").css({ backgroundColor: "#6f79a8" });
            $(".bar").css({ backgroundColor: "#9fa8da" });
            $(".nameInputIndicatorText").text("Max Length");
            $(".nameInputIndicatorDetail").text("0 characters left.");
        }
        
    })



    var bannerRandomiser = Math.floor(Math.random()*4);
    var bannerData = [
        [
            "#9fa8da",
            "Everything Under $20",
            "Browse everything from gifts to fashion, nothing is over $20!",
            "img/itemDisplayOne_under20.png"
        ],
        [
            "#66bb6a",
            "Find Your Passion",
            "Get the right gear for your new hobby.",
            "img/itemDisplayOne_passion.png"
        ],
         [
            "#ffb300",
            "Reinvent Your Home",
            "Search by new or used furniture.",
            "img/itemDisplayOne_home.png"
        ],
         [
            "#ff7043",
            "The Newest Tech",
            "Don't fall behind - shop the newest, fastest tech on the market.",
            "img/itemDisplayOne_tech.png"
        ]
    ]
    
    $("#itemDisplay").css({backgroundColor: bannerData[bannerRandomiser][0]});
    $("#itemDisplay").find("h2").html(bannerData[bannerRandomiser][1]);
    $("#itemDisplay").find("h3").html(bannerData[bannerRandomiser][2]);
    $("#itemDisplay").find("img").attr("src", bannerData[bannerRandomiser][3] );
    
})
