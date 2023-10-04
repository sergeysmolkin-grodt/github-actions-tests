<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<!-- Google Autocomplete -->
<!--<script type="text/javascript" src="<?= url('public/') ?>/web/js/jquery.min.js"></script>-->
<script type="text/javascript" src="<?= url('public/') ?>/web/js/plugins.js"></script>
<script type="text/javascript" src="<?= url('public/') ?>/web/js/scripts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<!-- Step Wizard -->
<script src="<?= url('public/') ?>/web/js/lib/modernizr-2.6.2.min.js"></script>
<script src="<?= url('public/') ?>/web/js/lib/jquery.cookie-1.3.1.js"></script>
<script src="<?= url('public/') ?>/web/js/lib/jquery.steps.js"></script>

<!-- Time and date picker -->
<script src="<?= url('public/') ?>/web/js/time/ripples.min.js"></script>
<script type="text/javascript" src="<?= url('public/') ?>/web/js/time/moment-with-locales.min.js"></script>
<script type="text/javascript" src="<?= url('public/') ?>/web/js/time/bootstrap-material-datetimepicker.js"></script>

<script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script>
<script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>

<!-- other map link -->
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script>
<script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>


<script src="<?= url('public/') ?>/web/codingzon/codingzon.js"></script>

<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>

<script src="<?= url('public/') ?>/web/codingzon/real-time-js.js"></script>
<script src="<?= url('public/') ?>/web/codingzon/validation.js"></script>


<script>

    var handler = StripeCheckout.configure({
        key: "<?= config('constants.stripe.publish_key') ?>",
        image: "https://stripe.com/img/documentation/checkout/marketplace.png",
        name: "RapidRef Payment",
        description: "Payment for request Referee.",
        panelLabel: "Subscribe",
        token: function (token) {
            console.log(token);
            var formData = new FormData($(this).closest('form')[0]);
            formData.append('_token', csrf_token);
            formData.append('address', $('#request-address').val());
            formData.append('country', $('#country-select-box').val());
            formData.append('state', $('#getAllCountryStates').val());
            formData.append('city', $('#getAllStatesCities').val());
            formData.append('date', $('#date').val());
            formData.append('time', $('#request_time').val());
            formData.append('team_name', $('#team_name').val());
            formData.append('age_of_players', $('#age_of_players').val());
            formData.append('total_payble_payment', $('#total_payble_payment').val());
            formData.append('no_of_referees', $('#no_of_referees').val());
            formData.append('game_level', $('#game_level').val());
            formData.append('game_type', $('#game_type').val());
            formData.append('payble_amount', $('#total_payble_payment').val());
            formData.append('payment_token', token.id);
            formData.append('isRefereeFound', $('#isRefereeFound').val());
            formData.append('primary_category', $('#primary_category').val());
            formData.append('youth_for_boy_and_girls', $('#youth_for_boy_and_girls').val());
            formData.append('youth_division', $('#youth_division').val());
            formData.append('adult_division', $('#adult_division').val());

            $.ajax({
                url: BaseURLForUser + '/submitRequest',
                data: formData,
                type: 'POST',
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#referee-request-register-processing').html('<span class="fa fa-refresh fa-spin" style="font-size:16px"></span>&nbsp;&nbsp;We are processing your request.');
                },
                success: function (response) {
                    $('#referee-request-register-processing').html('<span>Request</span>');
                    jsonData = JSON.parse(response);
                    if (jsonData.status == 1) {
                        toastr.success(jsonData.message);
                        var timer = setTimeout(function () {
                            window.location = BaseURLForUser + '/thankYouPage';
                        }, 5000);
                    } else {
                        toastr.error(jsonData.message);
                    }
                },
                error: function (data) {
                    $('#referee-request-register-processing').html('<span>Request</span>');
                    toastr.error("Somthing went wrong!");
                }
            });

//            alert($('#country-select-box').val());

//            alert(token);
            // You can access the token ID with `token.id`.
            // Get the token ID to your server-side code for use.
        },
        allowRememberMe: false
    });


    $(function () {
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft"
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {

        $('#date').bootstrapMaterialDatePicker
        ({
            time: false,
            clearButton: true
        });

        $('#time').bootstrapMaterialDatePicker
        ({
            date: false,
            shortTime: false,
            format: 'HH:mm'
        });

        $('#date-format').bootstrapMaterialDatePicker
        ({
            format: 'dddd DD MMMM YYYY - HH:mm'
        });
        $('#date-fr').bootstrapMaterialDatePicker
        ({
            format: 'DD/MM/YYYY HH:mm',
            lang: 'fr',
            weekStart: 1,
            cancelText: 'ANNULER',
            nowButton: true,
            switchOnClick: true
        });

        $('#date-end').bootstrapMaterialDatePicker
        ({
            weekStart: 0, format: 'DD/MM/YYYY HH:mm'
        });
        $('#date-start').bootstrapMaterialDatePicker
        ({
            weekStart: 0, format: 'DD/MM/YYYY HH:mm', shortTime: true
        }).on('change', function (e, date) {
            $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        });

        $('#min-date').bootstrapMaterialDatePicker({format: 'DD/MM/YYYY HH:mm', minDate: new Date()});

        // $.material.init()
    });
</script>


<script>

    $(function () {
        $("#datepicker").datepicker();
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

<script type="text/javascript">
    //jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    $(".next").click(function () {
        if (animating)
            return false;
        animating = true;

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function (now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'position': 'absolute'
                });
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".previous").click(function () {
        if (animating)
            return false;
        animating = true;

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function (now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1 - now) * 50) + "%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'left': left});
                previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".submit").click(function () {
        return false;
    })

</script>

<script type="text/javascript">


    window.onload = function () {
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2F3YW4wMDEiLCJhIjoiY2p5cXlicHJqMDUwaDNkbWFoODYzMzExNSJ9.nwzziqcYNnTgyVMpPTUUeA';
// eslint-disable-next-line no-undef
        var mapboxClient = mapboxSdk({accessToken: mapboxgl.accessToken});
        mapboxClient.geocoding.forwardGeocode({
            query: $('#mapAddress').val(),
            autocomplete: false,
            limit: 1
        })
            .send()
            .then(function (response) {
                if (response && response.body && response.body.features && response.body.features.length) {
                    var feature = response.body.features[0];

                    var map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: feature.center,
                        zoom: 10
                    });
                    new mapboxgl.Marker()
                        .setLngLat(feature.center)
                        .addTo(map);
                }
            });
    }

    // window.onload = function () {
    //     L.mapquest.key = 'IhnFzpv88Qu9RrGx35ljxQXpoy0epLdA';
    //
    //     // Geocode three locations, then call the createMap callback
    //     L.mapquest.geocoding().geocode([$('#mapAddress').val()], createMap);
    //
    //     function createMap(error, response) {
    //         // Initialize the Map
    //         var map = L.mapquest.map('map', {
    //             layers: L.mapquest.tileLayer('map'),
    //             center: [0, 0],
    //             zoom: 12
    //         });
    //
    //         // Generate the feature group containing markers from the geocoded locations
    //         var featureGroup = generateMarkersFeatureGroup(response);
    //
    //         // Add markers to the map and zoom to the features
    //         featureGroup.addTo(map);
    //         map.fitBounds(featureGroup.getBounds());
    //     }
    //
    //     function generateMarkersFeatureGroup(response) {
    //         var group = [];
    //         for (var i = 0; i < response.results.length; i++) {
    //             var location = response.results[i].locations[0];
    //             var locationLatLng = location.latLng;
    //
    //             // Create a marker for each location
    //             var marker = L.marker(locationLatLng, {icon: L.mapquest.icons.marker()})
    //                     .bindPopup(location.adminArea5 + ', ' + location.adminArea3);
    //
    //             group.push(marker);
    //         }
    //         return L.featureGroup(group);
    //     }
    // }


    var selectedCountries = $('#country-select-box').val();
    $.ajax({
        url: BaseURLForReferee + '/getStates',
        data: {'_token': csrf_token, country: selectedCountries},
        type: 'POST',
        cache: false,
        success: function (response) {
            jsonData = JSON.parse(response);
            $('#getAllCountryStates').html(jsonData.response);
            var selectedStates = $('#getAllCountryStates').val();
            $.ajax({
                url: BaseURLForReferee + '/getCities',
                data: {'_token': csrf_token, state: selectedStates},
                type: 'POST',
                cache: false,
                success: function (response) {
                    jsonData = JSON.parse(response);
                    $('#getAllStatesCities').html(jsonData.response);
                }
            });
        }
    });


</script>

<script>

    $('#country-select-box').change(function () {
        var selectedCountries = this.value;
        $.ajax({
            url: BaseURLForReferee + '/getCountryStates',
            data: {'_token': csrf_token, country: selectedCountries},
            type: 'POST',
            cache: false,
            success: function (response) {
                jsonData = JSON.parse(response);
                $('#getAllCountryStates').html(jsonData.response);
            },
            error: function (data) {
                toastr.error("Somthing went wrong!");
            }
        });
    });

    $('#getAllCountryStates').on('change', function () {
        var selectedStates = this.value;
        $.ajax({
            url: BaseURLForReferee + '/getStatesCities',
            data: {'_token': csrf_token, state: selectedStates},
            type: 'POST',
            cache: false,
            success: function (response) {
                jsonData = JSON.parse(response);
                $('#getAllStatesCities').html(jsonData.response);
            },
            error: function (data) {
                toastr.error("Somthing went wrong!");
            }
        });
    });

    function setTabForLogin(getTabNo) {
        window.localStorage.setItem('currentLoginSession', getTabNo)
    }

    if (window.localStorage.getItem('currentLoginSession') == 'tab_2') {
//        alert(window.localStorage.getItem('currentLoginSession'))
        $('#set-tab-two-default').addClass('current');
        $('.tab-two-content').attr('style', 'display: block');
        $('.tab-one-content').attr('style', 'display: none');
        $('#team-login-message').attr('style', 'display: none');
    } else {
//        alert(window.localStorage.getItem('currentLoginSession'))
        $('#set-tab-one-default').addClass('current');
        $('.tab-one-content').attr('style', 'display: block');
        $('.tab-two-content').attr('style', 'display: none');
        $('#referee-login-message').attr('style', 'display: none');
    }
    //    alert(localStorage.getItem('currentLoginSession'));
</script>






