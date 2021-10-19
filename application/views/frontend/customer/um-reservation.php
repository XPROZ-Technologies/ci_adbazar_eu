<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-user-manager">
    <!-- Customer Tab Header -->
    <?php $this->load->view('frontend/includes/customer_tab_header'); ?>

    <div class="um-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <!-- Customer Menu Sidebar -->
            <?php $this->load->view('frontend/includes/customer_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="um-right">
              <div class="bp-reservation um-reservation">
              <div class="w-275">
                  <div class="reservation-select-date">
                    <div class="form-group form-group-datepicker">
                      <label for="selecteDate" class="form-label"><?php echo $this->lang->line('select_a_date'); ?></label>
                      <div class="datepicker-wraper position-relative">
                        <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                        <input type="text" class="form-control datetimepicker-input" id="selecteDate" data-toggle="datetimepicker" value="" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bp-reservation-inner um-reservation-inner">
                  <div class="bg-f5">
                    <form class="d-flex search-box">
                      <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control w-100" type="text" placeholder="Search" aria-label="Search">
                    </form>

                    <div class="notification-wrapper-filter d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center inner-filter">
                        <span class="me-2 page-text-lg"><?php echo $this->lang->line('filter_by'); ?></span>
                        <div class="notification-filter">
                          <div class="custom-select">
                            <select>
                              <option value="0" selected>All</option>
                              <option value="1">Personal</option>
                              <option value="2">The Rice Bowl</option>
                              <option value="3">Inspire Beauty Salon</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex align-items-center notification-sort">
                        <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
                        <div class="custom-select mb-0">
                          <select>
                            <option value="0" selected><?php echo $this->lang->line('1310_newest'); ?></option>
                            <option value="1"><?php echo $this->lang->line('1310_oldest'); ?></option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="table-responsive reservation-table">
                      <table class="table page-text-lg">
                        <thead>
                          <tr>
                            <th>Time</th>
                            <th>ID</th>
                            <th>People</th>
                            <th><?php echo $this->lang->line('status'); ?></th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-approved"><?php echo $this->lang->line('approved'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-declined"><?php echo $this->lang->line('decline'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-expire"><?php echo $this->lang->line('expired'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-cancel"><?php echo $this->lang->line('cancelled'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-approved"><?php echo $this->lang->line('approved'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-approved"><?php echo $this->lang->line('approved'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-declined"><?php echo $this->lang->line('decline'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-expire"><?php echo $this->lang->line('expired'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-cancel"><?php echo $this->lang->line('cancelled'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-center">21/10/2021 </br>10</td>
                            <td>ADVFD</td>
                            <td>1</td>
                            <td><span class="badge badge-approved"><?php echo $this->lang->line('approved'); ?></span></td>
                            <td>
                              <div class="d-flex justify-content-center">
                                <button type="button" class="btn  btn-outline-red btn-outline-red-md"><?php echo $this->lang->line('cancel'); ?></button>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                      <div class="d-flex align-items-center pagination-left">
                        <p class="page-text-sm mb-0 me-3"><?php echo $this->lang->line('1310_showing'); ?> <span class="fw-500">1 – 10</span> <?php echo $this->lang->line('1310_of'); ?> <span class="fw-500">50</span>
                        <?php echo $this->lang->line('1310_results'); ?></p>
                        <div class="page-text-sm mb-0 d-flex align-items-center">
                          <span class="fw-500 show-page-text">50</span>
                          <span class="ms-2">/</span>
                          <div class="page-select position-relative">
                            <span class="ml-8px"> Page <img class="ml-8px" src="assets/img/frontend/icon-page.png" alt=""></span>
                            <ul>
                              <li class="active">10</li>
                              <li>20</li>
                              <li>30</li>
                              <li>40</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="pagination-right">
                        <!-- Page pagination -->
                        <nav>
                          <ul class="pagination justify-content-end mb-0">
                            <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                            </li>
                          </ul>
                        </nav>
                        <!-- End Page pagination -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
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
  $(document).ready(function() {
    // change date 
    var dateNow = new Date();
    var selectedDate = GetURLParameter('selected_day');
    console.log(selectedDate !== undefined);
    if(selectedDate !== undefined){
      dateNow = selectedDate;
    }
    console.log(dateNow);
    $("#selecteDate").datetimepicker({
      defaultDate: dateNow,

      //minDate: moment(),
      format: "MMMM DD, YYYY",
      allowInputToggle: true,
      // inline: true,
      // debug: true,
      // allowMultidate: true,
      // multidateSeparator: ',',
      icons: {
        time: "bi bi-clock",
        date: "bi bi-calendar2-check-fillr",
        up: "bi bi-chevron-up",
        down: "bi bi-chevron-down",
        previous: "bi bi-chevron-left",
        next: "bi bi-chevron-right",
      },
    });
      $('#selecteDate').on('dp.change', function(e) {
      var formatedValue = e.date.format(e.date._f);
      var formatDay = moment(formatedValue).format('YYYY-MM-DD');
      redirect(false, 'customer/my-reservation?selected_day=' + formatDay);
    });
  });
</script>