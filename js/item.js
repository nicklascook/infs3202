$(document).ready(function(){

    $(".itemImgGallery").click(function(){
        $(".itemImgMain").attr("src", $(this).children("img").attr("src"));
        $(".itemImgGallery-container").find(".itemImg-selected").removeClass("itemImg-selected");
        $(this).addClass("itemImg-selected");
    })


    $("#bookmarkBtn").click(function(){

        var id = getUrlParam("id");
        data = {
            "id": id
        };
        if(id != null){
            $.ajax({
                url: "bookmarkHandle.php",
                type: "post",
                data: data,
                success: function (response) {
                    // change the look of the button + remove ability to press it
                    if(response){
                        $("#bookmarkBtn").prop('disabled', true);
                        $("#bookmarkBtn").text("Bookmarked");
                        $("#bookmarkBtn").prepend("<span class='icon-check'> </span>");
                        $("#bookmarkBtn").removeAttr('id');

                    } else{
                        alert("Something went wrong. Please refresh the page and try again.")
                    }


                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    })

 

});