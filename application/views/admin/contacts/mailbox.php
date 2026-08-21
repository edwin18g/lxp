<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* Mailbox View */
?>



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