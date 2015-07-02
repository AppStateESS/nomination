<h2>{TITLE}</h2>

{START_FORM}

<div class="row">
  <div class="col-md-6">
    {QUERY}
  </div>
</div>

<p></p>

<div class="row">
  <div class="col-md-4">
    {SUBMIT}
  </div>
</div>

{END_FORM}

<p></p>

<div id="pager">
{PAGER}
</div>
<script type="text/javascript">
$(document).ready(function(){
    var s = new Reloader($("#search"), $("#pager"));
});
</script>
