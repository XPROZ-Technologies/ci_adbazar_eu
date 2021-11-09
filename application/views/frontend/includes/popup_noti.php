<!-- Toast -->
<div class="toast-container position-fixed" id="notiMessage">
  <!-- Remove class show below to hidden toast -->
  <div class="toast um-toast notiPopup" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="2000">
    <div class="toast-header border-bottom-0">
      <button type="button" class="btn-close ms-auto btn-toast-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <p class="text-center text-secondary"><?php echo $this->lang->line('your_information_has_been_succ'); ?></p>
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
  <script>
    $(".notiPopup .text-secondary").html('<?php echo $notiMessage; ?>');
    $(".ico-noti-<?php echo $notiType; ?>").removeClass('ico-hidden');
    $(".notiPopup").fadeIn('slow').fadeOut(5000);
  </script>
  <!-- End toast -->
<?php } ?>