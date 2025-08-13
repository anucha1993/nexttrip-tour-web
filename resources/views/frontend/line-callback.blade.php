<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head></head>

<body>
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-ui.js')}}"></script>
    <script src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>
    <script>
            var profile = null;
            liff.init({ liffId: '2003705473-mOBqvyPY' },async () => {
                if(!liff.isLoggedIn()){
                    console.log('logout')
                    await liff.login();
                }else{
                // if(liff.isLoggedIn()){
                    console.log('login')
                    profile = await liff.getProfile();
                    console.log(profile)
                    $.ajax({
                        type: 'POST',
                        url: '{{url("/line-login")}}',
                        data: {
                            _token: '{{csrf_token()}}',
                            profile:profile,
                        },
                        success: function (data) {
                                if(data){
                                    window.location.replace('/member-booking');
                                }else{
                                    liff.login();
                                }
                        },
                    });
                }
            });
    </script>
</body>

</html>