<?php require_once(COMMON_VIEWS . 'header.php'); ?>
<body>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php 
            $moduleName = 'Booking';
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="booking"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
            <div class="container-fluid">
                <!-- Select Service -->
                <div class="row">
                  <div class="col-md-8 mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <div class="row no-gutters">
                            <div class="col-md-auto mr-auto">
                                <h4 class="card-title">New Booking - Select Service</h4>
                            </div>
                            <div class="col-md-auto">

                            </div>
                        </div>

                      </div>
                      <div class="card-body">
                        <form>
                          <div class="form-row">
                              <div class="form-group col-md-auto mx-auto">
                                      <div class="custom-control custom-radio custom-control-inline mb-md-2">
                                          <input name="radio" id="single_service" type="radio" class="custom-control-input" value="0" checked="checked"> 
                                          <label for="radio_0" class="custom-control-label">Single Service</label>
                                      </div>
                                      <div class="custom-control custom-radio custom-control-inline">
                                          <input name="radio" id="multiple_service" type="radio" class="custom-control-input" value="1"> 
                                          <label for="radio_1" class="custom-control-label">Service Package</label>
                                      </div>
                              </div>
                          </div>
                          <div id="single_section">
                              <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for="select" class="">Service Type</label> 
                                    <select id="select" name="select" class="custom-select">
                                        <option value="1">Wheel Alignment Inspection and Repair</option>
                                        <option value="2">Tyre Inspection and Replacement</option>
                                        <option value="3">Transmission Inspection, Repair and Replacement</option>
                                    </select>
                                  </div>
                              </div>
                          </div>
                          <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="select1">Service Package</label> 
                                  <select id="select1" name="select1" class="custom-select">
                                      <option value="sp1">Simple Service</option>
                                      <option value="sp2">Custom Service Package</option>
                                      <option value="sp3">sp2</option>
                                  </select>
                                </div> 
                            </div>
                          <div id="multiple_section">
                              <div class="form-row">
                                  <div class="form-group col-md-auto">
                                      <label>Service Types</label> 
                                      <div>
                                          <div class="custom-control custom-checkbox">
                                              <input name="checkbox" id="checkbox_0" type="checkbox" class="custom-control-input" value="1"> 
                                              <label for="checkbox_0" class="custom-control-label">Wheel Alignment Inspection and Repair</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                              <input name="checkbox" id="checkbox_1" type="checkbox" class="custom-control-input" value="2"> 
                                              <label for="checkbox_1" class="custom-control-label">Tyre Inspection and Replacement</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                              <input name="checkbox" id="checkbox_2" type="checkbox" class="custom-control-input" value="3"> 
                                              <label for="checkbox_2" class="custom-control-label">Transmission Inspection, Repair and Replacement</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-md d-flex justify-content-end">
                                  <button class="btn btn-primary">Next</button>
                              </div>
                          </div>
                      </form>
                      </div>
                      <!-- card-body end -->
                    </div>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->

                <!-- Select Time Slot -->
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                            <div class="row no-gutters">
                                <div class="col-md-auto mr-auto">
                                    <h4 class="card-title">New Booking - Select Time Slot</h4>
                                </div>

                            </div>
                            </div>
                            <!-- end card-header -->
                            <div class="card-body">
                
                            </div>
                            <!-- card-body end -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col-md-12 -->
                </div>
                <!-- end row -->

                <!-- Customer Details -->
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                            <div class="row no-gutters">
                                <div class="col-md-auto mr-auto">
                                    <h4 class="card-title">New Booking - Customer Details</h4>
                                </div>

                            </div>
                            </div>
                            <!-- end card-header -->
                            <div class="card-body">
                                <!-- <div class="row">
                                    <div class="col-md-6 d-flex justify-content-center" style="border-right: 1px solid rgb(0, 0, 0)"><input id="find_name" name="find_name" type="text" class="form-control" style="font-family: 'Font Awesome 5 Free', 'ibm_plex_sansregular'; font-size: 1.3rem; font-weight: 400" placeholder="&#xf2bb; Find Customer"></div>
                                    <div class="col-md-6 d-flex justify-content-center"><button id="create_customer" class="btn-block btn-lg btn-outline-dark"><i class="fas fa-plus-square"></i>Create Customer</button></div>
                                </div> -->
                            <div class="row">
                                <div class="col-md" style="background-color: rgb(192, 192, 248);">
                                    <h5 class="d-flex justify-content-center ">Customer Details</h5>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md d-flex justify-content-between">
                                    <button class="btn btn-primary">Prev</button>
                                    <button class="btn btn-primary">Next</button>
                                </div>
                            </div>
                            </div>
                            </div>
                            <!-- card-body end -->
                        </div>
                        <!-- end card -->
                </div>
                <!-- end row -->

                <!-- Confirm Booking Details -->
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                            <div class="row no-gutters">
                                <div class="col-md-auto mr-auto">
                                    <h4 class="card-title">New Booking - Confirm</h4>
                                </div>

                            </div>
                            </div>
                            <!-- end card-header -->
                            <div class="card-body">
                                <!-- <div class="row">
                                    <div class="col-md-6 d-flex justify-content-center" style="border-right: 1px solid rgb(0, 0, 0)"><input id="find_name" name="find_name" type="text" class="form-control" style="font-family: 'Font Awesome 5 Free', 'ibm_plex_sansregular'; font-size: 1.3rem; font-weight: 400" placeholder="&#xf2bb; Find Customer"></div>
                                    <div class="col-md-6 d-flex justify-content-center"><button id="create_customer" class="btn-block btn-lg btn-outline-dark"><i class="fas fa-plus-square"></i>Create Customer</button></div>
                                </div> -->
                            <div class="row">
                                <div class="col-md" style="background-color: rgb(192, 192, 248);">
                                    <h5 class="d-flex justify-content-center ">Customer Details</h5>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md d-flex justify-content-between">
                                    <button class="btn btn-primary">Prev</button>
                                    <button class="btn btn-primary">Finish</button>
                                </div>
                            </div>
                            </div>
                            <!-- card-body end -->
                            </div>
                            <!-- end card -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
            </div>
            <!-- end content -->
        </div>
        <!-- end content-wrapper -->
    </div>

        <!-- Modal -->
        <div class="modal fade" id="create_customer_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
                <!-- /modal-content -->
            </div>
        </div>
        <!-- End Modal -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
        function showModal() {
            modal.modal({
                show: true,
            });
            modal.on('hide.bs.modal', function (e) {
                console.log('hiding modal');
            });
        }

        let modal = $('#create_customer_modal');
        let customerButton = document.querySelector('#create_customer');
        customerButton.addEventListener('click', showModal);
    </script>
</body>
</html>
