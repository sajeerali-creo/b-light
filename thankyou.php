<?php
include 'partials/header.php';


unset($_SESSION['after_payment_url']);

if (isset($_REQUEST['group']) && $_REQUEST['group'] != "" && isset($_REQUEST['package']) && $_REQUEST['package'] != "" && isset($_REQUEST['txn']) && $_REQUEST['txn'] != "") {

    $mealplanId = isset($_REQUEST['mealplan']) && $_REQUEST['mealplan'] != "" ? $_REQUEST['mealplan'] : '';

} else {
    header('Location: ' . ROOT_URL);
    exit;
}
unset($_SESSION['TransactionID']);
?>
<!-- ===========SUBHEADER=========== -->
<section class="inner-banner">
</section>

<section class="padding-top padding-bottom">
    <div class="container text-center">
        <div id="lottie-animation" style="width:150px; height:150px; margin:auto;"></div>

        <script>

            lottie.loadAnimation({

                container: document.getElementById('lottie-animation'),

                renderer: 'svg',

                loop: true,

                autoplay: true,

                path: 'img/animation-success.json'

            });

        </script>
        <h2 class="h1 text-dark text-uppercase">Thank you</h2>
        <p class=" opacity-50">Your order hab been place!</p>
        <div class="row justify-content-center">

            <div class="py-5 d-flex justify-content-center col-lg-6">
                <div class="plan-detail-card p-5 text-start">
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <p class="opacity-50">Package Name:</p>
                        <p><?= $packagename ?></p>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <p class="opacity-50">Package Durationn:</p>
                        <p><?= $pck_DurationDays ?> Days</p>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                        <p class="opacity-50">Total:</p>
                        <p><?= $_SESSION['amount_val'] ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="opacity-50">Transcaction ID:</p>
                        <p><?= $_REQUEST['txn'] ?></p>
                    </div>
                   
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <a href="<?php echo ROOT_URL . 'profile.php'; ?>" class="btn-outline"><i class="ti ti-arrow-left"></i>&nbsp;Go
                Profile</a>
        </div>
    </div>
</section>

<?php
include './partials/footer.php';
?>