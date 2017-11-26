<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>

    <!-- Vendor CSS -->
    <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

    <!-- CSS -->
    <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/css/app.min.1.css" rel="stylesheet">
    <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/css/app.min.2.css" rel="stylesheet">
</head>

<body class="login-content">
    <!-- Forgot Password -->

    <div class="lc-block" id="l-forget-password" >

        @if($errors->any())
        @if($errors->first()=="success")
        <div class="alert alert-success" role="alert">
            {{"Email sent successfully.Please check ur mail"}}
        </div>
        @endif
        @if($errors->first()=="error")
        <div class="alert alert-danger" role="alert">
            {{"Invalid email or email doesn't exists! "}}
        </div>
        @endif
        @endif
        <blockquote style='border:1px solid #ccc' class="m-b-25">
            <p class="text-center">An email will be sent with a link to reset your password</p>                  
        </blockquote>

        <form id='reset' action="/post_remind" method="POST">

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                    <input type="email" name="email" class="form-control" placeholder="Email Address">
                </div>

            </div>
            <center><a href='/'>LOGIN</a> </center>
            <a  onclick="submit()" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>
        </form>

    </div>
    <br/><br/>
    <p style='bottom:0'>&copy;2015 Fusionmate <a href='http://fusionmate.com'>www.fusionmate.com</a></p>


</div>

<!-- Older IE warning message -->
<!--[if lt IE 9]>
    <div class="ie-warning">
        <h1 class="c-white">Warning!!</h1>
        <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
        <div class="iew-container">
            <ul class="iew-download">
                <li>
                    <a href="http://www.google.com/chrome/">
                        <img src="img/browsers/chrome.png" alt="">
                        <div>Chrome</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.mozilla.org/en-US/firefox/new/">
                        <img src="img/browsers/firefox.png" alt="">
                        <div>Firefox</div>
                    </a>
                </li>
                <li>
                    <a href="http://www.opera.com">
                        <img src="img/browsers/opera.png" alt="">
                        <div>Opera</div>
                    </a>
                </li>
                <li>
                    <a href="https://www.apple.com/safari/">
                        <img src="img/browsers/safari.png" alt="">
                        <div>Safari</div>
                    </a>
                </li>
                <li>
                    <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                        <img src="img/browsers/ie.png" alt="">
                        <div>IE (New)</div>
                    </a>
                </li>
            </ul>
        </div>
        <p>Sorry for the inconvenience!</p>
    </div>   
<![endif]-->

<!-- Javascript Libraries -->
<script src="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/vendors/bower_components/Waves/dist/waves.min.js"></script>

<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
    <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
<![endif]-->

<script src="<?php echo Config::get('constants.constants_list.BASE_URL') ?>fusionmate/public/plugins/js/functions.js"></script>
<script>
        function submit()
        {
            if ($('input').val() == '')
                return false;
            $("#reset").submit();
        }


</script>
</body>
</html>