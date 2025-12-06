<?php
require 'config/database.php';
$query = mysqli_query($connection, "SELECT * FROM contacts");
while ($row = $query->fetch_assoc()) {
    $meta[$row['meta_field']] = $row['meta_value'];
} ?>
<footer class="padding-top">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="mb-5">
                    <img src="img/logo.svg" alt="">
                </div>
                <p class="text-white">We don’t just offer meals, we help shape lifestyles. Connect with us!</p>
                <div class="d-flex flex-column gap-2">
                    <a href="tel:<?= $meta['mobile'] ?>" class="d-flex gap-2 align-items-center text-white"><i
                            class="ti ti-phone color-shade-2"></i><span>
                            <?= $meta['mobile'] ?>
                        </span></a>
                    <a href="mailto:<?= $meta['email'] ?>" class="d-flex gap-2 align-items-center text-white"><i
                            class="ti ti-mail color-shade-2"></i><span>
                            <?= $meta['email'] ?>
                        </span></a>
                </div>
                <div class="d-flex gap-2 app-icon mt-5">
                    <a href="#">
                        <img src="img/app-store.webp" alt="">
                    </a>
                    <a href="#">
                        <img src="img/google-play.webp" alt="">
                    </a>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div class="row links">
                    <div class="col-lg-4  mb-5 mb-lg-0">
                        <h5>Quicklinks</h5>
                        <div class="d-flex flex-column gap-3">
                            <a href="<?= ROOT_URL ?>">Home</a>
                            <a href="<?= ROOT_URL ?>about.php">About Us</a>
                            <a href="<?= ROOT_URL ?>contact.php">Contact Us</a>
                        </div>
                    </div>
                    <div class="col-lg-4  mb-5 mb-lg-0">
                        <?php
                        $query = mysqli_query($connection, "select * from meal_plans");
                        ?>
                        <h5>Meal Plans</h5>
                        <div class="d-flex flex-column gap-3">
                            <?php while ($result = mysqli_fetch_array($query)) { ?>
                                <a href="<?= ROOT_URL ?>plan_details.php?id=<?= $result['id'] ?>">
                                    <?php echo $result['title']; ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h5>Learn More</h5>
                        <div class="d-flex flex-column gap-3">
                            <a href="<?= ROOT_URL ?>faq.php">FAQs</a>
                            <a href="<?= ROOT_URL ?>blogs.php">Blogs</a>
                            <a href="<?= ROOT_URL ?>terms_conditions.php">Terms & Conditions</a>
                            <a href="<?= ROOT_URL ?>privacy_policy.php">Privacy Policy</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer py-4">
        <div class="d-flex align-items-center container flex-column flex-lg-row gap-3 gap-lg-0">
            <div class="col-lg-6 text-white">
                © <span id="copyYear"></span> BLite Regime and Weight Control Services - L.L.C - S.P.C. All Rights
                Reserved.
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
                <div class="social-media gap-2">
                    <a target="_blank" href="https://www.facebook.com/blite.uae"><i
                            class="ti ti-brand-facebook"></i></a>
                    <a target="_blank" href="https://www.instagram.com/blite.uae/"><i
                            class="ti ti-brand-instagram"></i></a>
                    <a target="_blank" href="https://www.linkedin.com/company/blite-uae/"><i
                            class="ti ti-brand-linkedin"></i></a>
                    <a target="_blank" href="https://www.threads.com/@blite.uae"><i class="ti ti-brand-threads"></i></a>
                    <a target="_blank" href="https://api.whatsapp.com/send?phone=+971588052025"><i
                            class="ti ti-brand-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>




<style>
    #formMessage .message,
    .bookingmodalcls .message {
        padding: 12px 16px;
        border-radius: 5px;
        margin-bottom: 12px;
        font-size: 14px;
        position: relative;
        animation: fadeIn 0.3s ease-in-out;
    }

    #formMessage .success,
    .bookingmodalcls .success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    #formMessage .error,
    .bookingmodalcls .error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    #formMessage .close-btn,
    .bookingmodalcls .close-btn {
        position: absolute;
        right: 10px;
        top: 6px;
        font-weight: bold;
        color: inherit;
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<style>
    .button-spinner {
        width: 35px;
        padding-right: 10px;
        display: none;
    }

    #currentspinner,
    #targetspinner {
        animation: rotate 2s linear infinite;
        width: 20px;
        height: 20px;
        margin-right: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!-- animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="js/main_2.js"></script>
<script src="js/custom.js"></script>
<script>
    AOS.init();
</script>
<script>
    $(function () {
        $("#copyYear").text(new Date().getFullYear());
    });
</script>
<script>
    // Small JS to pause video when not visible (saves CPU)
    (function () {
        const video = document.getElementById('heroVideo');
        const bg = document.getElementById('heroBg');

        // If touch device, prefer background image (saves mobile data)
        const isTouch = ('ontouchstart' in window) || navigator.maxTouchPoints > 0;
        if (isTouch) {
            if (video) video.style.display = 'none';
            if (bg) bg.style.display = 'block';
            return;
        }

        // IntersectionObserver pauses video when out of view
        if ('IntersectionObserver' in window && video) {
            const io = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        // try to play (some browsers require user gesture; it's muted so usually allowed)
                        video.play().catch(() => {/* ignore */ });
                    } else {
                        video.pause();
                    }
                });
            }, { threshold: 0.25 });
            io.observe(video);
        }

        // If video fails to load, show poster bg
        video.addEventListener('error', () => {
            video.style.display = 'none';
            if (bg) bg.style.display = 'block';
        });
    })();
</script>

<script>
    const mainImage = document.getElementById('mainImage');
    const mainTitle = document.getElementById('mainTitle');
    const mainDesc = document.getElementById('mainDesc');
    const cards = Array.from(document.querySelectorAll('.product-card'));

    let currentIndex = 0;

    // function to show a card’s data with fade
    function showCardData(card) {
        mainImage.style.opacity = 0;
        mainTitle.style.opacity = 0;
        mainDesc.style.opacity = 0;

        setTimeout(() => {
            mainImage.src = card.dataset.image;
            mainTitle.textContent = card.dataset.title;
            mainDesc.textContent = card.dataset.desc;

            mainImage.style.opacity = 1;
            mainTitle.style.opacity = 1;
            mainDesc.style.opacity = 1;
        }, 400); // match CSS transition time
    }

    // manual click only
    cards.forEach((card, index) => {
        card.addEventListener('click', () => {
            currentIndex = index;
            showCardData(card);
        });
    });

    // initialize with the first card
    if (cards.length > 0) {
        showCardData(cards[0]);
    }
</script>


<script>
    // Wait 3 seconds, then hide the div
    setTimeout(() => {
        document.getElementById("notice").classList.add("hide");
    }, 3000);
</script>

<script>
    $(function () {
        function setupDrawer(triggerSelector, drawerSelector) {
            const $trigger = $(triggerSelector);

            $trigger.each(function () {
                const $this = $(this);
                const $drawer = $this.next(drawerSelector);

                $drawer.hide();

                // open drawer on hover
                $this.on("mouseenter", function () {
                    $drawer.stop(true, true).slideDown(200);
                    $this.addClass("active");
                });

                // handle leaving trigger or drawer
                $this.add($drawer).on("mouseleave", function () {
                    setTimeout(function () {
                        if (!$this.is(":hover") && !$drawer.is(":hover")) {
                            $drawer.stop(true, true).slideUp(200);
                            $this.removeClass("active");
                        }
                    }, 150); // delay prevents flicker when moving between trigger and drawer
                });
            });
        }

        setupDrawer(".drawer-trigger", ".drawer");
    });
</script>

<script>
    // Get modal and close button
    const modal = document.getElementById("myModal");
    const closeBtn = document.querySelector(".close-auto");

    // Function to show modal after delay, only if not closed before
    window.onload = function () {
        const modalClosed = localStorage.getItem("modalClosed");

        // If not closed before, show after 3 seconds
        if (!modalClosed) {
            setTimeout(() => {
                modal.style.display = "flex";
            }, 3000);
        }
    };

    // Close modal on X click
    closeBtn.onclick = function () {
        modal.style.display = "none";
        localStorage.setItem("modalClosed", "true"); // remember closed
    };

    // Close modal if clicked outside
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
            localStorage.setItem("modalClosed", "true"); // remember closed
        }
    };
</script>


<script>
    $("#backBtn").on("click", function () {
        window.history.back();
    });
</script>


<!-- ✅ Chat Script -->
<script>
    $(function () {
        const $icon = $("#chatIcon");
        const $shell = $("#chatShell");
        const $body = $("#chatBody");
        const $input = $("#userInput");
        const $close = $("#closeBtn");

        // Open chat
        $icon.on("click", function () {
            $shell.fadeIn(300);
            if ($body.children().length === 0) {
                botMessage(
                    "👋 Hello there! I’m BLite Assistant. How can I help you today?<br><br>1️⃣ Explore meal plans<br>2️⃣ Order online<br>3️⃣ Talk to support"
                );
            }
        });

        // Close chat
        $close.on("click", function () {
            $shell.fadeOut(300);
        });

        // Send message
        $("#sendBtn").on("click", sendMessage);
        $input.on("keypress", function (e) {
            if (e.which === 13) sendMessage();
        });

        function sendMessage() {
            const text = $input.val().trim();
            if (!text) return;
            addMessage(text, "user");
            $input.val("");
            setTimeout(() => botMessage(autoReply(text)), 700);
        }

        function addMessage(text, type) {
            const msg = $("<div>").addClass("msg").addClass(type).html(text);
            $body.append(msg);

            // ✅ Smooth scroll fix
            setTimeout(() => {
                $body.stop().animate({ scrollTop: $body[0].scrollHeight }, 400);
            }, 100);
        }

        function botMessage(text) {
            addMessage(text, "bot");
        }

        // ✅ Fixed lowercase patterns
        function autoReply(t) {
            const text = t.toLowerCase();

            if (/hi|hello/.test(text))
                return "👋 Hi there! Welcome to BLite — where healthy meets delicious!";
            if (/2|Order online|online/.test(text))
                return "Great here is the link to order online: <a href='https://talentgate.in/live/creators/meal_plans.php' target='_blank'>https://blite.ae/</a> 🍽️💚";
            if (/3|Talk to support|support/.test(text))
                return "Great! you can reach our support team at <a href='mailto:customerservice@blite.ae' target='_blank'>here</a> or call us at <a href='tel:800-4387546' target='_blank'>800-4387546</a> 📞💚";

            if (/meal|plan|1|Explore meal plans|inquiry/.test(text))
                return `Great choice! 💚<br><br>We offer a variety of dietitian-approved meal plans:<br><br>
⚖️ <b>Shape Up</b> – Lose weight steadily with balanced meals.<br>
🥦 <b>Keto Byte</b> – Low-carb, high-fat dishes.<br>
💪 <b>Bulk Up</b> – High-protein meals for muscle gain.<br>
🌱 <b>V Lite</b> – 100% plant-based meals.<br>
💃 <b>EnergizeHER</b> – Designed for women to boost energy.<br>
💚 <b>Lite MED</b> – For medical conditions like diabetes or PCOS.<br>
🤰 <b>Fuel MUMZ</b> – Nutrient-packed meals for moms.<br>
🧒 <b>Lil TOTS</b> – Healthy meals for kids.<br>
🌿 <b>Healthy Lifestyle</b> – For overall wellness.<br><br>
Would you like me to help find the best plan for you? Or connect with our support team? say 'yes' to proceed.`;

            if (/yes|proceed/.test(text))
                return "Great! you can reach our support team at <a href='mailto:customerservice@blite.ae' target='_blank'>here</a> or call us at <a href='tel:800-4387546' target='_blank'>800-4387546</a> 📞💚";

            if (/consultation|dietitian/.test(text))
                return `Wonderful! Our licensed dietitians are here to guide you. Please share your goal 👇<br><br>
1️⃣ Weight loss<br>
2️⃣ Muscle gain<br>
3️⃣ Healthy lifestyle maintenance<br>
4️⃣ Medical-related diet (e.g., diabetes, PCOS)<br><br>
Once you select, we’ll book a quick call or chat with our dietitian.<br><br>
👉 Need help now? I can redirect you to customer service! say 'yes' to proceed.`;



            if (/existing customer|tracking/.test(text))
                return `Sure! Please share your registered phone number or order ID, and we’ll check your delivery or subscription details right away. 🚚<br><br>👉 Or connect with our support team for live updates!`;

            if (/offers|promotion/.test(text))
                return `You’re in luck! 💚<br><br>Get our <b>special 99 AED/full day offer</b> — 3 meals, 2 sides, 2 snacks, a consultation with a licensed dietitian, weekly follow-up, a free personal training session, and much more!<br><br>Would you like full details or to chat with a sales agent for quick assistance?`;

            if (/redirect|customer service/.test(text))
                return `I’ll connect you with our customer service team right away! 💚`;

            if (/goodbye|end chat/.test(text))
                return `Thanks for chatting with us 💚<br><br>Remember, wellness starts with what you eat.<br><b>✨ Eat Light. Live Bright. ✨</b>`;

            return "🤔 I’m not sure I understood that. Try typing 'menu' or 'help'.";
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const video = document.getElementById("heroVideo");
        if (video) {
            video.muted = true;
            video.play().catch(() => { });
        }
    });
</script>


<!-- after before -->
<script>
    $(function () {
    $(".ba-container").each(function () {
        const slider = $(this);
        const beforeImg = slider.find(".before");
        const handle = slider.find(".ba-handle");
        const afterLabel = slider.find(".after-label"); // after label
        const beforeLabel = slider.find(".before-label"); // optional, stays static

        let isDragging = false;
        let targetX = slider.width() / 2;
        let currentX = targetX;
        let direction = 1; // 1 = move right, -1 = move left

        // Smooth animation loop + auto-slide
        function animate() {
            // Auto slide only if not dragging
            if (!isDragging) {
                targetX += direction * 2; // speed
                if (targetX >= slider.width()) { direction = -1; }
                if (targetX <= 0) { direction = 1; }
            }

            currentX += (targetX - currentX) * 0.15;
            beforeImg.css("width", currentX + "px");
            handle.css("left", currentX + "px");

            // Show/hide After label depending on visibility
            const afterLabelOffset = 10; // distance from visible after image
            if (currentX < slider.width() - afterLabel.width() - afterLabelOffset) {
                afterLabel.css("opacity", 1).css("left", currentX + afterLabelOffset + "px");
            } else {
                afterLabel.css("opacity", 0);
            }

            requestAnimationFrame(animate);
        }
        animate();

        function updatePosition(e) {
            let pageX = e.pageX || e.originalEvent.touches[0].pageX;
            let offset = slider.offset().left;
            let width = slider.width();
            let pos = pageX - offset;

            if (pos < 0) pos = 0;
            if (pos > width) pos = width;

            targetX = pos;
        }

        handle.on("mousedown touchstart", () => { isDragging = true; });
        $(document).on("mouseup touchend", () => { isDragging = false; });
        $(document).on("mousemove touchmove", (e) => { if (isDragging) updatePosition(e); });
    });
});


</script>


</body>

</html>