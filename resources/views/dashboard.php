<?php require_once(COMMON_VIEWS . 'header.php'); ?>
<body>
    <div class="wrapper">
        <!-- sidebar start -->
        <?php 
            $moduleName = 'Dashboard';
            require_once(COMMON_VIEWS . 'sidebar.php'); 
        ?>
        <span id="active_menu" data-menu="dashboard"></span>
        <!-- sidebar end -->
        <div id="content-wrapper">
            <!-- navbar start -->
            <?php require_once(COMMON_VIEWS . 'navbar.php'); ?>
            <!-- navbar end -->
            <div id="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row no-gutters">
                                        <div class="col-md-auto mr-auto">
                                            <h5 class="card-title">Revenue</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row no-gutters">
                                        <div class="col-md-auto mr-auto">
                                            <h5 class="card-title">Top Services</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="ServicePieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row no-gutters">
                                        <div class="col-md-auto mr-auto">
                                            <h5 class="card-title">Spare Parts</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="TopSpareParts"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script>
        $(document).ready(function () {
            // var url = '/web-ex/project/sswms/public/views/employee/addEmployee.php';
            // $("form#addEmployee").submit(function (event){
            //     event.preventDefault();
            //     formData = $(this).serialize();
            //     console.log( $(this).serialize() );
            //     $.ajax({
            //         type: "POST",
            //         url: url,
            //         data: formData,
            //         datatype: "html",
            //     })
            // });

            /* Popovers */
                // $('#serviceTypeName').popover({
                //     container: 'body',
                //     trigger: 'focus',
                //     content: 'Service type name should be unique,\nbetween 2 and 255 characters \n and can only contain characters A-Z, a-z, 0-9, -, _ and &',
                //     placement: function (context, source) {
                //         var position = $(source).position();

                //         if (position.left > 1000) {
                //             return "right";
                //         }
                //         if (position.left < 100) {
                //             return "right";
                //         }

                //         if (position.right < 515 ) {
                //             return "top";
                //         }

                //         if (position.top < 110){
                //             return "right";
                //         }

                //         return "top";
                //     }


                // });

            /* Dashboard Charts */
            let ctx = document.getElementById('myChart').getContext('2d');
            let chart = new Chart(ctx, {
                // chart type
                type: 'line',

                // data

                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [{
                        label: "Revenue",
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 10, 120)',
                        data: [11, 10, 12, 14, 16, 18, 20],
                    }]
                },

                // configuration options
                options: {}
            });

            /* spc = service pie chart */
            let spc = document.getElementById('ServicePieChart').getContext('2d')
            let pieChart = new Chart(spc, {
                // chart type
                type: 'pie',

                data: {
                    labels: ['Routine', 'Tires', 'Battery'],
                    datasets: [{
                        data: [50, 30, 20],
                        backgroundColor: [
                            '#6610F2',
                            '#279AF1',
                            '#FF2663',

                        ],
                        label: "Top services",
                    }]
                },
            });


            let tsp = document.getElementById('TopSpareParts').getContext('2d');
            let barChart = new Chart(tsp, {
                // chart type
                type: 'bar',

                // data

                data: {
                    labels: ["Gasket", "Brake Pedals", "Sprocket", "Helmets", "Tires"],
                    datasets: [{
                        label: "Spare Parts",
                        // xAxisID: "Spare Parts",
                        backgroundColor: ['#50514f', '#F25F5C', '#ffe066', '#247ba0', '#70c1b3'],
                        // borderColor: 'rgb(255, 10, 120)',
                        data: [11, 13, 12, 14, 16],
                    }]
                },

                // configuration options
                // options: {}
            });

        });
    </script>
</body>
</html>
