<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-customer-event">
    <div class="customer-event">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 mb-4 mb-lg-0 pe-lg-4">
            <div class="customer-event-left">
              <h2 class="page-heading page-title-md fw-bold"><?php echo $this->lang->line('events'); ?></h2>
              <div id='calendar'></div>
            </div>
          </div>
          <div class="col-xl-8">
            <div class="customer-event-content">
              <div class="text-white text-center customer-event-top">
                <h4 class="card-title mb-0 page-title-md fw-bold"><?php echo $this->lang->line('upcoming_events'); ?></h4>
              </div>
              <div class="wrapper-search">
                <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                  <?php if (isset($selected_date)) { ?>
                    <input type="hidden" name="selected_date" value="<?php echo $selected_date; ?>" />
                  <?php } ?>
                  <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                  <input class="form-control" type="text" placeholder="Search" name="keyword" aria-label="Search" value="<?php echo $keyword; ?>">

                </form>
              </div>

              <?php if (!empty($lists) > 0) { ?>
                <!-- data event list -->
                <div class="customer-event-list">
                  <div class="wrapper-list">

                    <?php foreach ($lists as $key => $eventItem) {
                      $eventDetailUrl = base_url('event/' . makeSlug($eventItem['event_subject']) . '-' . $eventItem['id']) . '.html'; ?>
                      <div class="position-relative event-item-<?php echo $eventItem['id']; ?>">
                        <a class="w-100 d-flex flex-column flex-lg-row customer-event-item" href="<?php echo $eventDetailUrl; ?>">
                          <p class="event-img mb-0">
                            <img src="<?php echo $eventItem['event_image']; ?>" alt="<?php echo $eventItem['event_subject']; ?>">
                          </p>
                          <div class="event-text">
                            <p class="event-header page-text-lg fw-500"><?php echo $eventItem['event_subject']; ?></p>
                            <p class="mb-0">By <?php echo $eventItem['business_name']; ?></p>
                            <hr class="my-2 my-lg-3">
                            <p class="event-date page-text-sm"><?php echo ddMMyyyy($eventItem['start_date'], 'M d, Y'); ?> - <?php echo ddMMyyyy($eventItem['end_date'], 'M d, Y'); ?> <span class="dot-black"></span> <?php echo ddMMyyyy($eventItem['start_time'], 'H:i'); ?> - <?php echo ddMMyyyy($eventItem['end_time'], 'H:i'); ?></p>
                          </div>
                        </a>
                        <?php if (!$inPast) { ?>
                          <a href="javascript:void(0)" class="event-join btn btn-outline-red mt-2 mt-lg-0 join-event-in-list" data-id="<?php echo $eventItem['id']; ?>" data-customer="<?php echo $customer['id']; ?>"><?php echo $this->lang->line('join'); ?></a>
                        <?php } ?>
                      </div>
                    <?php } ?>

                    <!-- Pagination -->
                    <?php if (!empty($lists) > 0) { ?>
                      <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                        <div class="d-flex align-items-center pagination-left">
                          <p class="page-text-sm mb-0 me-3"><?php echo $this->lang->line('1310_showing'); ?> <span class="fw-500"><?php echo ($page - 1) * $perPage + 1; ?> – <?php echo ($page - 1) * $perPage + count($lists); ?></span> <?php echo $this->lang->line('1310_of'); ?> <span class="fw-500"><?php echo number_format($rowCount); ?></span>
                            <?php echo $this->lang->line('1310_results'); ?></p>
                          <div class="page-text-sm mb-0 d-flex align-items-center">
                            <div class="custom-select choose-perpage">
                              <select>
                                <option value="10" <?php if (isset($per_page) && $per_page == 20) {
                                                      echo 'selected';
                                                    } ?>>10</option>
                                <option value="20" <?php if (isset($per_page) && $per_page == 20) {
                                                      echo 'selected';
                                                    } ?>>20</option>
                                <option value="30" <?php if (isset($per_page) && $per_page == 30) {
                                                      echo 'selected';
                                                    } ?>>30</option>
                                <option value="40" <?php if (isset($per_page) && $per_page == 40) {
                                                      echo 'selected';
                                                    } ?>>40</option>
                                <option value="50" <?php if (isset($per_page) && $per_page == 50) {
                                                      echo 'selected';
                                                    } ?>>50</option>
                              </select>
                            </div>
                            <span class="ms-2">/</span>
                            <span class=""> <?php echo $this->lang->line('1310_page'); ?></span>
                          </div>
                        </div>
                        <div class="pagination-right">
                          <!-- Page pagination -->
                          <nav>
                            <?php echo $paggingHtml; ?>
                          </nav>
                          <!-- End Page pagination -->
                        </div>
                      </div>
                    <?php } ?>
                    <!-- END. Pagination -->

                  </div>
                </div>
                <!-- END. data event list -->
              <?php } else { ?>
                <div class="zero-event zero-box">
                  <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                  <p class="text-secondary page-text-lg"><?php echo $this->lang->line('no_upcoming_event_on_this_day'); ?></p>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<script>
  if ($('#calendar').length > 0) {
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      /* var selectedDate = GetURLParameter('selected_date'); */
      var selectedDate = '<?php if(isset($selected_date)){ echo $selected_date; }else{ echo date('Y-m-d'); } ?>';
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev',
          center: 'title',
          right: 'next'
        },
        initialDate: selectedDate,
        navLinks: false,
        businessHours: false,
        editable: false,
        selectable: false,
        events: [
          <?php if (!empty($dateRanges) > 0) {
            foreach ($dateRanges as $itemDate) { ?> {
                start: '<?php echo $itemDate; ?>',
                constraint: '',
                color: '#C20000',
              },
          <?php }
          } ?>
        ],
        dateClick: function(info) {
          //get date
          var x = new Date();
          var y = new Date(info.dateStr);
          if(x < y){
            redirect(false, '<?php echo base_url('events.html'); ?>?selected_date=' + info.dateStr);
          }
        }
      });
      calendar.render();
      document.querySelectorAll("[data-date='" + selectedDate + "']")[0].classList.add("mystyle");
    });
  }

  function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('?');
    for (var i = 0; i < sURLVariables.length; i++) {
      var sParameterName = sURLVariables[i].split('=');
      if (sParameterName[0] == sParam) {
        return sParameterName[1];
      }
    }
  }
</script>