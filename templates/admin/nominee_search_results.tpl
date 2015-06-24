{CSV_REPORT}
<table class="table table-striped table-hover">
<tr>
  <th class="name-sort">Name <br />
    {FIRST_NAME_SORT} {MIDDLE_NAME_SORT} {LAST_NAME_SORT}
  </th>
  <th>Email
  </th>
</tr>
<!-- BEGIN listrows -->
<tr>
  <td>{NOMINEE_LINK}</td>
  <td> {EMAIL}@appstate.edu
  </td>
</tr>
<!-- END listrows -->
<!-- BEGIN EMPTY_MESSAGE -->
<tr>
  <td colspan="6"><i>{EMPTY_MESSAGE}</i></td>
</tr>
<!-- END EMPTY_MESSAGE -->
</table>

<div align="center">
<b>{PAGE_LABEL}</b><br />
{PAGES}<br />
{LIMITS}
</div>
