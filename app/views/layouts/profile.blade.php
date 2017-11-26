<?php  $usserID=(Request::segment(2)); ?>
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fusion Mate</title>
    
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
    
    max-width: 100%;
}
#imageDiv{
   
    top: 50%;
    left: 50%;
    
    margin-left: -115px;
   
}​
    </style>
    <script>
        function imageValidate() {
            var image = document.getElementById('avatar').value;
            if(image==""){
                 var erreurs = '<div class="alert alert-danger alert-dismissible" role="alert">';
                        erreurs += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        erreurs += ' <h5 style="color:#fff" class="text-center">Please Select a Image'
                        erreurs += '</h5></div>';
                         $('#inner').append(erreurs);
                
    
    }else{
        
       document.getElementById("imageUpload").submit();
    }
    }
    </script>
    <body>
        <header id="header" class="clearfix" data-current-skin="blue">
            <ul class="header-inner">
                

                <li class="logo hidden-xs">
                    <a href="index.html">Fusion Mate</a>
                </li>

                
            </ul>

        </header>
        
        <section id="main">

            
        
        
            <section id="content">
                <div class="container">
                    
                    <div class="block-header">
                        <h2><?php echo($userDetailsArray['first_name']." ".$userDetailsArray['last_name']); ?><small></small></h2>
                      
                    </div>
                    @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
                    <div class="card" id="profile-main">
                        <div class="pm-overview c-overflow">
                            <div class="pmo-pic">
                                <div class="p-relative">
                                    <a href="">
                                           <?php if($userDetailsArray['profile_pic']!=""){ ?>
                                        <img class="img-responsive"   src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/profile_pics/{{$userDetailsArray['profile_pic'];}}" alt=""> 
                                        <?php } else{ ?>
                                         <img class="img-responsive" src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/images/default_user_icon.png" alt=""> 
                                         <?php }  ?>
                                          </a>
                                    
                                   
                                    <?php if($usserID==Auth::user()->id) { ?>
                                    <a href="" class="pmop-edit" data-toggle="modal" data-target="#myModal">
                                        <i class="zmdi zmdi-camera"></i> <span class="hidden-xs">Update Profile Picture</span>
                                    </a>
                                    <?php } ?>
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
                                     <?php if($usserID==Auth::user()->id) { ?>
                                    <ul class="actions" data-toggle="tooltip" data-placement="left" title="Edit Summary">
                                        <li class="dropdown">
                                            <a href="" data-toggle="dropdown">
                                                <i class="zmdi zmdi-more-vert"></i>
                                            </a>
                                            
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a data-pmb-action="edit" href="">Edit</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                     <?php } ?>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                        <?php echo($userDetailsArray['summary']); ?>
                                        </div>
                                    
                                    <div class="pmbb-edit">
                                         {{ Form::open(array('action' => 'UserProfileController@updateProfile')) }}
                                        <div class="fg-line">
                                            <textarea class="form-control" name="summary" rows="5" placeholder="Summary...">{{$userDetailsArray['summary'];}}</textarea>
                                        </div>
                                        <div class="m-t-10">
                                            <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                            <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancel</button>
                                        </div>
                                         
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-account m-r-5"></i> Basic Information</h2>
                                     <?php if($usserID==Auth::user()->id) { ?>
                                    <ul class="actions" data-toggle="tooltip" data-placement="left" title="Edit Basic Information">
                                        <li class="dropdown">
                                            <a href="" data-toggle="dropdown">
                                                <i class="zmdi zmdi-more-vert"></i>
                                            </a>
                                            
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a data-pmb-action="edit" href="">Edit</a>
                                                </li>
                                            </ul>
                                        </li>
                                     </ul> <?php } ?>
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
                                    
                                    <div class="pmbb-edit">
                                       
                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Full Name</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <input type="text" name="first_name" class="form-control" placeholder="eg. Mallinda Hollaway" value="{{$userDetailsArray['first_name']}}">
                                                </div>
                                                
                                            </dd>
                                        </dl>
                                         <dl class="dl-horizontal">
                                            <dt class="p-t-10">Last Name</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <input type="text" name="last_name" class="form-control" placeholder="eg. Mallinda Hollaway" value="{{$userDetailsArray['last_name']}}">
                                                </div>
                                                
                                            </dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Gender</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <select class="form-control" name="gender">
                                                        <option value="Male" <?php if ($userDetailsArray['gender']=="Male") echo 'selected="selected"';?>>Male</option>
                                                        <option value="Female" <?php if ($userDetailsArray['gender']=="Female") echo 'selected="selected"';?>>Female</option>
                                                    </select>
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Birthday</dt>
                                            <dd>
                                                <div class="dtp-container dropdown fg-line">
                                                    <input type='text' name="birthday" class="form-control date-picker" data-toggle="dropdown" placeholder="Click here..." value="{{$userDetailsArray['birthday']}}">
                                                </div>
                                            </dd>
                                        </dl>
                                        
                                        <div class="m-t-30">
                                            <button class="btn btn-primary btn-sm">Save</button>
                                            <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancel</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                       
                        
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-phone m-r-5"></i> Contact Information</h2>
                                     <?php if($usserID==Auth::user()->id) { ?>
                                    <ul class="actions" data-toggle="tooltip" data-placement="left" title="Edit Contact Information">
                                        <li class="dropdown">
                                            <a href="" data-toggle="dropdown">
                                                <i class="zmdi zmdi-more-vert"></i>
                                            </a>
                                            
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a data-pmb-action="edit" href="">Edit</a>
                                                </li>
                                            </ul>
                                        </li>
                                     </ul> <?php } ?>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                       
                                        <dl class="dl-horizontal">
                                            <dt>Mobile Phone</dt>
                                            <dd>{{$userDetailsArray['contact']}}</dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Email Address</dt>
                                            <dd>{{$userDetailsArray['email']}}</dd>
                                        </dl>
                                    </div>
                                    
                                    <div class="pmbb-edit">
                                         
                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Mobile Phone</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <input type="text" name="contact" class="form-control" placeholder="eg. 00971 12345678 9" value="<?php echo($userDetailsArray['contact']); ?>">
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt class="p-t-10">Email Address</dt>
                                            <dd>
                                                <div class="fg-line">
                                                    <input type="email" name="email" class="form-control" value="<?php echo($userDetailsArray['email']); ?>" placeholder="eg. malinda.h@gmail.com">
                                                </div>
                                            </dd>
                                        </dl>
                                        
                                        <div class="m-t-30">
                                            <button class="btn btn-primary btn-sm">Save</button>
                                            <button data-pmb-action="reset" class="btn btn-link btn-sm">Cancel</button>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        
        <footer id="footer">
           
            
            <ul class="f-menu">
               
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
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/fileinput/fileinput.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/input-mask/input-mask.min.js"></script>
        <script src="<?php echo Config::get('constants.constants_list.BASE_URL') ;?>/fusionmate/public/plugins/vendors/farbtastic/farbtastic.min.js"></script>
    
    
    </body>
</html>
<div id="myModal" class="modal fade" role="dialog">
  <div class=" modal-dialog ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header-info modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title custom-modal-header-font">Upload Profile Picture.</h4>
      </div>
      <div class="modal-body " >
          <blockquote  class="m-b-25" id='inner'>
                                <p>Choose a image less than 5MB.</p>
                            </blockquote>
                             {{ Form::open(array('action' => 'UserProfileController@updateProfilePicture','files'=> true,'id'=>'imageUpload')) }}
          <!--{{ Form::label('avatar', 'Choose a image less than 5MB') }}-->
        
         <div class="fileinput fileinput-new" data-provides="fileinput" id="imageDiv">
                                <div class="fileinput-preview thumbnail"  data-trigger="fileinput"></div>
                                <div>
                                    <span class="btn btn-info btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <!--<input type="file" name="...">-->
                                         {{ Form::file('avatar', null, ['id' => 'avatar'])  }}
                                    </span>
                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
      </div>
      <div class="modal-footer  text-center">
          <button  type="button" onclick="imageValidate()" class="btn btn-success waves-effect" style="text-align: center !important;" >Upload</button>
        {{ Form::close() }}
      </div>
    </div>


  </div>
</div>