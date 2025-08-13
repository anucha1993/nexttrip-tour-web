<?php
	if(empty($_title)) 			$_title ='Next Trip Holiday';
	if(empty($_keywords)) 		$_keywords ='';
	if(empty($_description)) 	$_description ='';
?>
    <title>
        <?php echo $_title;?>
    </title>
    <meta name="keywords" content="<?php echo $_keywords;?>" />
    <meta name="description" content="<?php echo $_description;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robot" content="index, follow" />
    <meta name='copyright' content='Orange Technology Solution co.,ltd.'>
    <meta name='designer' content='Netthakan O.'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta property="og:image" content="{{asset('frontend/images/logo.png')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('frontend/css/layout.css')}}"/>
    <link type="image/ico" rel="shortcut icon" href="{{asset('frontend/images/favicon.ico')}}">
    <!-- Sweet Alert-->
    <link href="{{ asset('frontend/dist/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Toastr Alert-->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/dist/toastr/toastr.min.css')}}" />


    
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-ui.js')}}"></script>
    <script src="{{asset('frontend/js/modernizr.js')}}"></script>
    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.fancybox.min.js')}}"></script>
    <script src="{{asset('frontend/js/popper.min.js')}}" {{-- integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous" --}}></script>
    <script src="{{asset('frontend/js/jquery.flipster.min.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('frontend/dist/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr Alert-->
    <script src="{{asset('frontend/dist/toastr/toastr.js')}}"></script>
     <!-- datepicker-->
    <script src="{{asset('frontend/js/datepicker.js')}}"></script>
    <script src="{{asset('frontend/js/daterangepicker.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/daterangepicker.css')}}"/>
    
    <script>
        $(document).ready(function() {
        // Show or hide the sticky footer button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
            $('.go-top').fadeIn(300);
            } else {
            $('.go-top').fadeOut(300);
            }
        });

        // Animate the scroll to top
        $('.go-top').click(function(event) {
            event.preventDefault();

            $('html, body').animate({
            scrollTop: 0
            }, 800);
        })
        });

 </script>
     <!-- Your ปลั๊กอินแชท code -->
    <div class="fb-customerchat" page_id="166748676864456" ></div>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '889213402583913',
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v7.0'
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
     
    {{-- <div id="fb-customer-chat" class="fb-customerchat"></div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "163432046848877");
        chatbox.setAttribute("attribution", "biz_inbox");
        </script>

        <!-- Your SDK code -->
        <script>
        window.fbAsyncInit = function() {
            FB.init({
            xfbml            : true,
            version          : 'v18.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/th_TH/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script> --}}
<a href="#" class="go-top">  <span><i class="fas fa-angle-up"></i></span> </a>
    
    
    @if (session('alert'))
    <script type="text/javascript">
    $(function() { 
            Swal.fire({
                icon: "{!! session('alert.status') !!}",
                title: "{!! session('alert.msg') !!}",
                text: "",
                // showConfirmButton: false,
                // timer: 2000
            })
    });
    </script>
    @endif

    @if(Session::has('success'))
    <script type="text/javascript">
        $(function() {
            toastr.success("{{ session('success') }}");
        });
    </script>
    @endif

    @if(Session::has('error'))
    <script type="text/javascript">
        $(function() {
            toastr.error("{{ session('error') }}");
        });
    </script>
    @endif

    @if(Session::has('info'))
    <script type="text/javascript">
        $(function() {
            toastr.info("{{ session('info') }}");
        });
    </script>
    @endif

    @if(Session::has('warning'))
    <script type="text/javascript">
        $(function() {
            toastr.warning("{{ session('warning') }}");
        });
    </script>
    @endif


    <script type="text/javascript">
		$(document).ready(function() {
			$(".select-display-slide > li").click(function() {
				var rel = $(this).attr("rel");
				$('.display-slide').hide();
				$('.display-slide[rel=' + rel + ']').fadeIn();
				$(".select-display-slide > li").removeClass("active");
				$(this).addClass("active");
			});
		});
	</script>

