<?php
$CI =& get_instance();
$settings = $CI->settings;
if (isset($settings->promo_modal_enabled) && $settings->promo_modal_enabled == 1):
    ?>
    <!-- Promotion Modal -->
    <div id="promoModal" class="modal fade" role="dialog" style="z-index: 100000;">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header relative">
                    <button type="button" class="close" data-dismiss="modal" onclick="dismissPromo()"
                        style="position: absolute; right: 20px; top: 15px; font-size: 28px; z-index: 10;">&times;</button>
                    <h4 class="modal-title text-center font-weight-bold" style="padding-top: 10px; color: #333;">
                        <?php echo isset($settings->promo_modal_title) ? $settings->promo_modal_title : 'Special Offer'; ?>
                    </h4>
                </div>
                <div class="modal-body text-center" style="padding: 20px 30px;">
                    <?php if (isset($settings->promo_modal_image) && !empty($settings->promo_modal_image)): ?>
                        <img src="<?php echo base_url('upload/home/' . $settings->promo_modal_image); ?>"
                            class="img-responsive center-block"
                            style="margin-bottom: 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%;">
                    <?php endif; ?>
                    <p style="font-size: 16px; color: #555; line-height: 1.6; margin-bottom: 10px;">
                        <?php echo isset($settings->promo_modal_content) ? nl2br($settings->promo_modal_content) : ''; ?>
                    </p>
                </div>
                <div class="modal-footer text-center" style="text-align: center; border-top: none; padding-bottom: 35px;">
                    <?php if (isset($settings->promo_modal_btn_text) && !empty($settings->promo_modal_btn_text)): ?>
                        <a href="<?php echo isset($settings->promo_modal_btn_url) ? $settings->promo_modal_btn_url : '#'; ?>"
                            class="btn btn-promo" onclick="dismissPromo()">
                            <?php echo $settings->promo_modal_btn_text; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        #promoModal .modal-content {
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .btn-promo {
            background: linear-gradient(90deg, #0056d2, #1f6ce6);
            color: white !important;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            border: none;
            box-shadow: 0 4px 14px 0 rgba(0, 118, 255, 0.39);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-promo:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 118, 255, 0.23);
            color: white;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Wait for jQuery
            var checkJqueryPromise = new Promise(function (resolve, reject) {
                var count = 0;
                var checkJquery = setInterval(function () {
                    if (window.jQuery) {
                        clearInterval(checkJquery);
                        resolve();
                    }
                    if (count > 100) { // Timeout 10s
                        clearInterval(checkJquery);
                        resolve(); // Try anyway
                    }
                    count++;
                }, 100);
            });

            checkJqueryPromise.then(function () {
                var storageKey = 'promo_modal_dismissed_<?php echo md5(isset($settings->promo_modal_title) ? $settings->promo_modal_title : ""); ?>';

                // Show modal if not dismissed
                if (!localStorage.getItem(storageKey)) {
                    setTimeout(function () {
                        jQuery('#promoModal').modal('show');
                    }, 1000);
                }

                window.dismissPromo = function () {
                    localStorage.setItem(storageKey, 'true');
                };
            });
        });
    </script>
<?php endif; ?>