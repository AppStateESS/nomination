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

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="{NOMINATION_PERIOD_START_ID}">{NOMINATION_PERIOD_START_LABEL}</label>
            {NOMINATION_PERIOD_START}
        </div>

        <div class="form-group">
            <label for="{NOMINATION_PERIOD_END_ID}">{NOMINATION_PERIOD_END_LABEL}</label>
            {NOMINATION_PERIOD_END}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success">
              <i class="fa fa-calendar"></i>
              Update Period
            </button>
        </div>

    </div>
    <div class="col-md-3 col-md-push-4">
        <h4>Roll-over</h4>
        <!-- BEGIN next_period -->
        <p>
            Next period is {NEXT_PERIOD} {ROLLOVER_LINK}
        </p>
        <p>
            <a href="{ROLLOVER_URI}" class="btn btn-danger">Roll-over Now to {NEXT_PERIOD}</a>
        </p>
        <!-- END next_period -->
    </div>
</div>

{END_FORM}
