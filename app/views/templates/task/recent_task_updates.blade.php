<html>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Task-</title>

        @include('templates/css')
        <style>
            .table th, .table td {
    border: 0px !important;
}
.lvh-search {
    margin-top: 51px !important;
     position: relative !important; 
    top: 0;
    left: 0;
     height: auto !important; 
    width: 100%;
     z-index: 0 !important; 
    background: #fff;
     display: block !important; 
}
            
            
        </style>
    </head>
    <body style='background-color: #fff'>
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
        <div id="searchtask">
          <div class="lvh-search">
                                    <input  type="text"  placeholder="Search for Task ID, Assignee, Tracker, Priority and more..." class="lvhs-input search">
                
                                    <i class="lvh-search-close" onclick="clearSeacrch()">&times;</i>
                                </div>
        
            <div class="list" >
        @foreach($result as $data)
        <div class="card ">
            <div class="card-header">
                  

               
            </div>

            <div class="card-body card-padding">
                
                  <blockquote  class="m-b-25 task-block-quote" >
                      <h2 class="bugId">#{{$data['id']}}</h2>
                    </blockquote>
               
                 <table class="table ">
                                
                                <tbody>
                                    <tr>
                                        
                                        <th class="col-md-1" ><i class="zmdi zmdi-assignment-o zmdi-hc-fw"></i> &nbsp;Tracker</th>
                                        <td class="col-md-2 c-blue f-400 tracker">{{$data['tracker']}}</td>
                                       <th class="col-md-1" ><i class="zmdi zmdi-badge-check zmdi-hc-fw"></i> &nbsp;Status</th>
                                        <td class="col-md-2 c-blue f-400 status">{{$data['status_name']}}</td>
                                        <th class="col-md-1" ><i class="zmdi zmdi-assignment-alert zmdi-hc-fw"></i> &nbsp;Priority</th>
                                        <td class="col-md-2 c-blue f-400 priority">{{$data['priority_name']}}</td>
                                          
                                    </tr>
                                     
                                 
                                </tbody>
                            </table>
                 <table class="table ">
                                
                                <tbody>
                                    <tr>
                                        
                                        <th class="col-md-1" ><i class="zmdi zmdi-format-subject zmdi-hc-fw"></i> &nbsp;Subject</th>
                                        <td class="col-md-8 c-blue f-400 subject">{{$data['tracker_subject']}}</td>
                                      
                                          
                                    </tr>
                                     
                                 
                                </tbody>
                            </table>
                
                 <table class="table ">
                                
                                <tbody>
                                    <tr>
                                        
                                        <th class="col-md-1" ><i class="zmdi zmdi-calendar-check zmdi-hc-fw"></i> &nbsp;Start</th>
                                        <td class="col-md-2 c-blue f-400 start_date">{{$data['start_date']}}</td>
                                         <th class="col-md-1" ><i class="zmdi zmdi-calendar-close zmdi-hc-fw"></i> &nbsp;Due</th>
                                        <td class="col-md-2 c-blue f-400 end_date">{{$data['end_date']}}</td>
                                        <th class="col-md-1" ></th>
                                        <td class="col-md-2 c-blue f-400"></td>
                                      
                                          
                                    </tr>
                                     
                                 
                                </tbody>
                            </table>
                
                 <table class="table ">
                                
                                <tbody>
                                    <tr>
                                        
                                        <th class="col-md-1" ><i class="zmdi zmdi-assignment-account zmdi-hc-fw"></i> &nbsp;Assignee</th>
                                        <td class="col-md-8 c-blue f-400 assignee">{{$data['first_name']." ".$data['last_name']}}</td>
                                        
                                      
                                          
                                    </tr>
                                     
                                 
                                </tbody>
                            </table>
                
                <table class="table ">
                                
                                <tbody>
                                    <tr>
                                        
                                        <th class="col-md-1" ><i class="zmdi zmdi-file-text zmdi-hc-fw"></i> &nbsp;Files</th>
                                        <td class="col-md-8 c-blue f-400 ">
                                            <?php
                                            if(isset($data['file_name'])=='')
                                               echo "No files attached";
                                            else
                                                foreach($data['file_name'] as $files){
                                                    echo "<a href='".Config::get('constants.constants_list.FILE_PATH')."userUploads/".$files."' download>".$files."</a><br/>";
                                                }
                                                   
                                              
                                           
                                            ?>
                                        </td>
                                        
                                      
                                          
                                    </tr>
                                     
                                 
                                </tbody>
                            </table>
                 <table class="table ">
                                
                                <tbody>
                                    <tr>
                                        
                                        <th class="col-md-1" ><i class="zmdi zmdi-comment-text zmdi-hc-fw"></i> &nbsp;Description</th>
                                        <td class="col-md-8 well">
                                            {{$data['description']}}
                                        </td>
                                        
                                      
                                          
                                    </tr>
                                     
                                 
                                </tbody>
                            </table>
            </div>
            
            
            
        </div><hr/>
            
@endforeach
 </div></div>
        @include('templates/scripts')
<script src="http://listjs.com/no-cdn/list.js"></script> 

    </body>
    

</html>

    <script>
        

var options = {
  valueNames: [ 'bugId','status','priority','assignee','tracker','subject','start_date','end_date']
};

var userList = new List('searchtask', options);
function clearSeacrch(){
 $('.search').val('');   
}


</script>