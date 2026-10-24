/**
 * admin_shared.js
 * Shared JS utilities for the admin panel.
 * Loaded globally via template.php — no per-view duplication needed.
 */

/* ===========================================================
   OFFCANVAS USER SIDEBAR
   =========================================================== */

function openUserSidebar(id) {
    var $sidebar = $('#userSidebar');
    var $body = $('#userSidebarBody');
    var $title = $('#userSidebarTitle');

    $title.text('User Details');
    $sidebar.addClass('open');

    $body.html(
        '<div class="text-center" style="margin-top:100px;">' +
            '<div class="preloader pl-size-xl">' +
                '<div class="spinner-layer pl-indigo">' +
                    '<div class="circle-clipper left"><div class="circle"></div></div>' +
                    '<div class="circle-clipper right"><div class="circle"></div></div>' +
                '</div>' +
            '</div>' +
            '<p style="margin-top:20px; color:#94a3b8; font-weight:500;">Fetching Details...</p>' +
        '</div>'
    );

    $.ajax({
        url: site_url + 'admin/users/quick_view/' + id,
        type: 'GET',
        success: function (data) {
            $body.html(data);
        },
        error: function () {
            $body.html('<p class="text-danger text-center" style="margin-top:100px;">Error fetching data.</p>');
        }
    });
}

function closeUserSidebar() {
    $('#userSidebar').removeClass('open');
}

/**
 * Open the offcanvas sidebar with arbitrary HTML content.
 * @param {string} title  - Header title
 * @param {string} html   - Content to inject
 */
function openOffcanvasSidebar(title, html) {
    var $sidebar = $('#userSidebar');
    $('#userSidebarTitle').text(title || 'Details');
    $('#userSidebarBody').html(html);
    $sidebar.addClass('open');
}


/* ===========================================================
   BUTTON LOADING STATE
   =========================================================== */

/**
 * Toggle a button into/out of a loading spinner state.
 * @param {jQuery} $btn      - The button element
 * @param {boolean} loading  - true to show spinner, false to restore
 * @param {string} [label]   - Optional text to show beside spinner
 */
function setButtonLoading($btn, loading, label) {
    if (loading) {
        $btn.data('original-html', $btn.html())
            .prop('disabled', true)
            .html(
                '<span class="dt-spinner" style="width:16px;height:16px;border-width:2px;display:inline-block;vertical-align:middle;margin-right:8px;"></span>' +
                (label || 'Processing...')
            );
    } else {
        $btn.prop('disabled', false).html($btn.data('original-html') || 'Submit');
    }
}


/* ===========================================================
   SWEETALERT CONFIRMATION WRAPPER
   =========================================================== */

/**
 * Show a confirmation dialog and execute a callback on confirm.
 * @param {object} opts
 * @param {string} opts.title       - Dialog title
 * @param {string} opts.text        - Dialog body text
 * @param {string} [opts.type]      - SweetAlert type (error, warning, info, success)
 * @param {string} [opts.confirmText] - Confirm button label
 * @param {string} [opts.cancelText]  - Cancel button label
 * @param {function} opts.onConfirm - Called when user confirms
 * @param {function} [opts.onCancel]  - Called when user cancels (optional)
 */
function confirmAction(opts) {
    swal({
        title: opts.title || 'Are you sure?',
        text: opts.text || '',
        type: opts.type || 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: opts.confirmText || 'Confirm',
        cancelButtonText: opts.cancelText || 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true,
        html: true,
        timer: opts.timer || 5000
    }, function (isConfirm) {
        if (isConfirm) {
            opts.onConfirm();
        } else {
            swal(
                opts.cancelTitle || 'Cancelled',
                opts.cancelMsg || 'Your data is safe.',
                'error'
            );
            if (typeof opts.onCancel === 'function') opts.onCancel();
        }
    });
}


/* ===========================================================
   CLIPBOARD HELPER
   =========================================================== */

function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function () {
            show_success('Copied to clipboard');
        });
    } else {
        var $tmp = $('<textarea>').val(text).appendTo('body').select();
        document.execCommand('copy');
        $tmp.remove();
        show_success('Copied to clipboard');
    }
}


/* ===========================================================
   TIME FORMATTING
   =========================================================== */

/**
 * Convert a 24-hour time string to 12-hour format.
 * @param {string} time - e.g. "14:30:00"
 * @returns {string} e.g. "2:30:00PM"
 */
function time24To12(time) {
    time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
    if (time.length > 1) {
        time = time.slice(1);
        time[5] = +time[0] < 12 ? 'AM' : 'PM';
        time[0] = +time[0] % 12 || 12;
    }
    return time.join('');
}


/* ===========================================================
   GLOBAL DATATABLE PROCESSING OVERLAY
   =========================================================== */

/**
 * Call this on any DataTable wrapper to show a centered loading overlay
 * while server-side processing is happening.
 * @param {string} wrapperSelector - e.g. '#table_wrapper'
 */
function enableDtLoader(wrapperSelector) {
    var $wrapper = $(wrapperSelector);
    if (!$wrapper.length) return;

    $wrapper.on('processing.dt', function (e, settings, processing) {
        if (processing) {
            $wrapper.addClass('is-processing');
        } else {
            $wrapper.removeClass('is-processing');
        }
    });
}


/* ===========================================================
   SEARCH STATUS HELPER
   =========================================================== */

/**
 * Bind a DataTable search input to show a live result count.
 * @param {string} inputSelector  - The search input selector
 * @param {string} tableId        - DataTable table ID (without #)
 * @param {string} statusSelector - Selector for the status element
 */
function bindSearchStatus(inputSelector, tableId, statusSelector) {
    var $input = $(inputSelector);
    var $status = $(statusSelector);
    var table = $('#' + tableId).DataTable();

    $input.on('keyup', function () {
        var val = $(this).val();
        var info = table.page.info();
        if (val.length > 0) {
            $status.html('Showing <strong>' + info.recordsDisplay + '</strong> results').fadeIn(200);
        } else {
            $status.fadeOut(200);
        }
    });
}
