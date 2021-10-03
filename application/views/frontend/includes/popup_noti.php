<!-- Toast -->
<div class="toast-container position-fixed">
  <!-- Remove class show below to hidden toast -->
  <div class="toast um-toast notiPopup" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header border-bottom-0">
      <button type="button" class="btn-close ms-auto btn-toast-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <p class="text-center text-secondary">Your information has been succesfully saved.</p>
      <img src="assets/img/frontend/ic-check-mask.png" alt="ic-check-mask" class="mx-auto img-fluid ico-noti-success ico-hidden"  >
      <img src="assets/img/frontend/ic-cancel.png" alt="ic-check-mask" class="mx-auto img-fluid ico-noti-error ico-hidden" >
    </div>
  </div>
</div>
<!-- End toast -->
<?php
$notiMessage = $this->session->flashdata('notice_message');
$notiType = $this->session->flashdata('notice_type');
if (!empty($notiMessage) && !empty($notiType)) {
?>
  <!-- Toast PHP noti -->
  <div class="toast-container position-fixed" id="popupNotification">
    <!-- Remove class show below to hidden toast -->
    <div class="toast um-toast show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header border-bottom-0">
        <button type="button" class="btn-close ms-auto btn-toast-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <p class="text-center text-secondary"><?php echo $notiMessage; ?></p>
        <?php if ($notiType == 'success') { ?>
          <img src="assets/img/frontend/ic-check-mask.png" alt="Success Notification" class="d-block mx-auto img-fluid">
        <?php } ?>
        <?php if ($notiType == 'error') { ?>
          <img src="assets/img/frontend/ic-cancel.png" alt="Error notification" class="d-block mx-auto img-fluid">
        <?php } ?>
      </div>
    </div>
  </div>
  <script>
    setTimeout(function() {
      $('#popupNotification').fadeOut('fast');
    }, 2000);
  </script>
  <!-- End toast -->
<?php } ?>