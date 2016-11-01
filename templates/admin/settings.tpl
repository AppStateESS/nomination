{START_FORM}
<h2>Admin Settings</h2>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>{AWARD_TITLE_LABEL}</label>
            {AWARD_TITLE}
        </div>

        <div class="form-group">
            <label>{NUM_REFERENCES_REQ_LABEL}:</label>
            {NUM_REFERENCES_REQ}
        </div>

        <div class="form-group">
            <label>{FILE_DIR_LABEL}</label>
            {FILE_DIR}
        </div>

        <label>Allowed File Types:</label>
        <!-- BEGIN allowed_file_types_repeat -->
        <div class="checkbox">
            <label>{ALLOWED_FILE_TYPES} {ALLOWED_FILE_TYPES_LABEL_TEXT}</label>
        </div>
        <!-- END allowed_file_types_repeat -->

        <div class="form-group">
            <label>{EMAIL_FROM_ADDRESS_LABEL}:</label>
            {EMAIL_FROM_ADDRESS}
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label>Nomination Form Fields:</label>

        <!-- BEGIN show_fields_repeat -->
        <div class="checkbox">
            <label>
              {SHOW_FIELDS} {SHOW_FIELDS_LABEL_TEXT}
            </label>
        </div>
        <!-- END show_fields_repeat -->
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-lg"> <i class="fa fa-save"></i> Update</button>
        </div>
    </div>
</div>

{END_FORM}
