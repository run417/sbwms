<script src="<?php echo url_for("/assets/js/popper.js"); ?>"></script>
<script src="<?php echo url_for("/assets/js/jquery-3.3.1.js"); ?>"></script>
<script src="<?php echo url_for("/assets/js/bootstrap.js"); ?>"></script>
<script src="<?php echo url_for("/assets/js/moment.js"); ?>"></script>
<script src="<?php echo url_for("/assets/js/plugins/jquery.mCustomScrollbar.concat.min.js"); ?>"></script>
<script src="<?php echo url_for("/assets/js/Chart.js"); ?>"></script>
<script>
    $(document).ready(function () {
        highlightMenuItem();

        function highlightMenuItem() {
            let menuData = document.querySelector('#active_menu').dataset.menu || 0;
            let activeMenu = document.querySelector('#' + menuData + '_menu');
            if (activeMenu === null) {
                console.log('Menu data does not match menu item');
                return;
            }
            if (activeMenu.previousElementSibling) {
                activeMenu.previousElementSibling.classList.add('selected');

            } else {
                activeMenu.parentElement.classList.add('selected');
            }
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
            $('body').append("<div class=\"modal fade\" id=\"myModal\"><div class=\"modal-dialog modal-dialog-centered\"><div class=\"modal-content\"><div class=\"modal-header\"><h4 class=\"modal-title\">Logout?</h4><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times</button></div><div class=\"modal-body\">Please confirm action logout.</div> <div class=\"modal-footer\"><a href=\"\/sbwms\/public\/logout.php\" class=\"btn btn-danger text-light\">Yes</a><a class=\"btn btn-secondary text-light\" data-dismiss=\"modal\">No</a></div></div></div></div>");
                    $('#myModal').modal({});
                    $('#myModal').on('hidden.bs.modal', function (e) {
                        $('#myModal').remove();
                    });
        });
    });
</script>

