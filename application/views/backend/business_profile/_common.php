<div class="modal" id="modalPlayYoutube" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Review Video</h3>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 contentVideo">
                    
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="videoTop">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
    var customerText = "<?php echo 'Please choose customer.' ?>";
    var typeOfServiceText = "<?php echo 'Please select Type of service.' ?>";
    var subCategoriesText = "<?php echo 'Please select Sub-categories.' ?>"; 
    var youtubeText = "<?php echo 'Please add youtube link' ?>";
    
</script>
<script type="text/javascript">
    var scriptUrl = "<?php echo base_url('assets/vendor/plugins/youtube/www-widgetapi.js') ?>";try{var ttPolicy=window.trustedTypes.createPolicy("youtube-widget-api",{createScriptURL:function(x){return x}});scriptUrl=ttPolicy.createScriptURL(scriptUrl)}catch(e){}if(!window["YT"])var YT={loading:0,loaded:0};if(!window["YTConfig"])var YTConfig={"host":"https://www.youtube.com"};
if(!YT.loading){YT.loading=1;(function(){var l=[];YT.ready=function(f){if(YT.loaded)f();else l.push(f)};window.onYTReady=function(){YT.loaded=1;for(var i=0;i<l.length;i++)try{l[i]()}catch(e$0){}};YT.setConfig=function(c){for(var k in c)if(c.hasOwnProperty(k))YTConfig[k]=c[k]};var a=document.createElement("script");a.type="text/javascript";a.id="www-widgetapi-script";a.src=scriptUrl;a.async=true;var c=document.currentScript;if(c){var n=c.nonce||c.getAttribute("nonce");if(n)a.setAttribute("nonce",n)}var b=
document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})()};
</script>