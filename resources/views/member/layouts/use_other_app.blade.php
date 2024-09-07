<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="icon" href="{!! asset('chat/img/core-img/logo.png') !!}">
    <link rel="apple-touch-icon" href="{!! asset('chat/img/icons/icon-96x96.png') !!}">
    <link rel="apple-touch-icon" sizes="152x152" href="{!! asset('chat/img/icons/icon-152x152.png') !!}">
    <link rel="apple-touch-icon" sizes="167x167" href="{!! asset('chat/img/icons/icon-167x167.png') !!}">
    <link rel="apple-touch-icon" sizes="180x180" href="{!! asset('chat/img/icons/icon-180x180.png') !!}">


    <link rel="stylesheet" href="{!! asset('chat/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('chat/css/bootstrap-icons.css') !!}">
    <link rel="stylesheet" href="{!! asset('chat/css/tiny-slider.css') !!}">
    <link rel="stylesheet" href="{!! asset('chat/css/venobox.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('chat/css/rangeslider.css') !!}">
    <link rel="stylesheet" href="{!! asset('chat/css/vanilla-dataTables.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('chat/css/apexcharts.css') !!}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css"
        integrity="sha512-Aix44jXZerxlqPbbSLJ03lEsUch9H/CmnNfWxShD6vJBbboR+rPdDXmKN+/QjISWT80D4wMjtM4Kx7+xkLVywQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary,
    .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary {
        background: #007bff;
        color: #fff;
    }

    .bootstrap-switch .bootstrap-switch-handle-on {
        border-bottom-left-radius: 0.1rem;
        border-top-left-radius: 0.1rem;
    }

    .bootstrap-switch .bootstrap-switch-handle-off,
    .bootstrap-switch .bootstrap-switch-handle-on {
        text-align: center;
        z-index: 1;
    }

    .bootstrap-switch .bootstrap-switch-handle-off,
    .bootstrap-switch .bootstrap-switch-handle-on,
    .bootstrap-switch .bootstrap-switch-label {
        box-sizing: border-box;
        cursor: pointer;
        display: table-cell;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.2rem;
        padding: 0.25rem 0.5rem;
        vertical-align: middle;
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    .bootstrap-switch {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        cursor: pointer;
        direction: ltr;
        display: inline-block;
        line-height: .5rem;
        overflow: hidden;
        position: relative;
        text-align: left;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        vertical-align: middle;
        z-index: 0;
    }

    .mobmenuitem1 {

        margin-bottom: 10px;
        overflow: hidden;
    }

    .mobheader1 {
        background-color: #f5f5f5;
        padding: 10px;
        cursor: pointer;
        transition: transform 0.3s cubic-bezier(0.42, -0.07, 0.58, 1.04);
        border: 1px solid #ccc;
    }

    .mobcontent1 {
        transition: transform 0.3s cubic-bezier(0.42, -0.07, 0.58, 1.04);
    }


    .active1 {
        transform: translateX(-100%);
    }

    a.affan-element-item1 {
        margin: 0.5rem 0;
        background-color: #ffffff;
        padding: 0.625rem 0.75rem;
        color: #073984;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 14px;
        -webkit-box-shadow: 0 1px 2px 1px rgba(15, 7, 23, 0.05);
        box-shadow: 0 1px 2px 1px rgba(15, 7, 23, 0.05);
    }
    
    </style>
    <!-- Style CSS -->
    <link rel="stylesheet" href="{!! asset('chat/style.css') !!}">

    <!-- Web App Manifest -->



    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body>

    <div class="internet-connection-status" id="internetStatus"></div>

    @include('layouts.chatheader')
    @include('layouts.menu')


    @yield('content')


    @yield('third_party_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"
        integrity="sha512-E4KfIuQAc9ZX6zW1IUJROqxrBqJXPuEcDKP6XesMdu2OV4LW7pj8+gkkyx2y646xEV7yxocPbaTtk2LQIJewXw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMFPPAlejgNNF0FPoxBNjqVpThqXRvy_s"></script>
    <script src="{!! asset('assets/js/jquery.min.js') !!}"></script>
    <script src="{!! asset('chat/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('chat/js/slideToggle.min.js') !!}"></script>
    <script src="{!! asset('chat/js/internet-status.js') !!}"></script>
    <script src="{!! asset('chat/js/tiny-slider.js') !!}"></script>
    <script src="{!! asset('chat/js/venobox.min.js') !!}"></script>
    <script src="{!! asset('chat/js/countdown.js') !!}"></script>
    <script src="{!! asset('chat/js/rangeslider.min.js') !!}"></script>
    <script src="{!! asset('chat/js/vanilla-dataTables.min.js') !!}"></script>
    <script src="{!! asset('chat/js/index.js') !!}"></script>
    <script src="{!! asset('chat/js/imagesloaded.pkgd.min.js') !!}"></script>
    <script src="{!! asset('chat/js/isotope.pkgd.min.js') !!}"></script>
    <script src="{!! asset('chat/js/dark-rtl.js') !!}"></script>
    <script src="{!! asset('chat/js/active.js') !!}"></script>
    <script src="{!! asset('chat/js/pwa.js') !!}"></script>
    <script src="{!! asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}"></script>

    <script>
    $(document).ready(function() {
        var accordionHeaders = $('.mobheader1');
        var accordionContents = $('.mobcontent1');
        var backButton = $('.back-button1');
        var categoryTitle = $('.mtitle1');
        var allCategoriesHeader = $('.all-categories-header1');

        // Hide mobcontent elements initially
        accordionContents.hide();

        accordionHeaders.on('click', function() {
            var selectedCategory = $(this).text(); // Get the text of the clicked mobheader
            categoryTitle.text(selectedCategory); // Replace the category title with the selected text

            // Accordion click event handling
            var isShown = $(this).hasClass('show');

            accordionHeaders.css({
                'transform': 'translateX(-200%)',
                'display': 'block',
                'padding': '0px',
                'height': '0px',
                'opacity': '0'
            }).removeClass('show');

            accordionContents.hide();

            if (!isShown) {
                var accordionContent = $(this).next('.mobcontent1');
                accordionContent.css({
                    'display': 'block'
                }).animate({
                    'margin-left': 0
                }, 500); // Adjust the duration as needed (in milliseconds)
                $(this).addClass('show');

                backButton.css('display', 'inline-block');
                accordionHeaders.not(this).css('display', 'none'); // Hide other accordion headers
            }
        });

        backButton.on('click', function() {
            categoryTitle.text("ALL CATEGORIES"); // Reset the category title to "ALL CATEGORIES"

            // Reset accordion state
            accordionHeaders.css({
                'transform': '',
                'display': '',
                'padding': '',
                'height': '',
                'opacity': ''
            }).removeClass('show');

            accordionContents.hide();

            backButton.css('display', 'none');
            allCategoriesHeader.css('display', 'block');
        });
    });

    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

    var district2 = "";

    $('#current_location').on('change', function() {
        if ($('#current_location').is(":checked")) {
            $("#showdiv1").hide('slow');
            $("#showdiv2").show('slow');
        } else {
            $("#showdiv2").hide('slow');
            $("#showdiv1").show('slow');
        }
    });

    $('#cat_id').on('change', function() {
        var cat_id = this.value;
        $("#sub_cat_id").html('');
        $.ajax({
            url: "{{url('/getsubcategory')}}",
            type: "POST",
            data: {
                cat_id: cat_id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('#sub_cat_id').html('<option value="">Select Sub Category</option>');
                $.each(result, function(key, value) {
                    $("#sub_cat_id").append('<option value="' + value
                        .id + '">' + value.category_name + '</option>');
                });
            }
        });
    });

    $('#state_id').on('change', function() {
        var state_id = this.value;
        load_city(state_id);
    });

    function load_city(state_id) {
        $("#city_id").html('');
        $.ajax({
            url: "{{url('/getcity')}}",
            type: "POST",
            data: {
                state_id: state_id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                $('#city_id').html('<option value="">Select City</option>');
                $.each(result, function(key, value) {
                    $("#city_id").append('<option value="' + value
                        .city + '">' + value.city + '</option>');
                });
                $("#city_id").val(district2);
            }
        });
    }

    $('#sub_cat_id').on('change', function() {
        var cat_id = $("#cat_id").val();
        var sub_cat_id = this.value;
        $("#attrdiv").html('');
        console.clear();
        $.ajax({
            url: "{{url('/getattributes')}}",
            type: "POST",
            data: {
                cat_id: cat_id,
                sub_cat_id: sub_cat_id,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
                for (let i = 0; i < result.length; i++) {
                    value = result[i];
                    if (value.attr_type == "checkbox") {
                        name = "attr_check_" + result[i].id;
                    } else {
                        name = "attr_" + result[i].id;
                    }

                    if (value.attr_type == "text") {
                        $("#attrdiv").append("<div class='form-group col-md-6'><label>" + value
                            .attr_name + "</label><input name='" + name +
                            "' type='text' maxlength='100' class='form-control'  /></div>");
                    } else if (value.attr_type == "date") {
                        $("#attrdiv").append("<div class='form-group col-md-6'><label>" + value
                            .attr_name + "</label><input name='" + name +
                            "' onkeyup='return false' type='date'  class='form-control'  /></div>"
                        );
                    } else if (value.attr_type == "textarea") {
                        $("#attrdiv").append("<div class='form-group col-md-6'><label>" + value
                            .attr_name + "</label><textarea name='" + name +
                            "' maxlength='500' class='form-control' ></textarea></div>");
                    } else if (value.attr_type == "dropdown") {
                        option = "<option value=''>Select</option>";
                        myArray = value.attr_value.split(",");
                        let j = 0;
                        while (j < myArray.length) {
                            option = option + "<option value='" + myArray[j] + "' >" + myArray[j] +
                                "</option>";
                            j++;
                        }
                        $("#attrdiv").append("<div class='form-group col-md-6'><label>" + value
                            .attr_name + "</label><select name='" + name +
                            "' class='form-control'>" + option + "</select></div>");
                    } else if (value.attr_type == "checkbox") {
                        option = "";
                        myArray = value.attr_value.split(",");
                        let j = 0;
                        while (j < myArray.length) {
                            option = option + "<label class='checkbox-inline' ><input name='" +
                                name + "[]' type='checkbox' value='" + myArray[j] + "' />aaa" +
                                myArray[j].toString() + "</label>";
                            j++;
                        }
                        $("#attrdiv").append("<div class='col-md-12'>" + option + "</div>");
                    }
                }
            },
            error: function(result) {
                console.log(result);
            }
        });
    });

    $('#file').on('change', function() {
        oFiles = this.files,
            nFiles = oFiles.length;
        if (nFiles == 0) return;
        for (var nFileId = 0; nFileId < nFiles; nFileId++) {
            fileSize = oFiles[nFileId].size / 1024 / 1024;
            if (fileSize > 10) {
                alert('File size exceeds 10 MB');
                $('#photo').val('');
                return;
            }
        }
    });

    $('#myMapModal').on('shown.bs.modal', function(e) {
        $("#confirm_btn").attr("disabled", true);
        var location = "";
        location = $("#location2").val();
        if (location == "") {
            initialize(new google.maps.LatLng("8.18680451929113", "77.41143559463588"));
        } else {
            var data = location.split(',')
            initialize(new google.maps.LatLng(data[0], data[1]));
        }
    });

    var lat = "";
    var lng = "";
    var map;

    function initialize(myCenter) {
        var marker = new google.maps.Marker({
            position: myCenter
        });
        var mapProp = {
            center: myCenter,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
        marker.setMap(map);
        google.maps.event.addListener(map, "click", function(event) {
            var myLatLng = event.latLng;
            lat = myLatLng.lat();
            lng = myLatLng.lng();
            $("#confirm_btn").removeAttr("disabled");
        });
    }

    function load_address(lat2, lng2) {
        console.log(lat2);
        $.getJSON("https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" + lat2 + "&lon=" + lng2, function(
            data) {
            console.log(data.address);
            district2 = data.address.state_district;
            district2 = district2.replace(" District", "");
            state2 = data.address.state;
            state2 = state2.toUpperCase();
            postcode2 = data.address.postcode;
            formattedAddress = '';
            if (data.address.road != undefined) {
                formattedAddress += data.address.road + ' ';
            }
            if (data.address.neighbourhood != undefined) {
                formattedAddress += data.address.neighbourhood + ' ';
            }
            if (data.address.suburb != undefined) {
                formattedAddress += data.address.suburb + ' ';
            }
            if (data.address.city != undefined) {
                formattedAddress += data.address.city + ' ';
            }
            if (data.address.state != undefined) {
                formattedAddress += data.address.state + ' ';
            }
            if (data.address.postcode != undefined) {
                formattedAddress += data.address.postcode + ' ';
            }
            if (data.address.country != undefined) {
                formattedAddress += data.address.country + ' ';
            }
            console.log(formattedAddress);
            $("#address").val(formattedAddress);
            $("#address2").val(formattedAddress);
            $("#state_id").val(state2);
            load_city(state2);
        });
    }

    function get_location() {
        if (lat != "") $("#location2").val(lat + "," + lng);
        load_address(lat, lng);
        $("#myMapModal").modal('hide');
    }

    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        $("#location2").val(latitude + "," + longitude);
        load_address(latitude, longitude);
    }


    function getcurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Sorry, browser does not support geolocation!");
        }
    }

    function showselectmap() {
        $("#myMapModaltop").modal('show');
    }

    var lat = "";
    var lng = "";
    var map;

    function initialize3(myCenter) {
        var marker = new google.maps.Marker({
            position: myCenter
        });
        var mapProp = {
            center: myCenter,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas3"), mapProp);
        marker.setMap(map);
        google.maps.event.addListener(map, "click", function(event) {
            var myLatLng = event.latLng;
            lat = myLatLng.lat();
            console.log("here" + lat);
            lng = myLatLng.lng();
        });
    }

    function closeshowselectmap() {
        $("#myMapModaltop").modal('hide');
    }

    function confirmshowselectmap() {
        load_addresstop(lat, lng);
        $("#myMapModaltop").modal('hide');
    }

    $('#myMapModaltop').on('shown.bs.modal', function(e) {
        var lat3 = $("#latitudetop").val();
        var lng3 = $("#longitudetop").val();
        initialize3(new google.maps.LatLng(lat3, lng3));
    });

    $('.number').keypress(function(event) {
        var keycode = event.which;
        if (!(event.shiftKey == false && (keycode == 8 || keycode == 37 || keycode == 39 || (keycode >=
                48 && keycode <= 57)))) {
            event.preventDefault();
        }
    });

    function load_addresstop(lat2, lng2) {
        $.getJSON("https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" + lat2 + "&lon=" + lng2, function(
            data) {
            formattedAddress = '';
            if (data.address.suburb != undefined) {
                formattedAddress += data.address.suburb + ' ';
            }
            if (data.address.city != undefined) {
                formattedAddress += data.address.city;
            }
            $("#current_locationtop").text(formattedAddress);
            $("#current_location_span").text(formattedAddress);
            $("#latitudetop").val(lat2);
            $("#longitudetop").val(lng2);
        });
    }

    function nearby() {
        var lat = $("#latitudetop").val();
        var lng = $("#longitudetop").val();
        window.location.href = "{{ url('/nearby') }}/" + lat + "/" + lng;
    }

    function showLocationtop(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        load_addresstop(latitude, longitude);
    }

    function errorHandlertop(err) {
        if (err.code == 1) {
            //alert("Error: Access is denied!");
        } else if (err.code == 2) {
            alert("Error: Position is unavailable!");
        }
    }

    function getcurrentLocationtop() {
        if (navigator.geolocation) {
            var options = {
                timeout: 60000
            };
            navigator.geolocation.getCurrentPosition(showLocationtop, errorHandlertop, options);
        } else {
            alert("Sorry, browser does not support geolocation!");
        }
    }

    jQuery(document).ready(function($) {
        getcurrentLocationtop();
    });

    function removefavorites(user_id, product_id) {
        var url = "{{url('/removefavorites')}}/" + user_id + "/" + product_id;
        $.ajax({
            url: url,
            type: "GET",
            success: function(result) {
                window.location.href = "{{ url('/user/wish') }}";
            },
            error: function(error) {
                console.log(JSON.stringify(error));
            }
        });
    }

    function markassold(product_id) {
        $.ajax({
            url: "{{url('/markassold')}}/" + product_id,
            type: "GET",
            success: function(result) {
                window.location.href = "{{ url('/user/my_products') }}";
            },
            error: function(error) {
                console.log(JSON.stringify(error));
            }
        });
    }

    $(document).ready(function(){
      $("body").on("change", "#file", function(e){
        $('.singleImageCanvasContainer').remove();
        $('#post_img_data').val('');
      });
    })

    var c;
    var galleryImagesContainer = document.getElementById('galleryImages');
    var imageCropFileInput = document.getElementById('file');
    var cropperImageInitCanvas = document.getElementById('cropperImg');
    var cropImageButton = document.getElementById('cropImageBtn');
    // Crop Function On change
    function imagesPreview(input) {
      var cropper;
        //cropImageButton.className = 'show';
        var img = [];
        if (input.files.length) {
          var i = 0;
          var index = 0;
          for (let singleFile of input.files) {
            var reader = new FileReader();
            reader.onload = function(event) {
              var blobUrl = event.target.result;
              img.push(new Image());
              img[i].onload = function(e) {
                        // Canvas Container
                        var singleCanvasImageContainer = document.createElement('div');
                        singleCanvasImageContainer.id = 'singleImageCanvasContainer'+index;
                        singleCanvasImageContainer.className = 'singleImageCanvasContainer';
                        // Canvas Close Btn
                        var singleCanvasImageCloseBtn = document.createElement('button');
                        var singleCanvasImageCloseBtnText = document.createTextNode('X');
                        // var singleCanvasImageCloseBtnText = document.createElement('i');
                        // singleCanvasImageCloseBtnText.className = 'fa fa-times';
                        singleCanvasImageCloseBtn.id = 'singleImageCanvasCloseBtn'+index;
                        singleCanvasImageCloseBtn.className = 'singleImageCanvasCloseBtn';
                        singleCanvasImageCloseBtn.classList.add("btn", "btn-sm");
                        singleCanvasImageCloseBtn.onclick = function() { 
                          removeSingleCanvas(this) 
                        };
                        singleCanvasImageCloseBtn.appendChild(singleCanvasImageCloseBtnText);
                        singleCanvasImageContainer.appendChild(singleCanvasImageCloseBtn);
                        // Image Canvas
                        var canvas = document.createElement('canvas');
                        canvas.id = 'imageCanvas'+index;
                        canvas.className = 'imageCanvas singleImageCanvas';
                        canvas.width = e.currentTarget.width;
                        canvas.height = e.currentTarget.height;
                        canvas.onclick = function() { cropInit(canvas.id); };
                        singleCanvasImageContainer.appendChild(canvas)
                        // Canvas Context
                        var ctx = canvas.getContext('2d');
                        ctx.drawImage(e.currentTarget,0,0);
                        // galleryImagesContainer.append(canvas);
                        galleryImagesContainer.appendChild(singleCanvasImageContainer);
                        // while (document.querySelectorAll('.singleImageCanvas').length == input.files.length) {
                        //     var allCanvasImages = document.querySelectorAll('.singleImageCanvas')[0].getAttribute('id');
                        //     console.log(allCanvasImages);
                        //     //commented by sam
                        //     //cropInit(allCanvasImages);
                        //     break;
                        // };
                        urlConversion();
                        index++;
                      };
                      img[i].src = blobUrl;
                      i++;
                    }
                    reader.readAsDataURL(singleFile);
                  }
                }
              }

              imageCropFileInput.addEventListener("change", function(event){
                
                $('#cropperModal').modal('show');
                var mediaValidation = validatePostMedia(event.target.files);
                if(!mediaValidation){
                  var $el = $('#file');
                  $el.wrap('<form>').closest('form').get(0).reset();
                  $el.unwrap();
                  return false;
                }

                $('#mediaPreview').empty();
                $('.singleImageCanvasContainer').remove();
                if(cropperImageInitCanvas.cropper){
                  cropperImageInitCanvas.cropper.destroy();
                  cropperImageInitCanvas.width = 0;
                  cropperImageInitCanvas.height = 0;
                  cropImageButton.style.display = 'none';
                }
                imagesPreview(event.target);
              });
    // Initialize Cropper
    function cropInit(selector) {
      c = document.getElementById(selector);
      
      if(cropperImageInitCanvas.cropper){
        cropperImageInitCanvas.cropper.destroy();
      }
      var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
      for (let element of allCloseButtons) {
        element.style.display = 'block';
      }
      c.previousSibling.style.display = 'none';
        // c.id = croppedImg;
        var ctx=c.getContext('2d');
        var imgData=ctx.getImageData(0, 0, c.width, c.height);
        var image = cropperImageInitCanvas;
        image.width = c.width;
        image.height = c.height;
        var ctx = image.getContext('2d');
        ctx.putImageData(imgData,0,0);

        cropper = new Cropper(image, {
          aspectRatio: 16/9,
          viewMode: 4,
          preview: '.img-preview',
          crop: function(event) {
            cropImageButton.style.display = 'block';
          }
        });

      }
      
      function image_crop() {
        if(cropperImageInitCanvas.cropper){
          var cropcanvas = cropperImageInitCanvas.cropper.getCroppedCanvas({
            width: 250, height: 250
          });
            // document.getElementById('cropImages').appendChild(cropcanvas);
            var ctx=cropcanvas.getContext('2d');
            var imgData=ctx.getImageData(0, 0, cropcanvas.width, cropcanvas.height);
            // var image = document.getElementById(c);
            c.width = cropcanvas.width;
            c.height = cropcanvas.height;
            var ctx = c.getContext('2d');
            ctx.putImageData(imgData,0,0);
            cropperImageInitCanvas.cropper.destroy();
            cropperImageInitCanvas.width = 0;
            cropperImageInitCanvas.height = 0;
            cropImageButton.style.display = 'none';
            var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
            for (let element of allCloseButtons) {
              element.style.display = 'block';
            }
            urlConversion();
          } else {
            alert('Please select any Image you want to crop');
          }
        }
        cropImageButton.addEventListener("click", function(){
          image_crop();
        });
    // Image Close/Remove
    function removeSingleCanvas(selector) {
      selector.parentNode.remove();
      urlConversion();
    }
    
    function urlConversion() {
      var allImageCanvas = document.querySelectorAll('.singleImageCanvas');
      var convertedUrl = '';
      canvasLength = allImageCanvas.length;
      for (let element of allImageCanvas) {
        convertedUrl += element.toDataURL('image/jpeg');
        convertedUrl += 'img_url';
      }
      document.getElementById('post_img_data').value = convertedUrl;
    }
    function validatePostMedia(files){

      $('#imageValidate').empty();
      let err = 0;
      let ResponseTxt = '';
      if(files.length > 10){
        err += 1;
        ResponseTxt += '<p> You can select maximum 10 files. </p>';
      }
      $(files).each(function(index, file) {
        if(file.size > 10048576){
          err +=  1;
          ResponseTxt += 'File : '+file.name + ' is greater than 10MB';
        }
      });

      if(err > 0){
        $('#imageValidate').html(ResponseTxt);
        return false;
      }
      return true;
      
    }
    </script>

</body>

</html>