<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invitation</title>
        @include('templates/css')
      
    </head>
    
    <body class="login-content">
        <!-- Login -->
        <form name="login" id="loginForm">
            <input type="hidden"  class="form-control" name="token" value="{{$data['token']}}"> 
            
        <div class="lc-block toggled" id="l-login">
            <div id="error"></div>
             <blockquote style='border:1px solid #ccc' class="m-b-25">
                 <p class="text-center">You are invited to join team <b>{{$data['teamName']}}</b></p>                  
        </blockquote>
           
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                    <input type="text" readonly class="form-control" name="email" value="{{$data['email']}}"> 
                </div>
            </div>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                <div class="fg-line">
                    <input type="password" name="password" class="form-control" placeholder="Create Password">
                </div>
            </div>
            
            <div class="clearfix"></div>
            
           
            
            <a  class="btn btn-login btn-danger btn-float" onclick="invitationLogin() "><i class="zmdi zmdi-arrow-forward"></i></a>
            
          
        </div>
             <br/><br/>
    <p style='bottom:0'>&copy;2015 Fusionmate <a href='http://fusionmate.com'>www.fusionmate.com</a></p>
        </form>
        
      
        
       
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
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL')  ?>fusionmate/public/plugins/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL')  ?>fusionmate/public/plugins/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL')  ?>fusionmate/public/plugins/vendors/bower_components/Waves/dist/waves.min.js"></script>
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL')  ?>fusionmate/public/plugins/js/functions.js"></script>
        <script>
        function invitationLogin()
        {
            
            $.ajax({
                url: "/login",
                type: "POST",
                dataType: "JSON",
                data: $("#loginForm").serialize()
            }).done(function (data) {
                if (data.success == true)
                    window.location.assign( "<?php echo Config::get('constants.constants_list.BASE_URL')  ?>home");
                else{
                var erreurs = '<div class="alert alert-info alert-dismissible" role="alert">';
                        erreurs += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        erreurs += ' <h5 style="color:#fff" class="text-center">'
                        $(data.errors).each(function (i, error) {

                            if (error.email != undefined)
                                erreurs += error.email + '<br/> ';
                            if (error.password != undefined)
                                erreurs += error.password + '<br/> ';
                            if (error.errormsg != undefined)
                                erreurs += error.errormsg;

                        });
                        erreurs += '</h5></div>';
                        $('#error').html(erreurs);    
                }
            });
        }
        
        
        </script>
    </body>
</html>