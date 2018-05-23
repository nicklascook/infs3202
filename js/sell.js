$(document).ready(function(){


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

        $("#imageUploadBtn").on('change', function(e){
            var image = e.target.files[0]; // get the file
            createFormData([image]); // create the formData for uploading
        })

    // Creates FormData object to send to uploading function
    function createFormData(image) {
        var formImage = new FormData();
        for (var i = 0; i < image.length; i++) {
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
                if (response == "error:filesize") {
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: Filesize is too large for uploading (4mb max)</h3>");
                    $(".imageDropPreviewContainer").prepend(errorMsg);
                } else if (response === "error:extension") {
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: The extension is not compatible (jpg/jpeg/png/gif only)</h3>")
                    $(".imageDropPreviewContainer").prepend(errorMsg);
                } else if (imageAddCount > 8) {
                    var errorMsg = $("<h3 class='imageDrop-error'>Error: Reached maximum file upload limit</h3>")
                    $(".imageDropPreviewContainer").prepend(errorMsg);

                } else {
                    var imagePreview = $("<img src='' class='imageDropPreview'>")
                    imagePreview.attr("src", response);
                    $('.imageDropPreviewContainer').append(imagePreview);

                    imageAddCount++;
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


    // Submit hijacking
    $("#sellForm").submit(function(e){
        e.preventDefault();
        // Check for images uploaded (2 min)
        if(imageAddCount > 1){
            $("#sellForm")[0].submit(); // Escape the external handler (this function)
        } else{
            alert("Please upload a minimum of 2 photos.")
        }
    })


}) 