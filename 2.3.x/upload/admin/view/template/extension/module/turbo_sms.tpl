<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-order-sms" data-toggle="tooltip" title="<?php echo $button_save; ?>}" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-turbo-sms" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-token"><?php echo $entry_token; ?></label>
            <div class="col-sm-10">
              <input name="turbo_sms_token" value="<?php echo $turbo_sms_token; ?>" placeholder="<?php echo $entry_token; ?>" id="input-token" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sender"><?php echo $entry_sender; ?></label>
            <div class="col-sm-10">
              <input name="turbo_sms_sender" value="<?php echo $turbo_sms_sender; ?>" placeholder="<?php echo $entry_sender; ?>" id="input-sender" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <div class="alert alert-info"><i class="fa fa-info-circle"></i>
                <?php echo $text_info; ?>
                <?php echo $text_shortcode_list; ?>
              </div>

            </div>

            <label class="col-sm-2 control-label" for="input-message"><?php echo $entry_message; ?></label>
            <div class="col-sm-10">
              <input name="turbo_sms_message" value="<?php echo $turbo_sms_message; ?>" placeholder="<?php echo $entry_message; ?>" id="input-message" class="form-control" />
              <?php if ($error_message) { ?>
                <div class="text-danger"><?php echo $error_message; ?></div>
              <?php } ?>

            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="turbo_sms_status" id="input-status" class="form-control">
                <?php if ($turbo_sms_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>

              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
