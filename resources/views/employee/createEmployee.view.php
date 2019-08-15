<?php require_once(COMMON_VIEWS . 'header.php'); ?>
<body>
    <style>
        .custom-checkbox {
            padding-top: 3px;
            padding-bottom: 3px;
        }
        .form-section-heading {
            background-color: #529fff26;
            padding-bottom: 3px;
            padding-top: 3px;
            margin-left: -15px;
            margin-right: -15px;
            margin-bottom: 15px;
            box-shadow: 1px 2px 2px #eeeeee;
        }
        h5 {
            margin-left: 15px;
            margin-bottom: 0px;
        }
    </style>
    <div class="wrapper">

        <!-- sidebar start -->
        <?php 
            $moduleName = 'Employee';
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="employee"></span>
        <!-- sidebar end -->

        <div id="content-wrapper">

            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->

            <div id="content">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-7 mx-auto">
                    <div class="card">
                      <div class="card-header">
                        <div class="row no-gutters">
                            <div class="col-md-auto mr-auto">
                                <h4 class="card-title">New Employee Details</h4>
                            </div>
                            <div class="col-md-auto">

                            </div>
                        </div>

                      </div>
                      <div class="card-body">
                        
                        <!-- START FORM -->
                        <form>
                            <div class="form-section-heading">
                                <h5>Personal</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee_first_name">First Name</label> 
                                    <input id="employee_first_name" name="employee_first_name" type="text" required="required" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employee_last_name">Last Name</label> 
                                    <input id="employee_last_name" name="employee_last_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee_nic">NIC</label> 
                                    <input id="employee_nic" name="employee_nic" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee_telephone">Telephone</label> 
                                    <input id="employee_telephone" name="employee_telephone" type="tel" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employee_email">Email</label> 
                                    <input id="employee_email" name="employee_email" type="email" class="form-control">
                                </div>
                            </div>
                            <div class="form-section-heading">
                                <h5>Role</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee_date_joined">Date Joined</label> 
                                    <input id="employee_date_joined" name="employee_date_joined" type="date" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="employee_role">Employee Role</label> 
                                    <div>
                                        <select id="employee_role" name="employee_role" class="custom-select">
                                            <option value="104">Service Crew</option>
                                            <option value="105">Service Supervisor</option>
                                            <option value="106">Sales Assistant</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-auto">
                                    <label>Performing Service Types</label> 
                                    
                                    <div>
                                        <div class="custom-control custom-checkbox">
                                            <input name="employee_service_types" id="employee_service_types_0" type="checkbox" class="custom-control-input" value="st1"> 
                                            <label for="employee_service_types_0" class="custom-control-label">Tyre Inspection and Replacement</label>
                                        </div>
                                        
                                        <div class="custom-control custom-checkbox">
                                            <input name="employee_service_types" id="employee_service_types_1" type="checkbox" class="custom-control-input" value="st2"> 
                                            <label for="employee_service_types_1" class="custom-control-label">Wheel Alignment Inspection and Repair</label>
                                        </div>
                                        
                                        <div class="custom-control custom-checkbox">
                                            <input name="employee_service_types" id="employee_service_types_2" type="checkbox" class="custom-control-input" value="st3"> 
                                            <label for="employee_service_types_2" class="custom-control-label">Battery Inspection and Replacement</label>
                                        </div>
                                    </div>
                                
                                </div> 
                            </div>
                            <div class="form-group">
                                <button name="reset" type="reset" class="btn btn-danger">Reset</button>
                                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <!-- END FORM -->
                    
                      </div>
                      <!-- card-body end -->
                    </div>
                  </div>
                  <!-- end col-md-12 -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
            </div>
            <!-- end content -->
            
        </div>
        <!-- end content-wrapper -->

    </div>
    <!-- end wrapper -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
    </script>
</body>
</html>
