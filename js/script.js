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
    

    // Run the function only if the page is on sell.php:
    if ($("body").hasClass("sellItemBody")){ 
        $(".imageDropContainer").on('dragenter', function (e) { // Dragging image changes css
            e.preventDefault();
            $(".imageDropText").text("Drop to upload")
            $(this).addClass("imageDropHover");
        });
        $(".imageDropContainer").on('dragleave', function (e) {
            e.preventDefault();
            $(".imageDropText").text("Drag and Drop Images Here")
            $(this).removeClass("imageDropHover");
        });

        $(".imageDropContainer").on('dragover', function (e) {
            e.preventDefault();
        });

        // Capture drop function on entire window to prevent accidental loading rather than uploading of the image
        $(window).on('drop', function (e) {
            e.preventDefault();
            $(".imageDropText").text("Drag and Drop Images Here")
            $(".imageDropContainer").removeClass("imageDropHover");

            // Clear out any existing error messages:
            $(".imageDrop-error").remove();
            var image = e.originalEvent.dataTransfer.files; // get the file
            console.log(image)
            createFormData(image); // create the formData for uploading
        });
        // Necessary for preventing loading of image
        window.addEventListener("dragover", function (e) {
            e = e || event;
            e.preventDefault();
        }, false);
       
    }

     
    // Creates FormData object to send to uploading function
    function createFormData(image) {
        var formImage = new FormData();
        for(var i=0; i < image.length; i++){
            formImage.append('image', image[i]);
        }
            
        uploadFormData(formImage);
    }

    // Uploads form data, creates error messages, appends image preview
    function uploadFormData(formData) {
        $.ajax({
            url: "newItemHandle.php",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                if(response == "error:filesize"){
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: Filesize is too large for uploading (2mb max)</h3>");
                    $(".imageDropPreviewContainer").prepend(errorMsg);
                    console.log("filesize")
                } else if (response === "error:extension"){
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: The extension is not compatible (jpg/jpeg/png/gif only)</h3>")
                    $(".imageDropPreviewContainer").prepend(errorMsg);
                } else{
                    var imagePreview = $("<img src='' class='imageDropPreview'>")
                    imagePreview.attr("src", response);
                    $('.imageDropPreviewContainer').append(imagePreview);
                    $('.imageDropPreviewContainer').show();
                }
            }
        });
    }




})
