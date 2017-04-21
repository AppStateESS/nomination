<script type="text/javascript">
    $(document).ready(function(){
        $(".tip").hide();

        $(".resend-email").click(function(){
            var id = $(this).attr('id');
            var recvr = $(this).attr('receiver');
            $.post('index.php', {'module':'nomination', 'action':'AdminResendEmail', 'id':id, 'ajax':true},
                   function(data){
                       if(data){
                           // TODO: Test in IE.
                           console.log(data);
                           //window.location.reload();
                           //alert('Email resent.');
                       }else{
                           alert('Email failed to resend.');
                       }
                   });
        });
    });
</script>

<h2>Email Log</h2>
<table class="table table-striped table-hover">
<tr>
  <th>{NOMINEE_LAST_NAME_SORT}</th>
  <th>To</th>
  <th>{RECEIVER_TYPE_SORT}</th>
  <th>{SENT_ON_SORT}</th>
  <th>{MESSAGE_TYPE_SORT}</th>
  <th>Action</th>
</tr>

<!-- BEGIN listrows -->
<tr>
  <td>{NOMINEE}</td>
  <td>{RECEIVER}</td>
  <td>{RECEIVER_TYPE}</td>
  <td>{SENT_ON}</td>
  <td>{MESSAGE_TYPE}</td>
  <td><button class="btn btn-sm btn-info view-email" src="{ACTION}" id="{ID}"><i class="fa fa-eye"></i></button>
    <button class="btn btn-sm btn-success resend-email" src="{RESEND}" id="{ID}"><i class="fa fa-envelope"></i></button></td>
</tr>
<!-- END listrows -->

<!-- BEGIN EMPTY_MESSAGE -->
<tr>
  <td colspan="2"><i>{EMPTY_MESSAGE}</i></td>
</tr>
<!-- END EMPTY_MESSAGE -->
</table>
<div align="center">
  <b>{PAGE_LABEL}</b><br />
  {PAGES}<br />
  {LIMITS}
</div>
<div id="dialog"></div>
