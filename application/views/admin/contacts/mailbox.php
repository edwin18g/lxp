<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Mailbox View */
?>

<style>
    /* Mailbox Styles */
    .mailbox-wrapper {
        display: flex;
        background: transparent;
        min-height: 600px;
    }

    .mailbox-sidebar {
        width: 250px;
        border-right: 1px solid #eee;
        padding: 20px;
        background: #fff;
        flex-shrink: 0;
    }

    .mailbox-content {
        flex: 1;
        padding: 0;
        background: #fff;
        min-width: 0;
        /* Fix flex child overflow */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .mailbox-wrapper {
            flex-direction: column;
        }

        .mailbox-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #eee;
            height: auto;
        }
    }

    .compose-btn-wrapper {
        margin-bottom: 20px;
    }

    .folder-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .folder-list li {
        margin-bottom: 5px;
    }

    .folder-list li a {
        display: block;
        padding: 10px 15px;
        color: #555;
        border-radius: 4px;
        transition: background 0.2s;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .folder-list li.active a,
    .folder-list li a:hover {
        background: #f4f6f8;
        color: #333;
        font-weight: 500;
    }

    .folder-list li a i {
        margin-right: 15px;
        font-size: 20px;
        color: #777;
    }

    .folder-list .badge {
        margin-left: auto;
    }

    /* Email List */
    .mailbox-toolbar {
        padding: 15px 20px;
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .email-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .email-item {
        display: flex;
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: all 0.2s;
        align-items: center;
        background: #fff;
    }

    .email-item:hover {
        background: #fcfcfc;
        box-shadow: inset 2px 0 0 #03A9F4;
        /* Using theme blue */
        z-index: 1;
        position: relative;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .email-item.unread {
        background: #fff;
        font-weight: 600;
        color: #222;
    }

    .email-item.read {
        background: #fbfbfb;
        color: #666;
    }

    .email-checkbox {
        width: 40px;
        padding-top: 5px;
        /* Alignment fix */
    }

    .email-star {
        width: 35px;
        color: #e0e0e0;
        padding-top: 2px;
    }

    .email-star.starred {
        color: #fdd835;
    }

    .email-sender {
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 20px;
        font-size: 14px;
    }

    .email-subject {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 20px;
        font-size: 14px;
    }

    .email-snippet {
        color: #999;
        font-weight: normal;
        font-size: 13px;
    }

    .email-date {
        width: 100px;
        text-align: right;
        font-size: 12px;
        color: #999;
        white-space: nowrap;
    }

    .modal-full-height .modal-dialog {
        height: 90%;
        margin-top: 2.5%;
    }

    .modal-full-height .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .email-actions {
        display: none;
        margin-left: auto;
    }

    .email-item:hover .email-actions {
        display: block;
    }

    .email-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #555;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
        font-size: 14px;
    }

    /* Random colors for avatars (using nth-child for simplicity) */
    .email-item:nth-child(4n+1) .email-avatar {
        background-color: #FFEBEE;
        color: #D32F2F;
    }

    .email-item:nth-child(4n+2) .email-avatar {
        background-color: #E3F2FD;
        color: #1976D2;
    }

    .email-item:nth-child(4n+3) .email-avatar {
        background-color: #E8F5E9;
        color: #388E3C;
    }

    .email-item:nth-child(4n+4) .email-avatar {
        background-color: #FFF3E0;
        color: #F57C00;
    }
</style>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    <?php echo lang('menu_contacts'); ?>
                    <small>Manage your messages</small>
                </h2>
            </div>
            <div class="body" style="padding: 0;">

                <div class="mailbox-wrapper">
                    <!-- Sidebar -->
                    <div class="mailbox-sidebar">
                        <ul class="folder-list">
                            <li class="active">
                                <a href="<?php echo site_url('admin/contacts'); ?>">
                                    <i class="material-icons">inbox</i> Inbox
                                    <?php if (isset($unread_count) && $unread_count > 0): ?>
                                        <span class="badge bg-red">
                                            <?php echo $unread_count; ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Content -->
                    <div class="mailbox-content">
                        <!-- Toolbar -->
                        <div class="mailbox-toolbar">
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-default btn-circle waves-effect waves-circle waves-float"
                                    data-toggle="tooltip" title="Refresh" onclick="location.reload();">
                                    <i class="material-icons">refresh</i>
                                </button>
                            </div>

                            <!-- Search -->
                            <div class="input-group" style="width: 300px; margin-left: auto; margin-bottom: 0;">
                                <div class="form-line">
                                    <input type="text" id="emailSearch" class="form-control"
                                        placeholder="Search mail...">
                                </div>
                                <span class="input-group-addon">
                                    <i class="material-icons">search</i>
                                </span>
                            </div>
                        </div>

                        <!-- Email List -->
                        <ul class="email-list" id="emailList">
                            <?php if (!empty($emails)): ?>
                                <?php foreach ($emails as $email):
                                    $is_unread = empty($email['read']);
                                    $row_class = $is_unread ? 'unread' : 'read';
                                    $initial = mb_substr($email['name'], 0, 1) ?: '?';
                                    ?>
                                    <li class="email-item <?php echo $row_class; ?>"
                                        onclick="openEmailModal(<?php echo $email['id']; ?>)">

                                        <div class="email-avatar">
                                            <?php echo strtoupper($initial); ?>
                                        </div>

                                        <div class="email-sender">
                                            <?php echo html_escape($email['name']); ?>
                                        </div>
                                        <div class="email-subject">
                                            <?php echo html_escape($email['title']); ?>
                                            <span class="email-snippet"> -
                                                <?php echo html_escape(substr(strip_tags($email['message']), 0, 50)) . '...'; ?>
                                            </span>
                                        </div>



                                        <div class="email-date">
                                            <?php
                                            // Format date: if today, show time; otherwise show date
                                            $created = strtotime($email['created']);
                                            if (date('Y-m-d') == date('Y-m-d', $created)) {
                                                echo date('g:i A', $created);
                                            } else {
                                                echo date('M j', $created);
                                            }
                                            ?>
                                        </div>
                                    </li>

                                    <!-- Modal for this email -->
                                    <div class="modal fade" id="modal-email-<?php echo $email['id']; ?>" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="defaultModalLabel">
                                                        <?php echo html_escape($email['title']); ?>
                                                    </h4>
                                                    <small>From:
                                                        <?php echo html_escape($email['name']); ?> &lt;
                                                        <?php echo html_escape($email['email']); ?>&gt;
                                                    </small><br>
                                                    <small>Date:
                                                        <?php echo date('F j, Y, g:i a', $created); ?>
                                                    </small>
                                                </div>
                                                <div class="modal-body">
                                                    <div
                                                        style="white-space: pre-wrap; font-family: sans-serif; font-size: 14px; line-height: 1.6;">
                                                        <?php echo nl2br(html_escape($email['message'])); ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="mailto:<?php echo html_escape($email['email']); ?>"
                                                        class="btn btn-primary waves-effect">REPLY</a>
                                                    <button type="button" class="btn btn-link waves-effect"
                                                        data-dismiss="modal">CLOSE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="email-item" style="justify-content: center; padding: 40px;">
                                    <div class="text-center text-muted">
                                        <i class="material-icons" style="font-size: 48px;">inbox</i><br>
                                        No messages found
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <!-- Simple Pagination (if needed later) -->
                        <div
                            style="padding: 10px 20px; text-align: right; background: #fdfdfd; border-top: 1px solid #eee; color: #777;">
                            Showing
                            <?php echo count($emails ?? []); ?> latest messages
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script>
    function openEmailModal(id) {
        var modalId = '#modal-email-' + id;
        $(modalId).modal('show');

        // Mark as read via AJAX if needed
        var row = $('li.email-item[onclick="openEmailModal(' + id + ')"]');
        if (row.hasClass('unread')) {
            // Call controller to mark read
            $.ajax({
                url: '<?php echo site_url("admin/contacts/read/"); ?>' + id,
                type: 'GET',
                success: function (response) {
                    row.removeClass('unread').addClass('read');
                    // update badge count if implementation allows
                }
            });
        }
    }

    $(document).ready(function () {

        // Search Filter
        $('#emailSearch').on('keyup', function () {
            var value = $(this).val().toLowerCase();
            $("#emailList li.email-item").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>