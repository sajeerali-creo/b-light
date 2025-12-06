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
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-12 text-center mb-4">
                <h2 class="h2">ALL SUCCESS <span class="font-weight-200">STORIES</span></h2>
            </div>
            <?php while ($result = mysqli_fetch_array($query)) { ?>
                <div class="col-lg-4 mb-4">
                    <div class="card"><img src="<?php echo ADMIN_URL . $result['file_path']; ?>" class="card-img-top"
                            alt="..."></div>
                </div>

            <?php } ?>
        </div>
    </div>
</section>

<?php
include './partials/footer.php';
?>