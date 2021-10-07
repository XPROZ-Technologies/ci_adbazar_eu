<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <?php $this->load->view('frontend/includes/bm_header'); ?>


        <div class="row">
          <div class="col-lg-3">
            <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="bp-reservation bm-reservation">
              <div class="bp-reservation-inner um-reservation-inner">
                <!-- Modal Config -->
                <div class="modal fade bm-modal-config" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-body">
                        <form action="#">
                          <h3 class="text-center page-title-sm text-config">Setting up reservation
                          </h3>

                          <div class="weekdays-selector">
                            <input type="checkbox" id="weekday-mon" class="weekday" />
                            <label for="weekday-mon">Mon</label>
                            <input type="checkbox" id="weekday-tue" class="weekday" />
                            <label for="weekday-tue">Tue</label>
                            <input type="checkbox" id="weekday-wed" class="weekday" />
                            <label for="weekday-wed">Wed</label>
                            <input type="checkbox" id="weekday-thu" class="weekday" />
                            <label for="weekday-thu">Thu</label>
                            <input type="checkbox" id="weekday-fri" class="weekday" />
                            <label for="weekday-fri">Fri</label>
                            <input type="checkbox" id="weekday-sat" class="weekday" />
                            <label for="weekday-sat">Sat</label>
                            <input type="checkbox" id="weekday-sun" class="weekday" />
                            <label for="weekday-sun">Sun</label>
                          </div>

                          <div class="wrapper-config">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
                              <label for="config-max-people-per-time" class="page-text-lg fw-500">Max number of people to
                                be served at a time</label>
                              <div class="wrapper-input">
                                <input type="number" id="config-max-people-per-time" class="form-control square-input">
                              </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
                              <label for="config-max-people-per-reservation" class="page-text-lg fw-500">Max number of people per
                                reservation</label>
                              <div class="wrapper-input">
                                <input type="number" id="config-max-people-per-reservation" class="form-control  square-input">
                              </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
                              <label for="config-time-between-reservation" class="page-text-lg fw-500">Time between
                                reservations</label>
                              <div class="d-flex align-items-center wrapper-input">
                                <input type="text" id="config-time-between-reservation" class="form-control  square-input">
                                <span class="page-text-lg fw-500 ms-2">Minute(s)</span>
                              </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
                              <label for="config-time-start" class="page-text-lg fw-500">Start taking reservation
                                at</label>
                              <div class="timepicker-wraper wrapper-input time-content">
                                <input type="text" class="js-time-picker form-control datetimepicker-input" id="config-time-start" data-toggle="datetimepicker" />
                              </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
                              <label for="config-time-close" class="page-text-lg fw-500">Closing time</label>
                              <div class="timepicker-wraper wrapper-input time-content">
                                <input type="text" class="js-time-picker form-control datetimepicker-input" id="config-time-close" data-toggle="datetimepicker" />
                              </div>
                            </div>
                          </div>

                          <div class="d-flex justify-content-center form-check apply-everyday">
                            <input class="form-check-input" type="checkbox" id="config-everyday">
                            <label class="form-check-label" for="config-everyday">
                              Apply to everyday
                            </label>
                          </div>

                          <!-- Remove this line when valid content -->
                          <p class="page-text-lg text-danger text-center fw-500">IMPORTANT: You need to fill in all information to save changes.</p>

                          <!-- Remove disabled when validate content -->
                          <div class="modal-footer justify-content-center border-0 p-0">
                            <button type="button" class="btn btn-red btn-red">Save
                              changes</button>
                            <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal">Cancel</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Config  -->
                <div class="d-flex justify-content-between reservation-config">
                  <div class="d-flex align-items-center switch-btn">
                    <input id="reservation-config" type="checkbox" class="checkbox" checked>
                    <label for="reservation-config" class="switch">
                      <span class="switch-circle">
                        <span class="switch-circle-inner"></span>
                      </span>
                      <span class="switch-left">Off</span>
                      <span class="switch-right">On</span>
                    </label>
                    <p class="mb-0 switch-text fw-bold">Receive reservation(s)</p>
                  </div>
                  <button class="btn btn-red mr-24" type="button" data-bs-toggle="modal" data-bs-target="#configModal"><img src="assets/img/frontend/ic-setting.png" alt="reservation-config"> Reservation Setting</button>
                </div>


                <div class="w-275">
                  <div class="reservation-select-date">
                    <div class="form-group form-group-datepicker">
                      <label for="reservation-date" class="form-label">Select a date</label>
                      <div class="datepicker-wraper position-relative">
                        <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                        <input type="text" class="js-datepicker form-control datetimepicker-input" id="reservation-date" data-toggle="datetimepicker" value="October 13, 2021" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bg-f5">
                  <form class="d-flex search-box">
                    <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                    <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                  </form>
                  <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                    <div class="d-flex align-items-center inner-filter">
                      <span class="me-2 page-text-lg fw-bold">Filter by</span>
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
                          <option value="0" selected>Newest</option>
                          <option value="1">Oldest</option>
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
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>21/10/2021<br>10:00</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-approved">Approved</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-declined">Declined</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-expire">Expired</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled="">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-approved">Approved</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-approved">Approved</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-approved">Approved</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-declined">Declined</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-expire">Expired</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled="">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-approved">Approved</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>21/10/2021</td>
                          <td>ABCD123</td>
                          <td>1</td>
                          <td><span class="badge badge-approved">Approved</span></td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                    <div class="d-flex align-items-center pagination-left">
                      <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500">1 – 10</span> of <span class="fw-500">50</span>
                        results</p>
                      <div class="page-text-sm mb-0 d-flex align-items-center">
                        <span class="fw-500">50</span>
                        <span class="ms-2">/</span>
                        <div class="custom-select" style="display: none;">
                          <select>
                            <option value="0" selected="">10</option>
                            <option value="1">20</option>
                            <option value="2">30</option>
                            <option value="3">40</option>
                            <option value="4">50</option>
                          </select>
                        </div>
                        <div class="nice-select custom-select" tabindex="0"><span class="current">10</span>
                          <ul class="list">
                            <li data-value="0" class="option selected">10</li>
                            <li data-value="1" class="option">20</li>
                            <li data-value="2" class="option">30</li>
                            <li data-value="3" class="option">40</li>
                            <li data-value="4" class="option">50</li>
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
</main>
<?php $this->load->view('frontend/includes/footer'); ?>