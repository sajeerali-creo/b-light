<?php
include 'partials/second_header.php';
require_once 'services/authService.php';
require_once 'services/commonService.php';
//session_start();
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

$location_response = fetchLocations();
if($location_response['ValidationDetails']['StatusCode'] == 200){
    $locations = $location_response['MasterDataList'];
}
//include "config/constants.php";
//get beck form DATA IF THERE IS A REGISTRATION ERROR
// $firstname=$_SESSION['signup-data']['firstname'] ?? null;
// $lastname=$_SESSION['signup-data']['lastname'] ?? null;
// $username=$_SESSION['signup-data']['username'] ?? null;
// $email=$_SESSION['signup-data']['email'] ?? null;
// $createpassword=$_SESSION['signup-data']['createpassword'] ?? null;
// $confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
//delete signup data session
//unset($_SESSION['signup-data']);

$errors = [];
//$error_msg = '';
//$success_msg = '';
$LocationCode = '';
if(isset($_POST["submit"])){
    $spinner = true;
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $LocationCode = $_POST['LocationCode'] ?? '';

    $Gender = $_POST['Gender'] ?? '';
    $DateOfBirth = $_POST['DateOfBirth'] ?? '';
    if (empty($DateOfBirth)) {
        $errors['DateOfBirth'] = "Date of Birth is required.";
    }
    if (empty($Gender)) {
        $errors['Gender'] = "Please select Gender.";
    }

    if (empty($firstname)) $errors['firstname'] = "First name is required.";
    if (empty($lastname)) $errors['lastname'] = "Last name is required.";
    if (empty($phone)) {
        $errors['phone'] = "Phone number is required.";
    } elseif (!preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
        $errors['phone'] = "Invalid phone number format.";
    }
    // elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
    //     $errors['phone'] = "Phone number must be exactly 10 digits.";
    // }
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }
    if (empty($phone)) $errors['phone'] = 'Phone is required.';
    if (empty($password)){
        $errors['password'] = 'Password is required.';
    }else if(strlen($password) < 6){
        $errors['password'] = 'Password must be at least 6 characters.';
    }
    if (empty($confirm_password)){
        $errors['confirm_password'] = 'Confirm Password is required.';
    }else if($password !== $confirm_password){
        $errors['confirm_password'] = 'Passwords do not match.';
    } 
    if (empty($LocationCode)) $errors['location'] = 'Please select a location.';
    if (empty($errors)) {
        $dateObject = DateTime::createFromFormat('Y-m-d', $DateOfBirth);
        $DOBDate = $dateObject->format('Y-m-d');

        $formData = [
        'Username' => $email,
        'FirstName' => $firstname,
        'MiddleName' => '',
        'LastName' => $lastname,
        'EmailID' => $email,
        'ModeOfEntry' => "website",
        'MobileNo' => $phone,
        'password' => $password,
        'LocationCode' => $LocationCode,
        'DateOfBirth' => $DOBDate,
        'Gender' => $Gender,
        ];

       $response = signupUser($formData);
        if($response['ValidationDetails']['StatusCode'] == 200){
            $success_msg = $response['ValidationDetails']['StatusMessage'];
            // $firstname = '';
            // $lastname = '';
            // $email = '';
            // $phone = '';
            // $password = '';
            // $confirm_password = '';
            // $LocationCode = '';
            $formData = [
                'Username' => $email,
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
                        'UserId'   => $user['UserId'],
                        'Username' => $user['Username'],
                        'Email'    => $user['EmailId'],
                        'ModeofLogin'    => $user['ModeofLogin']
                    ];
                    header('Location:profile.php');
                }
            //exit;
        }else{
            $error_msg = $response['ValidationDetails']['StatusMessage'];
            
        }
    }
}
$system_arr = [];
$system_query=mysqli_query($connection, "SELECT * FROM system_info");

while($result=mysqli_fetch_array($system_query)){
    $system_arr[$result['meta_field']] = $result['meta_value'];
}
?>
 <section class="row">
        <div class="col-lg-6 col-xl-8 col-md-12">
            <img src="<?= $system_arr && isset($system_arr['banner2']) ? ADMIN_URL.$system_arr['banner2'] : ADMIN_URL.'dist/img/no-image-available.png' ?>" class="login-bg" alt="">
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
                    <?php endif; ?>
                    <?php if (isset($success_msg)): ?>
                        <div class="message success" id="global-error-msg">
                            <?= $success_msg; ?>
                            <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                        </div>
                    <?php endif; ?>
                </div>
                <form enctype="multipart/form-data" method="POST" id="signupForm">
                 <div class="row justify-content-center form">
    
                    <div class="col-lg-6 mb-4">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" class="form-control w-100" id="firstname" placeholder="Enter Firstname" value="<?= htmlspecialchars($firstname ?? '') ?>">
                    <?php if (isset($errors['firstname'])): ?>
                                <small class="text-danger"><?= $errors['firstname']; ?></small>
                    <?php endif; ?>
                    </div>

                    <div class="col-lg-6 mb-4">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" class="form-control w-100" id="lastname" placeholder="Enter Lastname" value="<?= htmlspecialchars($lastname ?? '') ?>">
                    <?php if (isset($errors['lastname'])): ?>
                                <small class="text-danger"><?= $errors['lastname']; ?></small>
                    <?php endif; ?>
                    </div>

                    <div class="col-lg-6 mb-4">
                    <label for="useremail">Email</label>
                    <input type="text" name="email" class="form-control w-100" id="email" placeholder="name@example.com" value="<?= htmlspecialchars($email ?? '') ?>">
                    <?php if (isset($errors['email'])): ?>
                        <small class="text-danger"><?= $errors['email']; ?></small>
                    <?php endif; ?>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label for="phone">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">+971</span>
                            <input type="text" 
                                name="phone" 
                                class="form-control" 
                                id="phone" 
                                placeholder="xxxxxxxx" 
                                value="<?= htmlspecialchars($phone ?? '') ?>">
                        </div>
                        <?php if (isset($errors['phone'])): ?>
                            <small class="text-danger"><?= $errors['phone']; ?></small>
                        <?php endif; ?>
                    </div>


                    <div class="col-lg-6 mb-4">
                    <label for="userpassword">Password</label>
                    <input type="password" name="password" class="form-control w-100" id="password" placeholder="Enter Password" value="<?= htmlspecialchars($password ?? '') ?>">
                    <?php if (isset($errors['password'])): ?>
                                <small class="text-danger"><?= $errors['password']; ?></small>
                    <?php endif; ?>
                    </div>

                    <div class="col-lg-6 mb-4">
                    <label for="confirmpassword">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control w-100" id="confirm_password" placeholder="Enter Confirm Password" value="<?= htmlspecialchars($confirm_password ?? '') ?>">
                    <?php if (isset($errors['confirm_password'])): ?>
                                <small class="text-danger"><?= $errors['confirm_password']; ?></small>
                    <?php endif; ?>
                    </div>

                    <div class="col-lg-12 mb-4">
                    <label for="location">Location</label>
                    <select name="LocationCode" class="form-select" id="LocationCode">
                        <option value="">Select Location</option>
                        <?php foreach ($locations as $loc): ?>
                            <?php if (!$loc['IsExcludeFromRegistration']): ?>
                                <option value="<?= htmlspecialchars($loc['LocationCode']) ?>" <?php echo $loc['LocationCode'] == $LocationCode ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($loc['LocationName']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['LocationCode'])): ?>
                                <small class="text-danger"><?= $errors['LocationCode']; ?></small>
                    <?php endif; ?>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="Gender">Gender</label>
                       <div class="d-flex gap-3 align-items-center mt-3">
                       
                        <label class="custom-radio">
                            <input type="radio" name="Gender" value="M" <?php if ($Gender === "M") echo 'checked'; ?> />
                            <span class="radio-label">Male</span>
                        </label>
                            
                        <label class="custom-radio">
                            <input type="radio" name="Gender" value="F" <?php if ($Gender === "F") echo 'checked'; ?> />
                            <span class="radio-label">Female</span>
                        </label>
                        </div>
                        <?php if (isset($errors['Gender'])): ?>
                            <div>   <small class="text-danger"><?= $errors['Gender']; ?></small></div>
                            <?php endif; ?>
                        </div>
                    <div class="col-lg-6 mb-4">
                        <label for="DateOfBirth">Date of Birth</label>
                        <div class="position-relative">
                            <input type="text" name="DateOfBirth"  id="datepickerDOB" value="<?= $DateOfBirth ?>" class="form-control" placeholder="Select date" />
                            <i class="ti ti-calendar-event"></i>
                            <?php if (isset($errors['DateOfBirth'])): ?>
                                    <small class="text-danger"><?= $errors['DateOfBirth']; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex mt-5 light-bg">
                    <button type="submit" name="submit" class="btn-fancy">
                        <span>
                                <svg id="loader" class="button-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5" /></svg>
                        Sign Up</span>
                          </button>
                    </div>
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
                            <span>Sign up with Google</span>
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
                            <span>Sign up with Facebook</span>
                        </button>
                    </div>
                </form>
                <div class="text-center mt-5">Already have an account? <a href="<?= ROOT_URL ?>login.php" class="text-brand">Sign In now</a></div>
            </div>
        </div>
</section>

<script>
    flatpickr("#datepickerDOB", {
    dateFormat: "Y-m-d",
    maxDate: "today"  // disables all future dates
    });
    $('#signupForm').on('submit', function() {
        $('#loader').show(); // Show loader before form submits
    });
</script>
<?php
include './partials/footer.php';
?>