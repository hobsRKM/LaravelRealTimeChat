<!DOCTYPE html>
<?php 
$userId=Auth::user()->id;
$userFirstName=Auth::user()->first_name;
$userLastName=Auth::user()->last_name;
$userConferenceId=$userId."_".$userFirstName;
$userName=$userFirstName." ".$userLastName;
?>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
       <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fusion Mate</title> 
        <!-- CSS -->
        <link href="fusionmate/public/plugins/css/app.min.1.css" rel="stylesheet">
        <link href="fusionmate/public/plugins/css/app.min.2.css" rel="stylesheet">
   
    <script src="fusionmate/public/plugins/js/video-view.js"></script>
    <style>
        .videoHeader{
             background-color: #00bcd4 !important;
             width:500px;
        }
        .videoBody{
             width:500px;
             padding:0px !important;
        }
        .videoScreen{
             width:500px;
            margin-top: -63px;
        }
    </style>
    <script type="text/javascript">
        var avchatObj = null;
        var conferenceId = "<?php echo $userConferenceId;?>";
        var appToken = "MDAxMDAxAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADqS3WR32d9YjH1zR2iFiUf2WpR1yqL%2F02yO%2Fv%2BfpoBTd1a%2FAivQmzVIjEiN9UYZL3Uj7Fia68QD8hssug19afJiGBtTXkmCFQcOUKSHREX3Kopmp%2BQSM4zlmMpWMJ6EX8%3D";
        var sessionToken = getQSParam("t");
        var participantId = getQSParam("pid");

        if (!sessionToken) {
            //login to get session token
            participantId = "participant uniqe id";
            //for example (get random id)
            participantId = Math.floor(Math.random() * 9999999999) + 1000000000;

            var redirectUrl = "url to send response with the session token"
            redirectUrl = location.href + "?pid=" + participantId;
            ooVooClient.authorization({
                token: appToken,
                isSandbox: true,
                userId: participantId,
                callbackUrl: redirectUrl
            });
        }
        else {
            ooVooClient.connect({
                userId: participantId,
                userToken: sessionToken
            }, onClientConnected);
        }

        function onClientConnected(res) {
            //init conference
            avchatObj = ooVooClient.AVChat.init({
                video: true,
                audio: true,
                videoResolution: ooVooClient.VideoResolution["HIGH"],
                videoFrameRate: new Array(5, 15)
            }, onAVChatInit);
        }

        function onAVChatInit(res) {
            if (!res.error) {
                //register to conference events
                avchatObj.onParticipantJoined = onParticipantJoined;
                avchatObj.onParticipantLeft = onParticipantLeft;
                avchatObj.onConferenceStateChanged = onConferenceStateChanged;
                avchatObj.onRemoteVideoStateChanged = onRemoteVideoStateChanged
                avchatObj.join(conferenceId, participantId, "participant name", function (result) { });
            }
        }

        function onParticipantLeft(evt) {
            if (evt.uid) {
                document.getElementById("vid_" + evt.uid).remove();
            }
        }
        function onParticipantJoined(evt) {
            if (evt.stream && evt.uid != null) {
                if (evt.uid == participantId) { //me
                    document.getElementById("localVideo").src = URL.createObjectURL(evt.stream);
                }
                else { //participants
                    var videoElement = document.createElement("video"); 
                    videoElement.id = "vid_" + evt.uid;
                    videoElement.src = URL.createObjectURL(evt.stream);
                    videoElement.setAttribute("autoplay", true);
                    $('#videoBody').appendChild(videoElement);
                }
            }
        }
        function onConferenceStateChanged(evt) {
        }
        function onRemoteVideoStateChanged(evt) {
        }

        function getQSParam(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : results[1].replace(/\+/g, " ");
        }
    </script>
</head>
    
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
                     <div class="row">
                        <div class="col-sm-6" id="videoBody">
                            <div class="card videoBody">
                                <div class="card-header videoHeader">
                                    <h2 style="color:white;"><?php echo $userName; ?></h2>

                                </div>

                                <div class="card-body card-padding videoBody">
                                    <video id="localVideo" class="videoScreen" autoplay muted></video>
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
<!--        <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

                <p>Please wait...</p>
            </div>
        </div>-->

     
      
    
    </body>
</html>
