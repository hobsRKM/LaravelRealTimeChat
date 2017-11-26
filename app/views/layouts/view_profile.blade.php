<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fusion Mate</title>
    
        <!-- Vendor CSS -->
        <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css" rel="stylesheet">
        <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">        
        <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
            
        <!-- CSS -->
        <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/css/app.min.1.css" rel="stylesheet">
        <link href="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/css/app.min.2.css" rel="stylesheet">
    </head>
    <style>
        .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
    display: block;
    height: 250px;
    max-width: 100%;
}
    </style>
    
    <body>
        <header id="header" class="clearfix" data-current-skin="blue">
            <ul class="header-inner">
               

                <li class="logo hidden-xs">
                    <a href="index.html">Fusion Mate</a>
                </li>

            </ul>


            <!-- Top Search Content -->
            <div id="top-search-wrap">
                <div class="tsw-inner">
                    <i id="top-search-close" class="zmdi zmdi-arrow-left"></i>
                    <input type="text">
                </div>
            </div>
        </header>
        
        <section id="main">
            
        
            <section id="content">
                <div class="container">
                    
                    <div class="block-header">
                        <h2><?php echo($userDetailsArray['first_name']." ".$userDetailsArray['last_name']); ?><small></small></h2>
                        
                        
                    </div>
                   
                    <div class="card" id="profile-main">
                        <div class="pm-overview c-overflow">
                            <div class="pmo-pic">
                                <div class="p-relative">
                                    <a href="">
                                        
                                        <?php if($userDetailsArray['profile_pic']!=""){ ?>
                                        <img class="img-responsive"   src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/profile_pics/{{$userDetailsArray['profile_pic'];}}" alt=""> 
                                        <?php } else{ ?>
                                         <img class="img-responsive"  src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/images/default_user_icon.png" alt=""> 
                                         <?php }  ?>
                                    </a>
                                    
                                   
                                </div>
                                
                                
                                
                            </div>
                            
                            
                        </div>
                        
                        <div class="pm-body clearfix">
                            <ul class="tab-nav tn-justified">
                                <li class="active waves-effect"><a href="profile-about.html">About</a></li>
                            </ul>
                            
                            
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-equalizer m-r-5"></i> Summary</h2>
                                    
                                    
                                </div>
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                        <?php echo($userDetailsArray['summary']); ?>
                                        </div>
                                    
                                </div>
                            </div>
                            
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-account m-r-5"></i> Basic Information</h2>
                                    
                                </div>
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                        <dl class="dl-horizontal">
                                            <dt>Full Name</dt>
                                            <dd><?php echo($userDetailsArray['first_name']." ".$userDetailsArray['last_name']); ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Gender</dt>
                                            <dd><?php echo($userDetailsArray['gender']); ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Birthday</dt>
                                            <dd><?php echo($userDetailsArray['birthday']); ?></dd>
                                        </dl>
                                    </div>
                                    
                                  
                                </div>
                            </div>
                       
                        
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-phone m-r-5"></i> Contact Information</h2>
                                    
                                    
                                </div>
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                       
                                        <dl class="dl-horizontal">
                                            <dt>Mobile Phone</dt>
                                            <dd>{{$userDetailsArray['contact']}}</dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Email Address</dt>
                                            <dd>{{$userDetailsArray['email']}}></dd>
                                        </dl>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        
        <footer id="footer">
            Copyright &copy; 2015 Material Admin
            
            <ul class="f-menu">
                <li><a href="">Home</a></li>
                <li><a href="">Dashboard</a></li>
                <li><a href="">Reports</a></li>
                <li><a href="">Support</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </footer>

        <!-- Page Loader -->
        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Please wait...</p>
            </div>
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
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
                <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/js/functions.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/js/demo.js"></script>
    
    <script>
    
     $('.date-picker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
      $('.date-time-picker').datetimepicker();
    </script>
    </body>
</html>