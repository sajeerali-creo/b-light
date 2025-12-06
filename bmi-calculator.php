<?php
include 'partials/header.php';
?>
<!-- ===========SUBHEADER=========== -->
<section class="inner-banner">
</section>
<?php

$query = mysqli_query($connection, "SELECT * FROM success_stories");

?>
<section class="padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12 text-start mb-4">
                <h2>Enter your Measurements</h2>
            </div>
            <div class="col-lg-6">
                <div class="box-form p-4">
                    <div class="mb-3">
                        <label for="lastname" class="mb-2 bold">Height (cm)</label>
                        <input type="number" name="lastname" class="form-control w-100"
                            placeholder="Enter your current height">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="mb-2 bold">Weight (kg)</label>
                        <input type="number" name="lastname" class="form-control w-100"
                            placeholder="Enter your current weight">
                    </div>
                    <div class="mb-3">
                        <label for="Gender" class="bold">Gender</label>
                        <div class="d-flex gap-3 align-items-center mt-3">

                            <label class="custom-radio">
                                <input type="radio" name="Gender" value="M" <?php if ($Gender === "M")
                                    echo 'checked'; ?> />
                                <span class="radio-label">Male</span>
                            </label>

                            <label class="custom-radio">
                                <input type="radio" name="Gender" value="F" <?php if ($Gender === "F")
                                    echo 'checked'; ?> />
                                <span class="radio-label">Female</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="mb-2">Age</label>
                        <input type="number" name="lastname" class="form-control w-100" placeholder="Enter your age">
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="mb-2 bold">Medical condition</label>
                        <div class="radio-group">

                            <div class="d-flex gap-3 align-items-center">
                                <label class="custom-radio">
                                    <input type="radio" name="Gender" value="M" <?php if ($Gender === "M")
                                        echo 'checked'; ?> />
                                    <span class="radio-label">Yes</span>
                                </label>

                                <label class="custom-radio">
                                    <input type="radio" name="Gender" value="F" <?php if ($Gender === "F")
                                        echo 'checked'; ?> />
                                    <span class="radio-label">No</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary w-100 d-flex justify-content-center">Calculate</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0">
                <div class="d-flex flex-column align-items-center justify-content-center box-bmi mb-4 p-4">
                    <h3>BMI</h3>
                    <h1>- - -</h1>
                </div>
                <div class="d-flex flex-column align-items-center justify-content-center box-bmr p-4">
                    <h3>BMR</h3>
                    <h1>- - -</h1>
                </div>
            </div>
        </div>

        <?php
        $query = mysqli_query($connection, "select * from meal_plans limit 4");
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

                                    <h4><?php echo $result['title']; ?></h4>

                                    <p><?php echo strip_tags(stripcslashes(html_entity_decode($result['sub_title']))); ?>
                                    </p>

                                    <a href="<?= ROOT_URL ?>plan_details.php?id=<?= $result['id'] ?>"
                                        class="d-flex gap-2 btn-booknow"><i class="ti ti-calendar-due text-white"></i>Book

                                        Now</a>

                                </div>

                                <img src="<?php echo ADMIN_URL . $result['file_path']; ?>" alt="">

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

<?php
include './partials/footer.php';
?>