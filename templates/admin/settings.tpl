{START_FORM}
<h2>Admin Settings</h2>

<div class="col-md-12">
  <div class="row">
    <label>
      {AWARD_TITLE_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-5">
      {AWARD_TITLE}
    </div>
  </div>

  <div class="row">
    <label>
      {NUM_REFERENCES_REQ_LABEL}:
    </label>
  </div>
  <div class="row">
    <div class="col-md-5">
      {NUM_REFERENCES_REQ}
    </div>
  </div>

  <div class="row">
    <label>
      {FILE_DIR_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-7">
      {FILE_DIR}
    </div>
  </div>

  <div class="row">
    <label>
      Allowed File Types:
    </label>
    <!-- BEGIN allowed_file_types_repeat -->
    <div class="checkbox">
      <label>
        {ALLOWED_FILE_TYPES}{ALLOWED_FILE_TYPES_LABEL}
      </label>
    </div>
    <!-- END allowed_file_types_repeat -->
  </div>

  <div class="row">
    <label>
      {EMAIL_FROM_ADDRESS_LABEL}:
    </label>
  </div>
  <div class="row">
    <div class="col-md-5">
      {EMAIL_FROM_ADDRESS}
    </div>
  </div>

  <div class="row">
    <label>
      Show Fields:
    </label>
    <div class="checkbox">
    <!-- BEGIN show_fields_repeat -->
      <div class="col-md-6">
        <label>
          {SHOW_FIELDS} {SHOW_FIELDS_LABEL}
        </label>
      </div>
    <!-- END show_fields_repeat -->
    </div>
  </div>

  <p></p>

  <div class="row">
    <button type="submit" class="btn btn-success btn-lg">
      <i class="fa fa-save"></i>
      Update
    </buttons>
  </div>
</div>

{END_FORM}
