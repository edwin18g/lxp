$(function () {
    "use strict";

    // Ajax form submit with validation errors
    var post_flag = 1;
    $('form#form-create').on('submit', function (e) {
        e.preventDefault();

        if (post_flag == 1) {
            post_flag = 0;

            $('.form-line').removeClass('error');

            var formData = new FormData($(this)[0]);
            ajaxPostMultiPart('save', '#submit_loader', formData, function (response) {
                if (response.flag == 0) {
                    swal("Oops!", response.msg, "error");

                    if (response.error_fields) {
                        $.each(JSON.parse(response.error_fields), (index, item) => {
                            $("input[name*='" + item + "'], select[name*='" + item + "'], textarea[name*='" + item + "']").closest('.form-line').addClass('error');
                        });
                    }

                    post_flag = 1;
                } else {
                    swal("Success!", response.msg, "success");
                    setTimeout(function () {
                        window.location.href = site_url + uri_seg_1 + '/' + uri_seg_2;
                    }, 1000);
                }
            });
        }
        return false;
    });
});
