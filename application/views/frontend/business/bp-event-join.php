<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-bp-join">
    <div class="container">
      <div class="bp-join">
        <div class="row justify-content-center">
          <div class="col-lg-9">
            <div class="bp-join-form">
              <h2 class="page-title-md text-center fw-bold"><?php echo $this->lang->line('join_an_event_as_a_guest'); ?> </h2>
              <form id="frmJoinAsGuest" class="row g-3" method="POST" action="<?php echo base_url('submit-join-as-guest') ?>">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
                <div class="col-md-6">
                  <label for="eventFirstName" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="eventFirstName" name="first_name">
                </div>
                <div class="col-md-6">
                  <label for="eventLastName" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="eventLastName" name="last_name">
                </div>
                <!-- has-validation -->
                <div class="col-md-12">
                  <label for="eventEmail" class="form-label">Email<span class="required text-danger">*</span> </label>
                  <!-- is-invalid -->
                  <input type="email" class="form-control" id="eventEmail" name="email">
                  <div class="invalid-feedback">
                    *Please enter a valid email.
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <button type="submit" class="btn btn-red">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Modal Join Success -->
<div class="modal fade" id="joinModal" tabindex="-1" aria-labelledby="joinModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3 class="page-title-xs text-center"><?php echo $this->lang->line('check_your_email'); ?></h3>
        <p class="font16 text-center mb-0"> <?php echo $this->lang->line('we_have_sent_a_confirmation_link_to_your_emai'); ?>
        </p>
        <div class="check-mail mt-3">
          <p class="text-center page-text-md font12"><?php echo $this->lang->line('did_not_receive_the_email_check_your_spam_filter'); ?> </br> or <a href="javascript:void(0)" data-dismiss="modal" aria-label="Close" class="fw-bold mt-0"><?php echo $this->lang->line('try_another_email_address'); ?></a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Join Success -->

<script>
  // $("#joinModal").modal("show");
  <?php if(isset($join_success) && $join_success == true){ ?>
    $("#joinModal").modal("show");
  <?php } ?>

  $("#frmJoinAsGuest").submit(function(event) {
    var email = $('#eventEmail').val();
    var first_name = $('#eventFirstName').val();
    var last_name = $('#eventLastName').val();

    if(email == '' && first_name == '' && last_name == ''){
        $(".notiPopup .text-secondary").html("Please enter your information");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".ico-noti-success").addClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
    }

    if(email == '' || !validateEmail(email)){
        $(".notiPopup .text-secondary").html("Please enter your email");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".ico-noti-success").addClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
    }

    if(first_name == ''){
        $(".notiPopup .text-secondary").html("Please enter your first name");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".ico-noti-success").addClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
    }

    if(last_name == ''){
        $(".notiPopup .text-secondary").html("Please enter your last name");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".ico-noti-success").addClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
    }

    if(validateEmail(email) && email != '' && first_name != '' && last_name != ''){
      return;
    }
   
    event.preventDefault();
  });
</script>