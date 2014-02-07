{START_FORM}
<h1>Admin Settings</h1>
<table>
  <tr>
    <td>{AWARD_TITLE_LABEL}</td>
    <td>{AWARD_TITLE}</td>
  </tr>
  
  <tr>
    <td>{NUM_REFERENCES_REQ_LABEL}:</td>
    <td>{NUM_REFERENCES_REQ}</td>
  </tr>
  
  <tr>
    <td>{FILE_DIR_LABEL}</td>
    <td>{FILE_DIR}</td>
  </tr>
  <tr>
    <td>Allowed File Types:</td>
    <td>
      <!-- BEGIN allowed_file_types_repeat -->
      {ALLOWED_FILE_TYPES}{ALLOWED_FILE_TYPES_LABEL}<br />
      <!-- END allowed_file_types_repeat -->
    </td>
  </tr>
  
  <tr>
    <td>{EMAIL_FROM_ADDRESS_LABEL}:</td>
    <td>{EMAIL_FROM_ADDRESS}</td>
  </tr>

  <tr>
    <td>Show Fields:</td>
    <td>
      <!-- BEGIN show_fields_repeat -->
      {SHOW_FIELDS} {SHOW_FIELDS_LABEL}<br />
      <!-- END show_fields_repeat -->
    </td>
  </tr>
</table>
{SUBMIT}
{END_FORM}
