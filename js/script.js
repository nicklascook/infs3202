$(document).ready(function(){

    // Page Setup events
    $(".accountName").click(function(){ 
        $(".accountDropdown").slideToggle(100);
        $(".accountArrow").toggleClass("icon-chevron-up")
        $(".accountArrow").toggleClass("icon-chevron-down")
    });

    



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
    
    changeBanner(bannerRandomiser);
    $(".carouselButton").click(function(){
        changeBanner();
        clearInterval(bannerInterval);
    })
    var bannerInterval = setInterval(function(){
        changeBanner()
    }, 5000)

    function changeBanner(){
        bannerRandomiser++;
        if (bannerRandomiser > 3) {
            bannerRandomiser = 0;
        }
        $("#itemDisplay").css({ backgroundColor: bannerData[bannerRandomiser][0] });
        $("#itemDisplay").find("h2").html(bannerData[bannerRandomiser][1]);
        $("#itemDisplay").find("h3").html(bannerData[bannerRandomiser][2]);
        $("#itemDisplay").find("img").attr("src", bannerData[bannerRandomiser][3]);
    }

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
    var imageAddCount = 0;
    function uploadFormData(formData) {
        $.ajax({
            url: "imageUpload.php",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                if(response == "error:filesize"){
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: Filesize is too large for uploading (4mb max)</h3>");
                    $(".imageDropPreviewContainer").prepend(errorMsg);
                } else if (response === "error:extension"){
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: The extension is not compatible (jpg/jpeg/png/gif only)</h3>")
                    $(".imageDropPreviewContainer").prepend(errorMsg);
                } else if( imageAddCount > 8){
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: Reached maximum file upload limit</h3>")
                    $(".imageDropPreviewContainer").prepend(errorMsg);

                } else{
                    var imagePreview = $("<img src='' class='imageDropPreview'>")
                    imagePreview.attr("src", response);
                    $('.imageDropPreviewContainer').append(imagePreview);

                    imageAddCount ++;
                }
            }
        });
    }

    $("#bidRadio").focus(function () {
        $(this).parent().addClass("pricingBlock-active");
        $("#bidPrice").prop('required', true);
        $("#buyPrice").removeAttr("required");
        $("#buyRadio").parent().removeClass("pricingBlock-active");
    });
    $("#buyRadio").focus(function () {
        $(this).parent().addClass("pricingBlock-active");
        $("#buyPrice").prop('required', true);
        $("#bidPrice").removeAttr("required");
        $("#bidRadio").parent().removeClass("pricingBlock-active");
    });
    $("#bidPrice").focus(function () {
        $(this).parent().parent().addClass("pricingBlock-active");
        $("#bidRadio").prop("checked", true);
        $("#bidRadio").change();
        $(this).parent().addClass("pricingBlock-active");
        $("#buyRadio").parent().removeClass("pricingBlock-active");
        $("#buyPrice").parent().removeClass("pricingBlock-active");
        $("#bidPrice").prop('required', true);
        $("#buyPrice").removeAttr("required");
    });
    $("#buyPrice").focus(function () {
        $(this).parent().parent().addClass("pricingBlock-active");
        $("#buyRadio").prop("checked", true);
        $("#buyRadio").change();
        $(this).parent().addClass("pricingBlock-active");
        $("#bidRadio").parent().removeClass("pricingBlock-active");
        $("#bidPrice").parent().removeClass("pricingBlock-active");
        $("#buyPrice").prop('required', true);
        $("#bidPrice").removeAttr("required");
    });

    $("#itemNameInput").keyup(function () {
        var length = $(this).val().length;
        $(".barFill").width(0.5 * length + 10);

        if (length < 20) {
            $(".barFill").css({ backgroundColor: "#f4511e" });
            $(".bar").css({ backgroundColor: "#ffccbc" });
            $(".nameInputIndicatorText").text("Too short");
            $(".nameInputIndicatorDetail").text("Include details such as brand, colour, size, condition.");
        } else if (length < 30) {
            $(".barFill").css({ backgroundColor: "#ffc107" });
            $(".bar").css({ backgroundColor: "#ffecb3" });
            $(".nameInputIndicatorText").text("Getting there");
            $(".nameInputIndicatorDetail").text("Include details such as brand, colour, size, condition.");
        } else if (length < 40) {
            $(".barFill").css({ backgroundColor: "#8bc34a" });
            $(".bar").css({ backgroundColor: "#dcedc8" });
            $(".nameInputIndicatorText").text("Great length");
            $(".nameInputIndicatorDetail").text("Don't stop there. Keep adding details.");
        } else if (length < 60) {
            $(".barFill").css({ backgroundColor: "#9fa8da" });
            $(".bar").css({ backgroundColor: "#d1d9ff" });
            $(".nameInputIndicatorDetail").text(60 - length + " characters left.");

        } else if (length == 60) {
            $(".barFill").css({ backgroundColor: "#6f79a8" });
            $(".bar").css({ backgroundColor: "#9fa8da" });
            $(".nameInputIndicatorText").text("Max Length");
            $(".nameInputIndicatorDetail").text("0 characters left.");
        }

    })


    $("#filterBtn").click(function(){

        // On clicking filter button, get current URL, adjust current values, add on additional ones.
        var filters = window.location.search.substr(1).split("&"); // get current filters from URL, split by "?"
        for(var i=0; i< filters.length; i++){ 
            var filterName = filters[i].split("=")[0]; // split filter by name and value, assign name to var
            if(filterName !== "name"){ // remove any filters that are not "name"
                filters.splice(i, 1);
                i--; // adjust i due to splicing
            }
        }

        

        // Add on Category filter:
        if ($("#categoryFilterSelect").val() !== null){
            filters.push("category=" + $("#categoryFilterSelect").val());
        }

        // Add on buy format filter:
        if ($('input[name=format]:checked').val() !== undefined){
            filters.push("format=" + $('input[name=format]:checked').next("p").text());
        }
        // Add on buy condition filter:
        if ($('input[name=condition]:checked').val() !== undefined){
            filters.push("condition=" + $('input[name=condition]:checked').next("p").text());
        }
        // Add on buy postageType filter:
        if ($('input[name=postageType]:checked').val() !== undefined){
            var postageTypeSpaceRemoved = $('input[name=postageType]:checked').next("p").text().replace(/\s+/g, '');
            filters.push("postageType=" + postageTypeSpaceRemoved);
        }
        
        //Add on minimum Price
        if ($("#minPriceFilter").val().trim() !== ""){
            if (!isNaN($("#minPriceFilter").val())){
                filters.push("minPrice=" + $("#minPriceFilter").val());
                var minPriceEntered = true;
            }
        }
        //Add on max Price
        if ($("#maxPriceFilter").val().trim() !== "") {
            if (!isNaN($("#maxPriceFilter").val())) {
                if(minPriceEntered){ // Ensure that the minimum price is not greater than the maximum
                    if ($("#minPriceFilter").val() < $("#maxPriceFilter").val()){
                        filters.push("maxPrice=" + $("#maxPriceFilter").val());
                    }
                } else{
                    filters.push("maxPrice=" + $("#maxPriceFilter").val());
                }
            }
        }
        
    
        // CHANGE THE URL:
        var url = window.location.href.split('?')[0];
      
        if(filters.length !== 0){
            for(var i = 0; i < filters.length; i++){
                if(i === 0){
                    url += "?";
                } else{
                    url += "&";
                }
                url += filters[i];
            }
        }
        console.log(filters)
        window.location.replace(url);


    })



});
