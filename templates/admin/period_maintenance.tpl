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
    <label>
      {NOMINATION_PERIOD_START_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-5">
      {NOMINATION_PERIOD_START}
    </div>
  </div>

  <div class="row">
    <label>
      {NOMINATION_PERIOD_END_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-5">
      {NOMINATION_PERIOD_END}
    </div>
  </div>

  <div class="row">
    <label>
      Rollover
    </label>
  </div>
  <div class="row">
    <p class="col-md-6">
      <!-- BEGIN next_period -->
        Next period is {NEXT_PERIOD} {ROLLOVER_LINK}
      <!-- END next_period -->
    </p>
  </div>

  <div class="row">
    <label>
      {ROLLOVER_EMAIL_LABEL}
    </label>
  </div>
  <div class="row">
    <div class="col-md-5">
      {ROLLOVER_EMAIL}
    </div>
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
