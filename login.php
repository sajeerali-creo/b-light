<?php

include 'partials/second_header.php';



if (isset($_SESSION['user'])) {

    //      echo "after redirect";
//      echo '<pre>';
//      var_dump($_SESSION);
//      echo '</pre>';
// exit;
    if (isset($_SESSION['after_payment_url'])) {
        header('Location: ' . $_SESSION['after_payment_url']);
    } else {
        header('Location: profile.php');
    }


    exit;

}



require_once 'services/authService.php';

$errors = [];

if (isset($_POST["submit"])) {



    $Username = filter_var($_POST['Username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $password = $_POST['password'] ?? '';



    if (empty($Username))
        $errors['Username'] = "Username is required.";

    if (empty($password))
        $errors['password'] = "Password is required.";



    $error_msg = '';

    if (empty($errors)) {

        $formData = [

            'Username' => $Username,

            'password' => $password,

        ];

        $response = signinUser($formData);

        if (

            isset($response['ValidationDetails']['StatusCode']) &&

            $response['ValidationDetails']['StatusCode'] == 200 &&

            !empty($response['MasterDataList'][0])

        ) {

            $user = $response['MasterDataList'][0];

            $_SESSION['user'] = [

                'UserId' => $user['UserId'],

                'Username' => $user['Username'],

                'Email' => $user['EmailId'],

                'Email' => $user['EmailId'],

                'ClientLocationId' => $user['ClientLocationId'],

                'ModeofLogin' => $user['ModeofLogin']

            ];

            $user_data_json = json_encode($user);

            $remember = isset($_POST['remember_me']);



            if ($remember) {

                $token = bin2hex(random_bytes(32));

                $expire = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days



                // Save token in DB

                mysqli_query($connection, "INSERT INTO remember_tokens (user, token, expires_at) VALUES ('$user_data_json', '$token', '$expire')");

                // Set cookie

                setcookie('remember_token', $token, [

                    'expires' => time() + (86400 * 30),  // 30 days

                    'path' => '/creators/',               // important: match the path where your app runs

                    'domain' => 'virammarines.com',      // not with www, and no dot prefix

                    'secure' => true,                    // required for HTTPS

                    'httponly' => true,                  // safer, prevents JavaScript access

                    'samesite' => 'Lax'                  // default behavior works across most browsers

                ]);

            }

            // Redirect to dashboard or home page

            if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {

                header('Location:' . ROOT_URL . 'plan_details.php?id=' . $_REQUEST['id']);

            } else {

                header('Location:' . ROOT_URL);

            }



            exit;

        } else {

            $error_msg = $response['ValidationDetails']['StatusMessage'];

            $Username = '';

            $password = '';

        }

    }

}

$system_arr = [];

$system_query = mysqli_query($connection, "SELECT * FROM system_info");



while ($result = mysqli_fetch_array($system_query)) {

    $system_arr[$result['meta_field']] = $result['meta_value'];

}

?>



<section class="row">

    <div class="col-lg-6 col-xl-8 col-md-12">

        <img src="<?= $system_arr && isset($system_arr['banner']) ? ADMIN_URL . $system_arr['banner'] : ADMIN_URL . 'dist/img/no-image-available.png' ?>"
            class="login-bg" alt="">

    </div>

    <div class="col-lg-6 col-xl-4 col-md-12 d-flex align-items-center">

        <div class="p-4 p-lg-5">

            <a href="<?= ROOT_URL ?>">

                <img src="img/logo-dark.svg" alt="">

            </a>

            <div class="my-4" id="formMessage">

                <h3>Nice to see you again</h3>

                <?php if (isset($error_msg)): ?>

                    <div class="message error" id="global-error-msg">

                        <?= $error_msg; ?>

                        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>

                    </div>



                    <!-- <small class="text-danger"><?= $error_msg; ?></small> -->

                <?php endif; ?>

            </div>

            <form enctype="multipart/form-data" method="POST" id="signinForm">

                <div class="row justify-content-center form">

                    <div class="col-lg-12 mb-4">

                        <input type="text" name="Username" class="form-control w-100" id="Username"
                            placeholder="Enter Username" value="<?= htmlspecialchars($Username ?? '') ?>">

                        <?php if (isset($errors['Username'])): ?>

                            <small class="text-danger"><?= $errors['Username']; ?></small>

                        <?php endif; ?>

                    </div>

                    <div class="col-lg-12 mb-4">

                        <label for="userpassword">Password</label>

                        <input type="password" name="password" class="form-control w-100" id="password"
                            placeholder="Enter Password" value="<?= htmlspecialchars($password ?? '') ?>">

                        <?php if (isset($errors['password'])): ?>

                            <small class="text-danger"><?= $errors['password']; ?></small>

                        <?php endif; ?>

                    </div>

                    <div class="col-lg-12 d-flex justify-content-between">

                        <label class="custom-checkbox">

                            <input type="checkbox" name="remember_me" id="remember_me" />

                            <span class="checkmark"></span>

                            Remember me

                        </label>

                        <a href="<?= ROOT_URL ?>forgot.php" class="text-brand">Forgot password?</a>

                    </div>

                    <div class="d-flex mt-5 light-bg">
                        <button type="submit" name="submit" class="btn-fancy"><span><svg id="loader"
                                    class="button-spinner" viewBox="0 0 50 50">
                                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5" />
                                </svg>Sign In</span></button>
                    </div>
                    <div class="d-flex my-3 justify-content-center opacity-50">
                        Or
                    </div>
                    <div class="social-row">
                        <!-- Google Button -->
                        <button class="btn-social btn-google" id="googleBtn" aria-label="Sign in with Google">
                            <span class="icon-x" aria-hidden="true">
                                <!-- Google G icon (SVG) -->
                                <svg width="20" height="20" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg"
                                    focusable="false">
                                    <path fill="#4285F4"
                                        d="M533.5 278.4c0-18.5-1.6-36.1-4.6-53.3H272v100.8h147.1c-6.3 33.6-25.2 62.1-53.6 81.1v67.4h86.6c50.8-46.8 81.4-115.8 81.4-196z" />
                                    <path fill="#34A853"
                                        d="M272 544.3c72.8 0 134-24.3 178.6-66.1l-86.6-67.4c-24.1 16.2-55 25.9-92 25.9-70.8 0-130.9-47.8-152.3-112.3H30.2v70.6C74.5 494.9 167 544.3 272 544.3z" />
                                    <path fill="#FBBC05"
                                        d="M119.7 326.4c-10.4-30.7-10.4-63.9 0-94.6V161.2H30.2C11.2 201.1 0 239.6 0 278.4s11.2 77.3 30.2 117.2l89.5-69.2z" />
                                    <path fill="#EA4335"
                                        d="M272 109.7c39.6 0 75.3 13.6 103.4 40.4l77.6-77.6C397.5 24.8 335.3 0 272 0 167 0 74.5 49.4 30.2 129.6l89.5 69.2C141.1 157.5 201.2 109.7 272 109.7z" />
                                </svg>
                            </span>
                            <span>Sign in with Google</span>
                        </button>


                        <!-- Facebook Button -->
                        <button class="btn-social btn-facebook" id="facebookBtn" aria-label="Sign in with Facebook">
                            <span class="icon" aria-hidden="true">
                                <!-- Facebook F icon (SVG) -->
                                <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    focusable="false">
                                    <path fill="white"
                                        d="M22 12.07C22 6.55 17.52 2 12 2S2 6.55 2 12.07C2 17.09 5.66 21.19 10.44 21.95v-6.99H7.9v-2.9h2.54V9.41c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.23.2 2.23.2v2.44h-1.25c-1.23 0-1.61.76-1.61 1.54v1.86h2.74l-.44 2.9h-2.3v6.99C18.34 21.19 22 17.09 22 12.07z" />
                                </svg>
                            </span>
                            <span>Sign in with Facebook</span>
                        </button>
                    </div>

                </div>

            </form>

            <div class="text-center mt-5">Don't have an account? <a href="<?= ROOT_URL ?>signup.php"
                    class="text-brand">Sign up now</a></div>

        </div>

    </div>

</section>

<script>

    $('#signinForm').on('submit', function () {

        $('#loader').show(); // Show loader before form submits

    });

</script>

<?php

include './partials/footer.php';

?>