<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<?php $can_edit_fee_type = $this->rbac->hasPrivilege('fees_type', 'can_edit'); ?>
<?php $create_search_due_fees_value = set_value('include_in_search_due_fees', '1'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('fees_type', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add_fees_type'); ?></h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo base_url() ?>admin/feetype"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php 
                                        echo $this->session->flashdata('msg'); 
                                        $this->session->unset_userdata('msg'); ?>
                                <?php } ?>
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <?php echo $this->customlib->getCSRF(); ?>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label> <small class="req">*</small>
                                    <input autofocus="" id="name" name="name" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('fees_code'); ?></label> <small class="req">*</small>
                                    <input id="code" name="code" type="text" class="form-control"  value="<?php echo set_value('code'); ?>" />
                                    <span class="text-danger"><?php echo form_error('code'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo set_value('description'); ?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="include_in_search_due_fees">Include in Search Due Fees</label> <small class="req">*</small>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <input type="hidden" name="include_in_search_due_fees" id="include_in_search_due_fees" value="<?php echo $create_search_due_fees_value; ?>">
                                        <div class="material-switch">
                                            <input id="include_in_search_due_fees_toggle" type="checkbox" class="form-search-due-fees-toggle" <?php if ((string) $create_search_due_fees_value === '1') { echo "checked='checked'"; } ?> />
                                            <label for="include_in_search_due_fees_toggle" class="label-info-success"></label>
                                        </div>
                                        <span id="include_in_search_due_fees_text"><?php echo ((string) $create_search_due_fees_value === '1') ? 'Selected' : 'Unselected'; ?></span>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('fees_type', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('fees_type_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('fees_type_list'); ?></div>
                        <div class="mailbox-messages table-responsive overflow-visible">
                            <table class="table table-striped table-bordered table-hover example"  data-export-title="<?php echo $this->lang->line('fees_type_list');?>">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('fees_code'); ?></th>
                                        <th>Search Due Fees</th>
                                        <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($feetypeList as $feetype) {
                                        ?>
                                        <tr>
                                            <?php $search_due_fees_value = (isset($feetype['include_in_search_due_fees']) && (int) $feetype['include_in_search_due_fees'] === 0) ? 0 : 1; ?>
                                            <td class="mailbox-name">
                                                <a href="#" data-toggle="popover" class="detail_popover"><?php echo $feetype['type'] ?></a>
                                                <div class="fee_detail_popover" style="display: none">
                                                    <?php
                                                    if ($feetype['description'] == "") {
                                                        ?>
                                                        <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <p class="text text-info"><?php echo $feetype['description']; ?></p>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $feetype['code']; ?>
                                            </td>
                                            <td class="mailbox-name">
                                                <div style="display:flex; align-items:center; gap:10px;">
                                                    <div class="material-switch">
                                                        <input id="search_due_fees_<?php echo $feetype['id']; ?>" type="checkbox" class="search-due-fees-toggle" data-feetype-id="<?php echo $feetype['id']; ?>" data-current-value="<?php echo $search_due_fees_value; ?>" <?php if ($search_due_fees_value == 1) { echo "checked='checked'"; } ?> <?php if (!$can_edit_fee_type) { echo "disabled"; } ?> />
                                                        <label for="search_due_fees_<?php echo $feetype['id']; ?>" class="label-info-success"></label>
                                                    </div>
                                                    <span id="search_due_fees_text_<?php echo $feetype['id']; ?>"><?php echo ($search_due_fees_value == 1) ? 'Selected' : 'Unselected'; ?></span>
                                                </div>
                                            </td>
                                            <td class="mailbox-date pull-right">
                                                <?php
                                                if ($this->rbac->hasPrivilege('fees_type', 'can_edit')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/feetype/edit/<?php echo $feetype['id'] ?>" class="btn btn-primary btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php } ?>
                                                <?php
                                                if ($this->rbac->hasPrivilege('fees_type', 'can_delete')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/feetype/delete/<?php echo $feetype['id'] ?>"class="btn btn-primary btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
        <div class="row">
            <!-- left column -->
            <!-- right column -->
            <div class="col-md-12">
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });

        syncSearchDueFeesFormToggle();
    });

    function syncSearchDueFeesFormToggle() {
        if (!$('#include_in_search_due_fees_toggle').length) {
            return;
        }
        var isChecked = $('#include_in_search_due_fees_toggle').is(':checked');
        $('#include_in_search_due_fees').val(isChecked ? 1 : 0);
        $('#include_in_search_due_fees_text').text(isChecked ? 'Selected' : 'Unselected');
    }

    $(document).on('change', '#include_in_search_due_fees_toggle', function () {
        syncSearchDueFeesFormToggle();
    });

    $(document).on('change', '.search-due-fees-toggle', function () {
        var $this = $(this);
        var previousValue = $this.attr('data-current-value');
        var currentValue = $this.is(':checked') ? '1' : '0';
        var toggleTextId = '#search_due_fees_text_' + $this.data('feetype-id');

        $this.prop('disabled', true);

        $.ajax({
            url: '<?php echo base_url(); ?>admin/feetype/changeSearchDueFeesStatus',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id: $this.data('feetype-id'),
                include_in_search_due_fees: currentValue
            },
            success: function (response) {
                if (response.status) {
                    $this.attr('data-current-value', currentValue);
                    $(toggleTextId).text(currentValue === '1' ? 'Selected' : 'Unselected');
                    if (typeof successMsg === 'function') {
                        successMsg(response.message);
                    }
                } else {
                    $this.prop('checked', previousValue === '1');
                    if (typeof errorMsg === 'function') {
                        errorMsg(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            },
            error: function () {
                $this.prop('checked', previousValue === '1');
                if (typeof errorMsg === 'function') {
                    errorMsg('Unable to update right now.');
                } else {
                    alert('Unable to update right now.');
                }
            },
            complete: function () {
                $this.prop('disabled', false);
            }
        });
    });
</script>
