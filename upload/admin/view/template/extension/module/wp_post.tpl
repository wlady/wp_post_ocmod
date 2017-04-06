<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-wp-post" data-toggle="tooltip" title="<?php echo $i18n['button_save']; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $links['cancel']; ?>" data-toggle="tooltip" title="<?php echo $i18n['button_cancel']; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $i18n['heading_title']; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (isset($i18n['text_error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $i18n['text_error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $i18n['text_edit']; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $links['action']; ?>" method="post" enctype="multipart/form-data" id="form-wp-post" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $i18n['tab_general']; ?></a></li>
            <li><a href="#tab-design" data-toggle="tab"><?php echo $i18n['tab_design']; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $i18n['entry_name']; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $i18n['entry_name']; ?>" id="input-name" class="form-control" />
                  <?php if (isset($i18n['text_error_name'])) { ?>
                  <div class="text-danger"><?php echo $i18n['text_error_name']; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-categories"><?php echo $i18n['entry_categories']; ?></label>
                <div class="col-sm-3">
                  <?php if (isset($categories)) { ?>
                  <?php foreach ($categories as $category_key => $category_name) { ?>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="categories[]" id="categories-type[<?php echo $category_key; ?>]" value="<?php echo $category_key; ?>"<?php echo (in_array($category_key, $cats)) ? " checked " : "" ?>>
                        <?php echo $category_name; ?>
                      </label>
                    </div>
                  <?php } ?>
                  <?php } else { ?>
                    <p class="text-danger"><?php echo $i18n['error_not_found']; ?></p>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort"><?php echo $i18n['entry_sort']; ?></label>
                <div class="col-sm-3">
                  <select name="sort" id="input-sort" class="form-control">
                    <option value="date" <?php if ($sort=='date') { echo 'selected="selected"'; } ?>><?php echo $i18n['text_date']; ?></option>
                    <option value="relevance" <?php if ($sort=='relevance') { echo 'selected="selected"'; } ?>><?php echo $i18n['text_relevance']; ?></option>
                    <option value="id" <?php if ($sort=='id') { echo 'selected="selected"'; } ?>><?php echo $i18n['text_id']; ?></option>
                    <option value="title" <?php if ($sort=='title') { echo 'selected="selected"'; } ?>><?php echo $i18n['text_title']; ?></option>
                    <option value="slug" <?php if ($sort=='slug') { echo 'selected="selected"'; } ?>><?php echo $i18n['text_slug']; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-order"><?php echo $i18n['entry_order']; ?></label>
                <div class="col-sm-3">
                  <select name="order" id="input-order" class="form-control">
                    <option value="asc" <?php if ($order=='asc') { echo 'selected="selected"'; } ?>><?php echo $i18n['text_asc']; ?></option>
                    <option value="desc" <?php if ($order=='desc') { echo 'selected="selected"'; } ?>><?php echo $i18n['text_desc']; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-limit"><?php echo $i18n['entry_limit']; ?></label>
                <div class="col-sm-3">
                  <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $i18n['entry_limit']; ?>" id="input-limit" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $i18n['entry_status']; ?></label>
                <div class="col-sm-3">
                  <select name="status" id="input-status" class="form-control">
                    <option value="1" <?php if ($status) { echo 'selected="selected"'; } ?>><?php echo $i18n['text_enabled']; ?></option>
                    <option value="0" <?php if (!$status) { echo 'selected="selected"'; } ?>><?php echo $i18n['text_disabled']; ?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-design">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-tpl"><?php echo $i18n['entry_template']; ?></label>
                <div class="col-sm-10">
                  <textarea name="tpl" id="input-tpl" class="form-control" rows="20"><?php echo $tpl; ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
