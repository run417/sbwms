<?php
    require_once(COMMON_VIEWS . 'header.php');
?>
<style>
    .image {
    min-height: 100vh;
    }

    .login {
        min-height: 100vh;
        position: relative;
    }

    .login::before {
        content: "";
        top: 0; left: 0;
        width: 100%; height: 100%;
        position: absolute;
        background-image: url('/sbwms/public/assets/img/car-parts-pattern.png');
        background-size: cover;
        filter: opacity(6%);
        /* filter: contrast(%); */
        /* filter: invert(50%); */
        /* filter: brightness(1%); */
    }
     h3 {
         font-family: Comfortaa;
         /* font-weight: 600; */
     }
     #error-message {
        font-size: 80%;
        color: #dc3545;
        padding-bottom: 10px;
     }

    /* .bg-image {
    background-image: url('https://res.cloudinary.com/mhmd/image/upload/v1555917661/art-colorful-contemporary-2047905_dxtao7.jpg');
    background-size: cover;
    background-position: center center;
    } */


</style>
<body>
    <div class="container-fluid">
        <div class="row no-gutter">

            <!-- The Image Half -->
            <div class="col-md-7 d-none d-md-flex bg-image"></div>

            <!-- The Login Content Half -->
            <div class="col-md-5 bg-light login d-flex align-items-center py-5">
                <!-- <div class=""> -->
                    <!-- Content -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="mb-5 text-center">SBWMS Login</h3>
                                <form id="login-form" style="width: 250px" class="mx-auto">
                                    <div id="error-message" style="display: none;">message</div>
                                    <div class="form-group mb-3">
                                        <input type="text" name="username" placeholder="Username" class="form-control px-4 py-1 shadow-sm">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password" name="password" placeholder="Password" class="form-control px-4 py-1 shadow-sm">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 shadow-sm">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </div>

        </div> <!-- </row.no-gutter> -->
    </div> <!-- </container-fluid> -->

    <?php require_once(COMMON_VIEWS . 'footer.php'); ?>
    <script src="<?= url_for('/assets/js/custom/login.js'); ?>"></script>
</body>
