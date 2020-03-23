<script src="<?= url_for("/assets/js/popper.js"); ?>"></script>
<script src="<?= url_for("/assets/js/jquery-3.3.1.js"); ?>"></script>
<script src="<?= url_for("/assets/js/bootstrap.js"); ?>"></script>
<script src="<?= url_for("/assets/js/moment.js"); ?>"></script>
<script src="<?= url_for("/assets/js/plugins/jquery.mCustomScrollbar.concat.min.js"); ?>"></script>
<script src="<?= url_for("/assets/js/Chart.js"); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/pdfmake-0.1.36/pdfmake.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/pdfmake-0.1.36/vfs_fonts.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/DataTables/jquery.dataTables.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/DataTables/dataTables.bootstrap4.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/DataTables/dataTables.buttons.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/DataTables/buttons.bootstrap4.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/DataTables/buttons.html5.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/DataTables/buttons.print.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/jquery.validate.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/jquery.timepicker.min.js'); ?>"></script>
<script src="<?= url_for('/assets/js/plugins/jquery.inputmask.min.js'); ?>"></script>

<script>
    $(document).ready(function () {
        highlightMenuItem();

        function highlightMenuItem() {
            // get the menu name from the page
            let menuData = $('#active_menu').data('menu');
            let submenuData = $('#sub_menu').data('submenu');
            console.log(submenuData);


            if (!menuData) {
                console.log('Menu data does not match menu item');
                return;
            }

            // add selected class to sidebar menu depending on its position
            if (menuData) {
                let activeMenu = $(`#${menuData}_menu`);
                activeMenu.addClass('selected');
                if (submenuData) {
                    // remove collapsed class from activemenu child
                    activeMenu.children().removeClass('collapsed');
                    activeMenu.next().addClass('show');
                    // add show class to the activemenu sibling
                    let submenu = $(`#${submenuData}-menu`);
                    submenu.addClass('selected');
                }
            }
            // if (activeMenu.previousElementSibling) {
            //     activeMenu.previousElementSibling.classList.add('selected');
            // } else {
            //     activeMenu.parentElement.classList.add('selected');
            // }
        }
        // let activeMenu = do
        $("#sidebar").mCustomScrollbar({
            theme: "minimal",
            scrollInertia: 250
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar, #content-wrapper').toggleClass('active');
        });

        /* logout confirmation modal */
        $('#logout').on('click', function () {
            $('body').append("<div class=\"modal fade\" id=\"myModal\"><div class=\"modal-dialog modal-dialog-centered\"><div class=\"modal-content\"><div class=\"modal-header\"><h4 class=\"modal-title\">Logout?</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times</button></div><div class=\"modal-body\">Please confirm action logout.</div> <div class=\"modal-footer\"><a href=\"\/sbwms\/public\/logout\" class=\"btn btn-danger text-light\">Yes</a><a class=\"btn btn-secondary text-light\" data-dismiss=\"modal\">No</a></div></div></div></div>");
            $('#myModal').modal({});
            $('#myModal').on('hidden.bs.modal', function (e) {
                $('#myModal').remove();
            });
        });
    });

    $.validator.setDefaults({
        onfocusout: (element) => { $(element).valid(); },
        errorClass: 'is-invalid',
        errorElement: 'label',
        validClass: 'is-valid',
        errorPlacement: (error, element) => {
            error.addClass('invalid-feedback');
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.next('label'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: (element, errorClass, validClass) => {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: (element, errorClass, validClass) => {
            $(element).addClass(validClass).removeClass(errorClass);
        },
    });


    /* ### SBWMS Time ### */
    setInterval(time, 1000);
    const sh = $('#system-time').data('hours');
    const sm = $('#system-time').data('minutes');
    let currentTime = new Date();
    const hdiff = sh - currentTime.getHours();
    const mdiff = sm - currentTime.getMinutes();
    // negative values doesnt matter. the offset is
    // added to the current time. The offset is the
    // difference between the start time and the
    // currrent time

    function time() {
        let cT = new Date(); // current time
        let h = cT.getHours() + hdiff;
        let m = cT.getMinutes() + mdiff;
        let s = cT.getSeconds();

        let timeStr = (h + ":" + ((m < 10) ? "0" + m : m) + ":" + ((s < 10) ? "0" + s : s));
        $('#display-time').text(timeStr);
    }

    /* ### End System Time ### */

    const swalB = Swal.mixin({
        background: '#ceebfd',
        customClass: {
            confirmButton: 'btn btn-success mx-3',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false,
        reverseButtons: true,
    });

    /**
     * Helper function that returns the url for a path
     */
    function urlFor(path) {
        urlPrefix = '<?= WWW_ROOT; ?>';
        if (path === '#') return '#';
        if (path === '' || path[0] !== '/') path = '/' + path;
        return urlPrefix + path;
    }
    </script>
    <script src="<?= url_for('assets/js/custom/service-status.js'); ?>"></script>
