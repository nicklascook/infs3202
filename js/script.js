// from https://stackoverflow.com/questions/28938825/select-option-depending-on-get-parameter?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
// Needs to be accessed by global scope
function getUrlParam(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}

$(document).ready(function(){

    // Page Setup events
    $(".accountName").click(function(){ 
        $(".accountDropdown").slideToggle(100);
        $(".accountArrow").toggleClass("icon-chevron-up")
        $(".accountArrow").toggleClass("icon-chevron-down")
    });



    
    var verificationRequest;
    $("#emailSignupInput").focusout(function () {
       verifyUserData("email", $(this).val(), $(this));
    })

    $("#usernameSignupInput").focusout(function () {
        verifyUserData("username", $(this).val(), $(this));
    })
    $("#emailSignupInput").focus(function () {
        $(this).removeClass("signupInput-invalid");
        $(this).removeClass("signupInput-valid");
        $(this).prev("p").removeClass("signupInput-invalid")
        $(this).prev("p").removeClass("signupInput-valid")
        $(this).prev("p").text("Email:");
    })

    $("#usernameSignupInput").focus(function () {
        $(this).removeClass("signupInput-invalid");
        $(this).removeClass("signupInput-valid");
        $(this).prev("p").removeClass("signupInput-invalid")
        $(this).prev("p").removeClass("signupInput-valid")
        $(this).prev("p").text("Username:");
    })

    $("#passwordSignupInput").keyup(function(){
        console.log($(this).val().length)
        if ($(this).val().length < 8){
            passwordValid = false;
            $(this).prev("p").text("Password: 8 characters min");
            $(this).prev("p").removeClass("signupInput-valid");
            $(this).removeClass("signupInput-valid")

        } else if ($(this).val().length < 16){
            passwordValid = true;
            $(this).prev("p").text("Password: ");
            $(this).prev("p").addClass("signupInput-valid")
            $(this).addClass("signupInput-valid")
            $(this).prev("p").append("<span class='icon-check'> </span>");

        } else if ($(this).val().length > 16){
            passwordValid = false;
            $(this).prev("p").text("Password: 16 characters max");
            $(this).prev("p").removeClass("signupInput-valid");
            $(this).removeClass("signupInput-valid")
        }
    })
    var passwordValid = false;
    var usernameValid = false;
    var emailValid = false;
    function verifyUserData(valueType, value, input){
        if (verificationRequest) {
            verificationRequest.abort();
        }
        var data = {
            [valueType]: value
        };

        if(value.length > 0){
            $.ajax({
                url: "verifyData.php",
                type: "post",
                data: data,
                success: function (response) {
                    var valid = false;
                    if(valueType === "email"){
                        if(isValidEmailAddress(value)){
                            valid = true;
                        }
                    } else{
                        if(isValidUsername(value)){
                            valid = true;
                        }
                    }
                    

                    if (response || !valid) {
                        if (valueType === "email") {
                            emailValid = false;
                        } else {
                            usernameValid = false;
                        }
                        $(input).addClass("signupInput-invalid");
                        $(input).prev("p").addClass("signupInput-invalid")
                        $(input).prev("p").text("Invalid " + valueType + " ");
                        $(input).prev("p").append("<span class='icon-x'> </span>");
                    } else {
                        
                        if(valueType === "email"){
                            emailValid = true;
                        } else{
                            usernameValid = true;
                        }
                        $(input).addClass("signupInput-valid");
                        $(input).prev("p").addClass("signupInput-valid")
                        $(input).prev("p").append("<span class='icon-check'> </span>");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
        
    }

    function isValidUsername(username){
        var usernameRegEx = new RegExp(/^[a-z0-9]+$/);
        return usernameRegEx.test(username);
    }

    // FROM https://stackoverflow.com/questions/8398403/check-if-correct-e-mail-was-entered?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
    function isValidEmailAddress(emailAddress) {
        var emailRegEx = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return emailRegEx.test(emailAddress);
    };



    


    var bannerRandomiser = Math.floor(Math.random()*4);
    var bannerData = [
        [
            "#9fa8da",
            "Everything Under $20",
            "Browse everything from gifts to fashion, nothing is over $20!",
            "img/itemDisplayOne_under20.png",
            "search.php?maxPrice=20"
        ],
        [
            "#66bb6a",
            "Find Your Passion",
            "Get the right gear for your new hobby.",
            "img/itemDisplayOne_passion.png",
            "search.php?category=collectables"
        ],
         [
            "#ffb300",
            "Reinvent Your Home",
            "Search by new or used furniture.",
            "img/itemDisplayOne_home.png",
            "search.php?category=home"
        ],
         [
            "#ff7043",
            "The Newest Tech",
            "Don't fall behind - shop the newest, fastest tech on the market.",
            "img/itemDisplayOne_tech.png",
            "search.php?category=electronics"
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
        $("#itemDisplay").find("a").attr("href", bannerData[bannerRandomiser][4]);
    }

  
     
   

  

    


    $("#filterBtn").click(function(){

        window.location.replace(applyFiltersToUrl());
    })

    function applyFiltersToUrl(){
        // On clicking filter button, get current URL, adjust current values, add on additional ones.
        var filters = window.location.search.substr(1).split("&"); // get current filters from URL, split by "?"
        for (var i = 0; i < filters.length; i++) {
            var filterName = filters[i].split("=")[0]; // split filter by name and value, assign name to var
            if (filterName !== "name") { // remove any filters that are not "name"
                filters.splice(i, 1);
                i--; // adjust i due to splicing
            }
        }



        // Add on Category filter:
        if ($("#categoryFilterSelect").val() !== null) {
            filters.push("category=" + $("#categoryFilterSelect").val());
        }

        // Add on buy format filter:
        if ($('input[name=format]:checked').val() !== undefined) {
            filters.push("format=" + $('input[name=format]:checked').next("p").text());
        }
        // Add on buy condition filter:
        if ($('input[name=condition]:checked').val() !== undefined) {
            filters.push("condition=" + $('input[name=condition]:checked').next("p").text());
        }
        // Add on buy postageType filter:
        if ($('input[name=postageType]:checked').val() !== undefined) {
            var postageTypeSpaceRemoved = $('input[name=postageType]:checked').next("p").text().replace(/\s+/g, '');
            filters.push("postageType=" + postageTypeSpaceRemoved);
        }

        //Add on minimum Price
        if ($("#minPriceFilter").val().trim() !== "") {
            if (!isNaN($("#minPriceFilter").val())) {
                filters.push("minPrice=" + $("#minPriceFilter").val());
                var minPriceEntered = true;
            }
        }
        //Add on max Price
        if ($("#maxPriceFilter").val().trim() !== "") {
            if (!isNaN($("#maxPriceFilter").val())) {
                if (minPriceEntered) { // Ensure that the minimum price is not greater than the maximum
                    if ($("#minPriceFilter").val() < $("#maxPriceFilter").val()) {
                        filters.push("maxPrice=" + $("#maxPriceFilter").val());
                    }
                } else {
                    filters.push("maxPrice=" + $("#maxPriceFilter").val());
                }
            }
        }


        // RETURN THE NEW URL:
        var url = window.location.href.split('?')[0];

        if (filters.length !== 0) {
            for (var i = 0; i < filters.length; i++) {
                if (i === 0) {
                    url += "?";
                } else {
                    url += "&";
                }
                url += filters[i];
            }
        }
        // window.location.replace(url);
        return url;


    }

    $("#clearFilterBtn").click(function(){
        var filters = window.location.search.substr(1).split("&"); // get current filters from URL, split by "?"
        for (var i = 0; i < filters.length; i++) {
            var filterName = filters[i].split("=")[0]; // split filter by name and value, assign name to var
            if (filterName !== "name") { // remove any filters that are not "name"
                filters.splice(i, 1);
                i--; // adjust i due to splicing
            }
        }

        var url = window.location.href.split('?')[0];
        url += "?"+filters[0]
        window.location.replace(url);
    });

    $("#searchSortSelect").change(function(){
        if(window.location.href.split("?").length > 1){

                // console.log(window.location.href.replace("/&?sort=([^&]$|[^&]*)/i, ''"));
                var newURL = applyFiltersToUrl() + "&sort=" + $(this).val();
                window.location.replace(newURL);
            
        } else{
            var newURL = window.location.href + "?sort=" + $(this).val();
            window.location.replace(newURL);
        }
        // console.log(window.location.href + "&sort=" + $(this).val())
    })

    // SET UP PAGE ON RELOAD BASED ON GET PARAMETERS (FILTERS)
    $("#categoryFilterSelect").val(getUrlParam("category"));
    if(getUrlParam("sort") != null){
        $("#searchSortSelect").val((getUrlParam("sort")));
    }
    $('input:radio[name="format"]').filter('[value="'+ getUrlParam("format") +'"]').attr('checked', true);
    $('input:radio[name="condition"]').filter('[value="'+ getUrlParam("condition") +'"]').attr('checked', true);
    $('input:radio[name="postageType"]').filter('[value="'+ getUrlParam("postageType") +'"]').attr('checked', true);
    $("#minPriceFilter").val(getUrlParam("minPrice"));
    $("#maxPriceFilter").val(getUrlParam("maxPrice"));

    

    $("#signupForm").submit(function(e){
        e.preventDefault();
        
        if(!emailValid){
            alert("Please enter a valid email.")
        } else if(!usernameValid){
            alert("Please enter a valid username.")
        } else if(!passwordValid){
            alert("Please enter a valid password.")
        } else{
            $("#signupForm")[0].submit();
        }
        

    })

    $(".accountTab").click(function(){
        $(this).parent().children(".accountTab").removeClass("accountTab-active");
        $(this).addClass("accountTab-active")
        console.log($(this).text())
        $(this).parent().nextAll(".accountTabContent").hide();
        if ($(this).text() == "Bookmarks"){
            $("#bookmarksTab").show();
        } else if ($(this).text() == "Items For Sale"){
            $("#itemsForSaleTab").show();
        } else{
            $("#orderHistoryTab").show();
        }
    })

    $(".deleteItem").click(function(){
        console.log($(this).parent(".accountItem").attr("itemId"))
        var itemToDelete = $(this).parent(".accountItem");
        var data = {
            "itemId": itemToDelete.attr("itemId")
        };

            $.ajax({
                url: "deleteItemHandle.php",
                type: "post",
                data: data,
                success: function (response) {
                    itemToDelete.remove();
                    // Show visually that item has been removed first
                    console.log(response)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        
    })



    



});
