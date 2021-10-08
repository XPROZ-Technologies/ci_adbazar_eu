<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-profile page-bp-reservation">
    <div class="bp-reservation-book">
      <div class="container">
        <div class="book-content">
          <h3 class="text-center page-title-md">Book a reservation at Inpire Beauty Salon</h3>
          <div class="d-flex justify-content-center">
            <form class="row">
              <div class="col-lg-12">
                <div class="form-group mb-3">
                  <label for="bookName" class="form-label">Your name<span class="required text-danger">*</span></label>
                  <input type="text" class="form-control" id="bookName" required>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-3 form-group-quantity">
                  <label class="d-block form-label" for="quantityInput">Number of people</label>
                  <div class="d-flex">
                    <button type="button" class="minus">
                      <img src="assets/img/frontend/ic-minus.png" alt="icon minus">
                    </button>
                    <input type="number" class="form-control quantity" id="quantityInput" value="1" min="1" />
                    <button type="button" class="plus">
                      <img src="assets/img/frontend/ic-plus.png" alt="icon plus">
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3">
                  <label class="form-label">Contry code</label>
                  <div class="dropdown dropdown-country page-text-lg">
                    <input type="text" class="form-control" id="" required>
                    <a href="#" class="wrapper-btn dropdown-toggle current js-country" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                      <img src="assets/img/frontend/ger.png" alt="english flag" class="img-fluid me-2">
                      <span class="country-text">Germany</span>
                      <span class="country-code">+49</span>
                    </a>
                    <ul class="dropdown-menu js-list-country" aria-labelledby="countryDropdown">
                      <li class="selected"><a class="dropdown-item" href="#"><img src="assets/img/frontend/ger.png" alt="germany flag" class="img-fluid me-2">
                          <span class="country-text">Germany</span>
                          <span class="country-code">+49</span>
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#">
                          <img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid me-2">
                          <span class="country-text">English</span>
                          <span class="country-code">+11</span>
                        </a>
                      </li>
                      <li><a class="dropdown-item" href="#"><img src=".assets/img/frontend/vn.png" alt="vietnam flag" class="img-fluid me-2">
                          <span class="country-text">Vietnam</span>
                          <span class="country-code">+84</span>
                        </a></li>

                      <li><a class="dropdown-item" href="#">
                          <img src="assets/img/frontend/cre.png" alt="czech flag" class="img-fluid me-2">
                          <span class="country-text">Czech</span>
                          <span class="country-code">+69</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3">
                  <label for="bookPhone" class="form-label">Phone number</label>
                  <input type="tel" class="form-control" id="bookPhone">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3 form-group-datepicker">
                  <label for="datetimepicker1" class="form-label">Select a date</label>
                  <div class="datepicker-wraper position-relative">
                    <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                    <input type="text" class="js-datepicker form-control datetimepicker-input" id="datetimepicker1" data-toggle="datetimepicker" data-target="#datetimepicker1" />
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3 form-group-timepicker">
                  <label for="timepicker1" class="form-label">Select a time</label>
                  <select  class="form-control">
                    <option value="0">--Select a time--</option>
                    <option value="1">Dog</option>
                    <option value="2">Cat</option>
                    <option value="hamster">Hamster</option>
                    <option value="parrot">Parrot</option>
                    <option value="spider">Spider</option>
                    <option value="goldfish">Goldfish</option>
                </select>
                </div>
              </div>
              <div class="d-flex justify-content-center book-btn">
                <button type="submit" class="btn btn-red btn-confirm">Confirm</button>
                <button type="button" class="btn btn-outline-red btn-cancel">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>