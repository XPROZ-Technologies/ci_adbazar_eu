<?php $this->load->view('frontend/includes/header'); ?>
  <main>
    <div class="page-business-profile page-bp-reservation">
      
      <?php $this->load->view('frontend/includes/business_top_header'); ?>

      <div class="bp-tabs">
        <div class="container">
          <div class="row">
            <div class="col-lg-4">
            <?php $this->load->view('frontend/includes/business_nav_sidebar'); ?>
            </div>
            <div class="col-lg-8">
              <div class="bp-tabs-right">
                <div class="bp-reservation">
                  <div class="bp-reservation-inner">
                    <div
                      class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between reservation-top">
                      <h5 class="page-title-xs mb-lg-0">My reservation(s) at Inspire Beauty Salon</h5>
                      <a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/book-reservation'); ?>" class="btn btn-red">Book a reservation</a>
                    </div>
                    <div class="bg-f5">
                      <form class="d-flex search-box">
                          <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                          <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                      </form>
  
                      <div class="table-responsive reservation-table">
                        <table class="table page-text-lg">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Time</th>
                              <th>ID</th>
                              <th>People</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>21/10/2021</td>
                              <td>10:00</td>
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
                              <td>10:00</td>
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
                              <td>10:00</td>
                              <td>ABCD123</td>
                              <td>1</td>
                              <td><span class="badge badge-expire">Expired</span></td>
                              <td>
                                <div class="d-flex justify-content-center">
                                  <button type="button"
                                    class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled"
                                    disabled>Cancel</button>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>21/10/2021</td>
                              <td>10:00</td>
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
                              <td>10:00</td>
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
                              <td>10:00</td>
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
                              <td>10:00</td>
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
                              <td>10:00</td>
                              <td>ABCD123</td>
                              <td>1</td>
                              <td><span class="badge badge-expire">Expired</span></td>
                              <td>
                                <div class="d-flex justify-content-center">
                                  <button type="button"
                                    class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled"
                                    disabled>Cancel</button>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td>21/10/2021</td>
                              <td>10:00</td>
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
                              <td>10:00</td>
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
                                  <div class="custom-select">
                                      <select>
                                          <option value="0" selected>10</option>
                                          <option value="1">20</option>
                                          <option value="2">30</option>
                                          <option value="3">40</option>
                                          <option value="4">50</option>
                                      </select>
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
  <input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
  <?php $this->load->view('frontend/includes/footer'); ?>