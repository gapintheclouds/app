<?php
    global $path, $session;
    $v = 7;
?>
<link href="<?php echo $path; ?>Modules/app/Views/css/config.css?v=<?php echo $v; ?>" rel="stylesheet">
<link href="<?php echo $path; ?>Modules/app/Views/css/dark.css?v=<?php echo $v; ?>" rel="stylesheet">

<script type="text/javascript" src="<?php echo $path; ?>Modules/app/Lib/config.js?v=<?php echo $v; ?>"></script>
<script type="text/javascript" src="<?php echo $path; ?>Modules/app/Lib/feed.js?v=<?php echo $v; ?>"></script>

<div id="app-block" style="display:none">
  <div class="col1"><div class="col1-inner">
  
    <div style="height:20px; border-bottom:1px solid #333; padding-bottom:8px;">
      <div style="float:right;">
        <i class="openconfig icon-wrench icon-white" style="cursor:pointer; padding-right:5px;"></i>
      </div>
    </div>
    <div style="text-align:center">
      <div class="electric-title">POWER NOW</div>
      <div class="power-value"><span id="powernow">0</span></div>
    </div>
  
  </div></div>
</div>    

<div id="app-setup" style="display:none; padding-top:50px" class="block">
    <h2 class="appconfig-title">Template</h2>
    <div class="appconfig-description">
        <div class="appconfig-description-inner">
            A basic app example useful for developing new apps
            
            <img src="<?php echo $path; ?><?php echo $appdir; ?>preview.png" style="width:600px" class="img-rounded">
        </div>
    </div>
    <div class="app-config"></div>
</div>

<div class="ajax-loader"><img src="<?php echo $path; ?>Modules/app/images/ajax-loader.gif"/></div>

<script>

// ----------------------------------------------------------------------
// Globals
// ----------------------------------------------------------------------
var path = "<?php print $path; ?>";
var apikey = "<?php print $apikey; ?>";
var sessionwrite = <?php echo $session['write']; ?>;

apikeystr = ""; 
if (apikey!="") apikeystr = "&apikey="+apikey;

// ----------------------------------------------------------------------
// Display
// ----------------------------------------------------------------------
$("body").css('background-color','#222');
$(window).ready(function(){
    $("#footer").css('background-color','#181818');
    $("#footer").css('color','#999');
});
if (!sessionwrite) $(".openconfig").hide();

// ----------------------------------------------------------------------
// Configuration
// ----------------------------------------------------------------------
config.app = {
    "use":{"type":"feed", "autoname":"use", "engine":"5", "description":"House or building use in watts"}
};
config.name = "<?php echo $name; ?>";
config.db = <?php echo json_encode($config); ?>;
config.feeds = feed.list();

config.initapp = function(){init()};
config.showapp = function(){show()};
config.hideapp = function(){clear()};

// ----------------------------------------------------------------------
// APPLICATION
// ----------------------------------------------------------------------
var feeds = {};

config.init();

function init()
{   

}
    
function show()
{   
    $(".ajax-loader").hide();
    resize();
    updaterinst = setInterval(updater,5000);
}
   
function updater()
{
    var use = config.app.use.value;
    feeds = feed.listbyid();
    $("#powernow").html((feeds[use].value*1).toFixed(1)+"W");
}

function resize() 
{
    updater();
}

function clear()
{
    clearInterval(updaterinst);
}

$(window).resize(function(){
    resize();
});

// ----------------------------------------------------------------------
// App log
// ----------------------------------------------------------------------
function app_log (level, message) {
    if (level=="ERROR") alert(level+": "+message);
    console.log(level+": "+message);
}
</script>
