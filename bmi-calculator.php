<?php
include 'partials/header.php';

// ================= INITIALIZE =================
$bmi = $bmr = "";
$filteredPlans = [];

// Retain inputs
$height  = $_POST['height'] ?? '';
$weight  = $_POST['weight'] ?? '';
$gender  = $_POST['gender'] ?? '';
$age     = $_POST['age'] ?? '';
$medical = $_POST['medical'] ?? '';

// Errors
$heightErr = $weightErr = $genderErr = $ageErr = $medicalErr = "";

// ================= FORM SUBMIT =================
if (isset($_POST['calculate'])) {

    if (empty($height) || $height <= 0) $heightErr = "Enter valid height";
    if (empty($weight) || $weight <= 0) $weightErr = "Enter valid weight";
    if (empty($gender)) $genderErr = "Select gender";
    if (empty($age) || $age <= 0) $ageErr = "Enter valid age";
    if (empty($medical)) $medicalErr = "Select condition";

    if (!$heightErr && !$weightErr && !$genderErr && !$ageErr && !$medicalErr) {

        // BMI Calculation
        $height_m = $height / 100;
        $bmi = round($weight / ($height_m * $height_m), 2);

        // BMR Calculation
        if ($gender == "M") {
            $bmr = round((10 * $weight) + (6.25 * $height) - (5 * $age) + 5, 2);
        } else {
            $bmr = round((10 * $weight) + (6.25 * $height) - (5 * $age) - 161, 2);
        }
    }
}

// ================= MEAL PLAN ENGINE =================
function getMealPlanFinal($bmi, $gender, $medical, $age)
{
    if ($age < 15) return ["LIL Tots"];
    if ($medical === "yes") return ["Med Lite"];
    if ($bmi < 18.5) return ["Bulk Up"];

    if ($gender === "M") {
        return ["Shape Up", "Keto Byte", "V Lite", "B FIT"];
    }

    //return ["Shapeup", "Ketobyte", "Vlite", "Bfit", "EnergizeHer", "MumzFuel"];
    return ["Shape Up", "Keto Byte", "V Lite", "B FIT", "EnergizeHER", "Mumz Fuel"];
    
}

// Apply logic only after BMI calculation
if ($bmi) {
    $filteredPlans = getMealPlanFinal($bmi, $gender, $medical, $age);
}
?>

<!-- ===========SUBHEADER=========== -->
<section class="inner-banner"></section>

<?php $query = mysqli_query($connection, "SELECT * FROM success_stories"); ?>

<section class="padding-top padding-bottom">
<div class="container">
<div class="row">

    <div class="col-12 text-start mb-4">
        <h2>Enter your Measurements</h2>
    </div>

    <!-- FORM -->
    <div class="col-lg-6">
        <form method="POST">
            <div class="box-form p-4">

                <div class="mb-3">
                    <label class="mb-2 bold">Height (cm)</label>
                    <input type="number" name="height" value="<?= $height ?>" class="form-control w-100">
                    <span class="text-danger"><?= $heightErr ?></span>
                </div>

                <div class="mb-3">
                    <label class="mb-2 bold">Weight (kg)</label>
                    <input type="number" name="weight" value="<?= $weight ?>" class="form-control w-100">
                    <span class="text-danger"><?= $weightErr ?></span>
                </div>

                <div class="mb-3">
                    <label class="bold">Gender</label>
                    <div class="d-flex gap-3 align-items-center mt-3">

                        <label class="custom-radio">
                        <input type="radio" name="gender" value="M" <?= ($gender == "M") ? "checked" : "" ?>>
                        <span class="radio-label">Male</span>
                        </label>

                        <label class="custom-radio">
                        <input type="radio" name="gender" value="F" <?= ($gender == "F") ? "checked" : "" ?>>
                        <span class="radio-label">Female</span>
                        </label>

                    </div>
                    <span class="text-danger"><?= $genderErr ?></span>
                </div>

                <div class="mb-3">
                    <label class="mb-2">Age</label>
                    <input type="number" name="age" value="<?= $age ?>" class="form-control w-100">
                    <span class="text-danger"><?= $ageErr ?></span>
                </div>

                <div class="mb-3">
                    <label class="mb-2 bold">Medical condition</label>
                    <div class="d-flex gap-3 align-items-center">

                        <label class="custom-radio">
                        <input type="radio" name="medical" value="yes" <?= ($medical == "yes") ? "checked" : "" ?>>
                        <span class="radio-label">Yes</span>
                        </label>

                        <label class="custom-radio">
                        <input type="radio" name="medical" value="no" <?= ($medical == "no") ? "checked" : "" ?>>
                        <span class="radio-label">No</span>
                        </label>

                    </div>
                    <span class="text-danger"><?= $medicalErr ?></span>
                </div>

                <div class="d-flex">
                <button class="btn btn-primary w-100 d-flex justify-content-center" name="calculate">
                Calculate
                </button>
                </div>

            </div>
        </form>
    </div>

    <!-- RESULT -->
    <div class="col-lg-6 mt-4 mt-lg-0">

    <div class="d-flex flex-column align-items-center justify-content-center box-bmi mb-4 p-4">
    <h3>BMI</h3>
    <h1><?= ($bmi) ? $bmi : '- - -' ?></h1>
    <div class="under-w">Underweight</div>
    <!-- <div class="normal-w">Normal</div> -->
    <!-- <div class="over-w">Overweight</div> -->
    <!-- <div class="obese-w">Obese-1</div> -->
    </div>

    <div class="d-flex flex-column align-items-center justify-content-center box-bmr p-4">
    <h3>BMR</h3>
    <h1><?= ($bmr) ? $bmr : '- - -' ?></h1>
    </div>

    </div>

</div>

<?php
// ================= AUTO FILTER PLANS =================
if (!empty($filteredPlans)) {

    $where = "'" . implode("','", $filteredPlans) . "'";
    $query = mysqli_query($connection, "SELECT * FROM meal_plans WHERE title IN ($where)");

} else {

    $query = mysqli_query($connection, "SELECT * FROM meal_plans LIMIT 4");

}
?>

<div class="row mt-5">
<div class="col-lg-12 mb-3">
<h2>Suggested Meal Plans</h2>
</div>

<div class="row">

<?php while ($result = mysqli_fetch_array($query)) { ?>

<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up">
<div class="meal-box">

<a href="<?= ROOT_URL ?>plan_details.php?id=<?= $result['id'] ?>" class="plan-link">

<div class="over-lay">
<h4><?= $result['title']; ?></h4>
<p><?= strip_tags(stripcslashes(html_entity_decode($result['sub_title']))); ?></p>

<a href="<?= ROOT_URL ?>plan_details.php?id=<?= $result['id'] ?>" class="d-flex gap-2 btn-booknow">
<i class="ti ti-calendar-due text-white"></i>Book Now</a>
</div>

<img src="<?= ADMIN_URL . $result['file_path']; ?>" alt="">

</a>

</div>
</div>

<?php } ?>
</div>

<div class="col-lg-12 mt-3 d-flex justify-content-center">
<a href="/meal_plans.php" class="btn btn-primary px-5">View all other meal plans</a>
</div>

</div>
</div>
</section>

<?php include './partials/footer.php'; ?>
