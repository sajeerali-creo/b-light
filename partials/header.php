<?php
session_start();
require 'config/database.php';
require_once 'services/commonService.php';

// Set proper UTF-8 header
header('Content-Type: text/html; charset=utf-8');

// Ensure MySQL connection is UTF-8
mysqli_set_charset($connection, "utf8mb4");

// Handle "Remember Me" token
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];

    $query = mysqli_query($connection, "SELECT * FROM remember_tokens WHERE token = '$token' AND expires_at > NOW()");
    $row = mysqli_fetch_assoc($query);

    if ($row) {
        $userData = json_decode($row['user'], true);
        $_SESSION['user'] = $userData;
    } else {
        // Token expired or invalid
        setcookie('remember_token', '', time() - 3600, '/');
    }
}

// Initialize user data
$fullname = "";
$clientprofileData = [];
$profilePicture = null;

if (isset($_SESSION['user'])) {
    $paramData = [
        'PersonId' => $_SESSION['user']['UserId']
    ];
    $response = fetchUserProfile($paramData);

    if (
        isset($response['ValidationDetails']['StatusCode']) &&
        $response['ValidationDetails']['StatusCode'] == 200 &&
        !empty($response['MasterDataList'][0])
    ) {
        $clientprofileData = $response['MasterDataList'];

        // Ensure UTF-8 encoding for names
        $firstName = isset($clientprofileData[0]['FirstName']) ? $clientprofileData[0]['FirstName'] : '';
        $middleName = isset($clientprofileData[0]['MiddleName']) ? $clientprofileData[0]['MiddleName'] : '';
        $lastName = isset($clientprofileData[0]['LastName']) ? $clientprofileData[0]['LastName'] : '';

        $fullname = htmlspecialchars($firstName . ' ' . $middleName . ' ' . $lastName, ENT_QUOTES, 'UTF-8');
        $profilePicture = $clientprofileData[0]['ProfilePicture'] ?? null;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=3600">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blite</title>
    <link rel="icon" type="image/png" href="img/fav-icon3.png">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link href="https://fonts.cdnfonts.com/css/helvetica-neue-55" rel="stylesheet">
    <link rel="stylesheet" href="css/core_103.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
</head>

<body>
    <header class="main-header d-flex align-items-center">
        <div class="px-3 px-lg-5 d-flex justify-content-between align-items-center w-100">
            <div class="d-flex gap-5">
                <a href="<?= ROOT_URL ?>" class="d-flex align-items-center">
                    <img src="img/logo-animated2.gif" class="logo" alt="">
                </a>
                <div class="d-none d-lg-flex">
                    <div class="d-flex gap-5 menus align-items-center">
                        <a href="<?= ROOT_URL ?>meal_plans.php"
                            class="drawer-trigger position-relative d-flex align-items-center h-100" id="myBtn">
                            Meal Plans&nbsp;<i class="ti ti-chevron-down fs-5"></i>
                        </a>
                        <!-- Add your other menu items here -->
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-block">
                <?php if (!isset($_SESSION['user'])) { ?>
                    <div class="d-flex align-items-center gap-2">
                        <a href="tel:800-4387546" class="text-white fs-6 d-flex gap-2 align-items-center"><i
                                class="ti ti-phone"></i> 800 GETSLIM</a>
                        <a href="<?= ROOT_URL ?>login.php" class="fs-5 px-3 text-white">Login</a>
                        <a href="<?= ROOT_URL ?>signup.php" class="btn-first">Sign Up</a>
                    </div>
                <?php } else { ?>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= ROOT_URL ?>profile.php"><span class="text-white"><?= $fullname ?></span></a>
                        <div class="user-head">
                            <?php
                            $base64img = $profilePicture != null ? $profilePicture : ROOT_URL . 'img/defaultimagex2.webp';
                            if ($profilePicture != null) { ?>
                                <img src="data:image/jpeg;base64,<?= $base64img ?>" alt="">
                            <?php } else { ?>
                                <img src="<?= $base64img ?>" alt="">
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </header>


    <body>
        <div id="preloader" aria-hidden="false">
            <div class="spinner-body" role="status" aria-label="Loading"></div>
        </div>

        <header class="main-header d-flex align-items-center">
            <div class="px-3 px-lg-5 d-flex justify-content-between align-items-center w-100">
                <div class="d-flex gap-5">
                    <a href="<?= ROOT_URL ?>" class="d-flex align-items-center">
                        <img src="img/logo-animated2.gif" class="logo" alt="">
                    </a>
                    <div class="d-none d-lg-flex">
                        <div class="d-flex gap-5 menus align-items-center">
                            <a href="<?= ROOT_URL ?>meal_plans.php"
                                class="drawer-trigger position-relative d-flex align-items-center h-100" id="myBtn">Meal
                                Plans&nbsp;<i class="ti ti-chevron-down fs-5"></i></a>
                            <div class="drawer">
                                <div class="drawer-inner p-4">
                                    <div class="container">
                                        <div class="row row-gap-3">
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=1"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m1.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">SHAPE UP</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=10"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m2.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">KETO BYTE</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=3"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m3.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">BULK UP</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=9"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m4.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">V Lite</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=11"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m5.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">EnergizeHER</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=12"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m6.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">MED Lite</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=13"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m7.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">MUMZ Fuel</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=14"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m8.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">LIL TOTS</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>plan_details.php?id=15"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m9.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">B FIT</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-end">
                                                <a href="<?= ROOT_URL ?>meal_plans.php" class="text-brand">View all Meal
                                                    Plans&nbsp;<i class="ti ti-arrow-narrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= ROOT_URL ?>our_services.php"
                                class="drawer-trigger position-relative d-flex align-items-center h-100">Our
                                Services&nbsp;<i class="ti ti-chevron-down fs-5"></i></a>
                            <div class="drawer">
                                <div class="drawer-inner p-4">
                                    <div class="container">
                                        <div class="row row-gap-3">
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>service_details.php?id=3"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/s2.webp" alt="">
                                                        </div>
                                                        <div class="text-brand">Dietary Consultation</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>service_details.php?id=4"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>

                                                            <img src="img/s1.webp" alt="">
                                                        </div>
                                                        <div class="text-brand">Corporate Wellness Program</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>service_details.php?id=5"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/s3.webp" alt="">
                                                        </div>
                                                        <div class="text-brand">Slimming & Body Contouring Services
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>service_details.php?id=6"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/s4.webp" alt="">
                                                        </div>
                                                        <div class="text-brand">Healthy Catering Services for Your
                                                            Events
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>service_details.php?id=7"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-m8.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Healthy Nursery and School Catering
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>meal_plans.php"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/bmi-cal.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Personalized Meals Delivered Daily
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 d-flex justify-content-end">
                                                <a href="<?= ROOT_URL ?>our_services.php" class="text-brand">View all
                                                    Services&nbsp;<i class="ti ti-arrow-narrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= ROOT_URL ?>about.php"
                                class="drawer-trigger position-relative d-flex align-items-center h-100">Why Choose
                                us&nbsp;<i class="ti ti-chevron-down fs-5"></i></a>
                            <div class="drawer">
                                <div class="drawer-inner p-4">
                                    <div class="container">
                                        <div class="row row-gap-3">
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>about.php#woh-we-are"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-a4.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Who we are</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>about.php#team"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-a1.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Our Licensed Dietitians</div>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>about.php#our-menu"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-a2.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Our Menu</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>about.php#why-choose-blight"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-a3.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Certifications</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>about.php#success"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-a5.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Success Stories</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>about.php#our-menu"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-a6.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Locations</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>about.php#testimonial"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/ic-a7.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Testimonials</div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="transp-box">
                                                    <a href="<?= ROOT_URL ?>menus.php"
                                                        class="d-flex gap-3 align-items-center">
                                                        <div>
                                                            <img src="img/sample-menu.svg" alt="">
                                                        </div>
                                                        <div class="text-brand">Sample Menus</div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= ROOT_URL ?>contact.php">Contact Us</a>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-block">
                    <?php if (!isset($_SESSION['user'])) { ?>
                        <div class="d-flex align-items-center gap-2">
                            <a href="tel:800-4387546" class="text-white fs-6 d-flex gap-2 align-items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_2_7)">
<path d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 19.5304 19.7893 20.0391 19.4142 20.4142C19.0391 20.7893 18.5304 21 18 21C14.0993 20.763 10.4202 19.1065 7.65683 16.3432C4.8935 13.5798 3.23705 9.90074 3 6C3 5.46957 3.21071 4.96086 3.58579 4.58579C3.96086 4.21071 4.46957 4 5 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_2_7">
<rect width="24" height="24" fill="white"/>
</clipPath>
</defs>
</svg>800-4387546</a>
                            <a href="<?= ROOT_URL ?>login.php" class="fs-5 px-3 text-white">Login</a>
                            <a href="<?= ROOT_URL ?>signup.php" class="btn-first">Sign Up</a>
                        </div>
                    <?php } else { ?>
                        <div class="d-flex align-items-center gap-2">
                            <a href="<?= ROOT_URL ?>profile.php"><span
                                    class="text-white"><?php echo $fullname; ?></span></a>
                            <div class="user-head">

                                <a href="<?= ROOT_URL ?>profile.php">
                                    <?php
                                    $base64img = $profilePicture != null ? $profilePicture : ROOT_URL . 'img/defaultimagex2.webp';
                                    if ($profilePicture != null) { ?>
                                        <img src="data:image/jpeg;base64,<?= $base64img ?>" alt="">
                                    <?php } else { ?>
                                        <img src="<?= $base64img ?>" alt="">
                                    <?php }
                                    ?>

                                </a>
                            </div>
                            <!-- <a href="<?= ROOT_URL ?>logout.php" class="btn-first w-auto px-4">Logout</a> -->
                        </div>
                    <?php } ?>
                </div>
                <div class="d-lg-none">
                    <a href="#" class="btn-menu" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i
                            class="ti ti-menu-4"></i></a>
                </div>
            </div>



            <!-- offcanvas -->
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
                aria-labelledby="offcanvasWithBothOptionsLabel">
                <div class="offcanvas-body">
                    <div class="d-flex flex-column gap-4 justify-content-between h-100">
                        <div class="d-flex gap-4 flex-column">
                            <?php if (isset($_SESSION['user'])) { ?>
                                <div class="user-card">
                                    <div class="user-avtar">
                                        <!-- <img src="img/avatar.webp" alt=""> -->
                                        <i class="ti ti-user"></i>
                                    </div>
                                    <a href="<?= ROOT_URL ?>profile.php"><strong
                                            class="text-white mt-2 d-flex"><?php echo $fullname; ?></strong></a>
                                </div>
                            <?php } ?>
                            <div class="d-flex flex-column gap-5 menus p-4">
                                <a href="<?= ROOT_URL ?>meal_plans.php" class="mt-5">Meal Plans</a>
                                <!-- <div class="d-flex flex-column gap-3">
                                <a href="<?= ROOT_URL ?>plan_details.php?id=1" class="px-4">SHAPE UP</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=10" class="px-4">KETO BYTE</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=3" class="px-4">BULK UP</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=9" class="px-4">V Lite</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=11" class="px-4">EnergizeHER</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=12" class="px-4">MED Lite</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=13" class="px-4">MUMZ Fuel</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=14" class="px-4">LIL TOTS</a>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=10" class="px-4">B FIT</a>
                            </div> -->
                                <a href="<?= ROOT_URL ?>our_services.php">Our Services</a>
                                <a href="<?= ROOT_URL ?>about.php">About Us</a>
                                <a href="<?= ROOT_URL ?>contact.php">Contact Us</a>
                                <?php if (isset($_SESSION['user'])) { ?><a href="<?= ROOT_URL ?>profile.php">My
                                        Profile</a><?php } ?>
                            </div>
                        </div>
                        <?php if (!isset($_SESSION['user'])) { ?>
                            <div class="d-flex flex-column gap-2 p-4">
                                <a href="<?= ROOT_URL ?>login.php" class="btn-second w-100">Login</a>
                                <a href="<?= ROOT_URL ?>signup.php" class="btn-first w-100">Sign Up</a>
                            </div>
                        <?php } else { ?>
                            <div class="d-flex flex-column gap-2 p-4">
                                <a href="<?= ROOT_URL ?>logout.php" class="btn-first w-100">Logout</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="whatsap">
                <a href="https://wa.me/+971588052025" target="_blank" class="pulse"><svg width="24" height="24"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_2_2)">
                            <path
                                d="M3 21L4.65 17.2C3.38766 15.4081 2.82267 13.217 3.06104 11.0381C3.29942 8.85918 4.32479 6.84214 5.94471 5.36552C7.56463 3.8889 9.66775 3.05421 11.8594 3.0181C14.051 2.98198 16.1805 3.74693 17.8482 5.16937C19.5159 6.59182 20.6071 8.57398 20.9172 10.7439C21.2272 12.9138 20.7347 15.1222 19.5321 16.9548C18.3295 18.7873 16.4994 20.118 14.3854 20.6971C12.2713 21.2762 10.0186 21.0639 8.05 20.1L3 21Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M9 10C9 10.1326 9.05268 10.2598 9.14645 10.3536C9.24021 10.4473 9.36739 10.5 9.5 10.5C9.63261 10.5 9.75979 10.4473 9.85355 10.3536C9.94732 10.2598 10 10.1326 10 10V9C10 8.86739 9.94732 8.74021 9.85355 8.64645C9.75979 8.55268 9.63261 8.5 9.5 8.5C9.36739 8.5 9.24021 8.55268 9.14645 8.64645C9.05268 8.74021 9 8.86739 9 9V10ZM9 10C9 11.3261 9.52678 12.5979 10.4645 13.5355C11.4021 14.4732 12.6739 15 14 15M14 15H15C15.1326 15 15.2598 14.9473 15.3536 14.8536C15.4473 14.7598 15.5 14.6326 15.5 14.5C15.5 14.3674 15.4473 14.2402 15.3536 14.1464C15.2598 14.0527 15.1326 14 15 14H14C13.8674 14 13.7402 14.0527 13.6464 14.1464C13.5527 14.2402 13.5 14.3674 13.5 14.5C13.5 14.6326 13.5527 14.7598 13.6464 14.8536C13.7402 14.9473 13.8674 15 14 15Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clipPath id="clip0_2_2">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </a>
            </div>

            <div class="chat-icon" id="chatIcon">💬</div>
            <div class="chat-shell" id="chatShell">
                <div class="chat-header d-flex align-items-center justify-content-between">
                    Chatbot
                    <button class="close-btn" id="closeBtn">×</button>
                </div>
                <div class="chat-body" id="chatBody"></div>
                <div class="chat-footer">
                    <input type="text" id="userInput" placeholder="Type a message...">
                    <button id="sendBtn">Send</button>
                </div>
            </div>

        </header>