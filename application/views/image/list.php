<?php $this->load->view('backend/includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="content">
            <div class="box box-default">
                <div class="card" style="max-height: 500px;">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                        <div id="upload-demo"></div>
                        </div>
                        <div class="col-md-4" style="padding:5%;">
                        <strong>Select image to crop:</strong>
                        <input type="file" id="image">
                        <button class="btn btn-success btn-block btn-upload-image" style="margin-top:2%">Upload Image</button>
                        </div>
                        <div class="col-md-4">
                        <div id="preview-crop-image" style="background:#9d9d9d;width:300px;padding:50px 50px;height:300px;"></div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/dropImage'); ?>">
<?php $this->load->view('backend/includes/footer'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
<script type="text/javascript">
var resize = $('#upload-demo').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: { // Default { width: 100, height: 100, type: 'square' } 
        width: 200,
        height: 200,
        type: 'square' //square
    },
    boundary: {
        width: 300,
        height: 300
    }
});
$('#image').on('change', function () { 
  var reader = new FileReader();
    reader.onload = function (e) {
      resize.croppie('bind',{
        url: e.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
});
$('.btn-upload-image').on('click', function (ev) {
  resize.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (img) {
    $.ajax({
      url: $("input#uploadFileUrl").val(),
      type: "POST",
      data: {"image":img},
      success: function (data) {
        html = '<img src="' + img + '" />';
        $("#preview-crop-image").html(html);
      }
    });
  });
});
</script>