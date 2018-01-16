function makeApproval() {
    
    var name = $('input[name="approvedName"]').val();
    var checked = $('input[name="approvedCheck"]').is(':checked');
    var id = $('input[name="estId"]').val();
    
    if (name.length < 2) {
        $('#approve_status').css('color','#400');
        $('#approve_status').text("You must provide a name for approval.");
    } else if (checked == false) {
        $('#approve_status').css('color','#400');
        $('#approve_status').text("You must check to authorize.");
    } else {
        
           var sendData = 'id=' + encodeURIComponent(id) + '&name=' + encodeURIComponent(name);
        
           $.ajax({
                type:'GET',
                url:'/estimates/app/ctl_sys.php',
                data: sendData,
                datatype: 'json',
                success: function(response) {
                    if(response.id) {
                        $('#approveForm').css('color','#040');
                        $('#approveForm').css('text-align','center');
                        $('#approveForm').css('font-size','22px');
                        $('#approveForm').css('padding-top','15px');
                        $('#approveForm').html('Job: ' + response.field_1 + ' has been approved by ' + response.field_156);
                    } else {
                        console.log(response);
                        $('#approve_status').css('color','#400');
                        if(response[0].FATAL_ERROR) {
                            $('#approve_status').html('ERROR ' + response[0].FATAL_ERROR);
                        } else {
                            $('#approve_status').html('ERROR updating record.');
                        }
                    }
                    
                    console.log(response);
                },
                error: function () {
                    $('#approve_status').css('color','#F00');
                    $('#approve_status').text('ERROR communicating with system.');
                }
            });
            return false;
        
        //$('#approve_status').css('color','#0F0');
        //$('#approve_status').text("Going to approve.");
    }
    
    //var id = $('input[verify="name"]').attr('id');
    
    console.log('Name: ' + name + ' - Checked: ' + checked + ' - Id: ' + id);
    
//                 Approver Name: <input type="text" name="approvedBy" /><br />
//                I authorize this estimate: <input type="checkbox" name="approveCheck" value="true" /><br />
//                <input class="ttp_hide" type="hidden" value="' . $estimate->id . '" name="estId" />
//                <button id="approve_btn" onclick="makeApproval()" type="button">Approve This Estimate</button><br />
//                <div id="approve_status"></div>   
    
//   $.ajax({
//      url:'myAjax.php',
//      complete: function (response) {
//          $('#output').html(response.responseText);
//      },
//      error: function () {
//          $('#output').html('Bummer: there was an error!');
//      }
//  });
//  return false;
}