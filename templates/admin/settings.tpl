{START_FORM}
<h2>Admin Settings</h2>
<div class="form-group">
  <label>{AWARD_TITLE_LABEL}</label>
  {AWARD_TITLE}
</div>
<div class="form-group">
  <label>{AWARD_DESCRIPTION_LABEL}</label>
  {AWARD_DESCRIPTION}
</div>
<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <label>{NUM_REFERENCES_REQ_LABEL}:</label>
      {NUM_REFERENCES_REQ}
    </div>
  </div>
  <div class="col-sm-8">
    <div class="form-group">
      <label>{FILE_DIR_LABEL}</label>
      {FILE_DIR}
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-5">
    <label>Allowed File Types:</label><br />
    <!-- BEGIN allowed_file_types_repeat -->
    <label>{ALLOWED_FILE_TYPES} {ALLOWED_FILE_TYPES_LABEL_TEXT}</label><br />
    <!-- END allowed_file_types_repeat -->
  </div>
  <div class="col-sm-7">
    <div class="form-group">
      <label>{EMAIL_FROM_ADDRESS_LABEL}:</label>
      {EMAIL_FROM_ADDRESS}
    </div>
    <div class="form-group">
      <label>{SIGNATURE_TITLE_LABEL}</label>
      {SIGNATURE_TITLE}
    </div>
    <div class="form-group">
      <label>{SIG_POSITION_LABEL}</label>
      {SIG_POSITION}
    </div>
  </div>
</div>
<label>Nomination Form Fields:</label>
<!-- BEGIN show_fields_repeat -->
<div class="checkbox">
  <label>
    {SHOW_FIELDS} {SHOW_FIELDS_LABEL_TEXT}
  </label>
</div>
<!-- END show_fields_repeat -->
<div class="form-group">
  <button type="submit" class="btn btn-success btn-lg">
    <i class="fa fa-save"></i>
    Update</button>
</div>
{END_FORM}
