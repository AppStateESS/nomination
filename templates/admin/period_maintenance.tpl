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

<h3>Period Settings</h3>
<h4>Current period is: <strong>{CURRENT_PERIOD_YEAR}</strong>.</h4>

<div id="dialog" title="Start/End Date">
  <ul>
    <li>Nominations will be accepted starting at 12:00am (midnight) on the selected start date.</li>
    <li>Nominations will no longer be accepted starting at 12:00am (midnight) on the selected end date.</li>
  </ul>
</div>

{START_FORM}

<div class="col-md-12">

  <div class="row">
    {NOMINATION_PERIOD_START_LABEL}
    {NOMINATION_PERIOD_START}
  </div>

  <div class="row">
    {NOMINATION_PERIOD_END_LABEL}
    {NOMINATION_PERIOD_END}
  </div>

  <h5>
    Rollover
  </h5>

  <p>
    <!-- BEGIN next_period -->
      Next period is {NEXT_PERIOD} {ROLLOVER_LINK}
    <!-- END next_period -->
  </p>

  <div class="row">
    {ROLLOVER_EMAIL_LABEL}
    {ROLLOVER_EMAIL}
  </div>

  <p></p>

  <div class="row">
    <button type="submit" class="btn btn-lg btn-success">
      <i class="fa fa-calendar"></i>
      Update Period
    </button>
  </div>
</div>

{END_FORM}
