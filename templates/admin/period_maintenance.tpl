<script type="text/javascript">
    $(document).ready(function(){
        $("#dialog").hide();
        $("#{START_DATE_ID}").datepicker();
        $("#{END_DATE_ID}").datepicker();
        $(".help-icon").click(function(){
            $("#dialog").dialog();

        });
    });
</script>

<h2>Period Settings</h2>
<h3>Current period is: <strong>{CURRENT_PERIOD_YEAR}</strong>.</h3>

<div id="dialog" title="Start/End Date">
  <ul>
    <li>Nominations will be accepted starting at 12:00am (midnight) on the selected start date.</li>
    <li>Nominations will no longer be accepted starting at 12:00am (midnight) on the selected end date.</li>
  </ul>
</div>

{START_FORM}
<table>
  <tr>
    <th>{NOMINATION_PERIOD_START_LABEL}</th>
    <td>{NOMINATION_PERIOD_START}</td>
    <td rowspan="2"><img class="help-icon" src="{HELP_ICON}"></td>
  </tr>

  <tr>
    <th>{NOMINATION_PERIOD_END_LABEL}</th>
    <td>{NOMINATION_PERIOD_END}</td>
  </tr>

  <tr>
    <th>Rollover</th>
    <td>
        <!-- BEGIN next_period -->
        Next period is {NEXT_PERIOD} {ROLLOVER_LINK}
        <!-- END next_period -->
    </td>
  </tr>

  <tr>
    <th>{ROLLOVER_EMAIL_LABEL}</th>
    <td>{ROLLOVER_EMAIL}</td>
  </tr>
</table>
{SUBMIT}
{END_FORM}
