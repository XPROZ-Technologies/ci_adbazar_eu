<?php $this->load->view('backend/includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content">
            <div class="box box-default">
                <div class="card" style="max-height: 500px;">
                    <div class="card-body">
                    <div class="row">
                        
                    <div class="panel-body" align="center">
  					 <div id="uploaded"><img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar"></div>
                    <input type="file" name="upload" id="upload" />
                    </div>
                    </div>
                    
                </div>
            </div>
        </section>
    </div>
</div>
<div id="myModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal">&times;</button>
        		<h4 class="modal-title">Crop Image</h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
  					<div class="col-md-8 text-center">
						  <div id="image" style="width:250px; margin-top:20px"></div>
  					</div>
  					<div class="col-md-4" style="padding-top:20px;">
  						<br />
  						<br />
  						<br/>
						  <button class="btn btn-success crop_image">Crop & Upload Image</button>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
    </div>
</div>
<input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/dropImage'); ?>">
<?php $this->load->view('backend/includes/footer'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
<script type="text/javascript">


$(document).ready(function(){

	$image_crop = $('#image').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#myModal').modal('show');
  });



  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:$("input#uploadFileUrl").val(),
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
            $(".avatar").attr('src', response)
          $('#myModal').modal('hide');
        //   $('#uploaded').html(data);
        }
      });
    })
  });

});  
</script>
</script>