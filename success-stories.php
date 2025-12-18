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
            <!-- <?php while ($result = mysqli_fetch_array($query)) { ?>
                <div class="col-lg-4 mb-4">
                    <div class="card"><img src="<?php echo ADMIN_URL . $result['file_path']; ?>" class="card-img-top"
                            alt="..."></div>
                </div>

            <?php } ?> -->

                <div class="px-5">
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/1-after.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/1-before.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/2-after.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/2-before.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/4-after.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/4-before.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/5_after.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/5_before.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/6_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/6_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/7_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/7_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/8_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/8_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/9_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/9_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/10_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/10_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
           
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/12_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/12_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/13_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/13_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/14_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/14_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/15_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/15_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/16_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/16_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="ba-container">
                    <div class="ba-label before-label">Before</div>
                    <div class="ba-label after-label">After</div>
                    <div class="ba-img after">
                        <img src="img/17_after_4x.webp" alt="After Image">
                    </div>

                    <div class="ba-img before">
                        <img src="img/17_before_4x.webp" alt="Before Image">
                    </div>

                    <div class="ba-handle"></div>
                </div>
            </div>
          
        </div>
    </div>
        </div>
    </div>
</section>

<?php
include './partials/footer.php';
?>