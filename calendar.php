<?php 
include 'header.html'; 
include_once 'config/functions_users.php';
include_once 'config/functions_misc.php';

if($user->data['is_registered']) {
	echo '<meta http-equiv="refresh" content="0; url=/profile.php?p=rsvp">';
	die();
}

$userID = getUserID($user->data['username_clean']);

?>
<div class="container">
    <div class="four columns">
        <p>This is the menu</p>
    </div>
	<div class="twelve columns">

           <link rel='stylesheet' type='text/css' href='js/jquery/fullcalendar/fullcalendar.css' />
           <link rel='stylesheet' type='text/css' href='js/jquery/fullcalendar/fullcalendar.print.css' media='print' />
           <script type='text/javascript' src='js/jquery/jquery-1.8.1.min.js'></script>
           <script type='text/javascript' src='js/jquery/jquery-ui-1.8.23.custom.min.js'></script>
           <script type='text/javascript' src='js/jquery/fullcalendar/fullcalendar.min.js'></script>
           <script type='text/javascript'>

                   $(document).ready(function() {

                           $('#calendar').fullCalendar({

                                   editable: false,

                                   events: "config/calendar_config.php",
                                   eventColor: "grey",

                                   loading: function(bool) {
                                           if (bool) $('#loading').show();
                                           else $('#loading').hide();
                                   },
                                   
                                   eventClick: function(calEvent, jsEvent, view) {

                                        $( "#dialog-" + calEvent.id).dialog( "open" );

                                    }
                           });

                   });

           </script>
           <style type='text/css'>
                   #loading {
                           position: absolute;
                           top: 5px;
                           right: 5px;
                           }

                   #calendar {
                           width: 100%;
                           margin: 0 auto;
                           text-align: center;
                           font-size: 14px;
                           font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                           }

           </style>

           <div id='loading' style='display:none'>loading...</div>
           <div id='calendar'></div>
           
           <? 
           $events = getrsvpeventslist();
           $count=0;
           while($count < count($events)) {
               $rsvpcount = getRSVPcount($events[$count]["id"]);
               $date = date_create($events[$count]["date"]);
					
                if($rsvpcount > $events[$count]["max"]) {
                        $rsvpcount = $events[$count]["max"];
                }
           ?>
                <script>
                        $(function() {
                                $( "#progressbar<? echo $events[$count]["id"] ?>" ).progressbar({
                                        value: <? echo $rsvpcount; ?>,
                                        max: <? echo $events[$count]["max"]; ?>
                                });
                        });
                        
                        $(function() {
                            $( "#dialog-<? echo $events[$count]["id"]; ?>" ).dialog({
                              autoOpen: false,
                              resizable: false,
                              width: 500,
                              modal: true,
                              buttons: {
                                Cancel: function() {
                                  $( this ).dialog( "close" );
                                }
                              }
                            });
                         });
                </script>
                
                    <div id="dialog-<? echo $events[$count]["id"]; ?>" title="<? echo $events[$count]["name"]; ?> (<? echo date_format($date, 'l jS F Y \a\t g:ia'); ?>)">
                        <ul class="tabs-nav">
                                <li class="active"><a href="#tab1">Location</a></li>
                                <li><a href="#tab2">Description</a></li>
                        </ul>

                        <div class="tabs-container">
                            <div class="tab-content" id="tab1">
                                <b>Event Location: </b><br/><? echo $events[$count]["location"]; ?>
                            </div>

                                <div class="tab-content" id="tab2">
                                <b>Event Description: </b><br />
                                <? echo $events[$count]["description"]; ?>
                                </div>
                        </div>
                        
                        <div style="float: left; width: 150px;">
                            RSVP Total: <? echo $rsvpcount; ?>/<? echo $events[$count]["max"]; ?>
                            <div id="progressbar<? echo $events[$count]["id"]; ?>" style="height: 15px; width: 100%"></div>
                        </div>
                        
                    </div>

                </div>
<?
    $count++;
           } ?>
                  
	</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>