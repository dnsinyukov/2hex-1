$(document).ready(function(){

  var value = 0;
  var perdeck = 0;
  var quantity = 0;
  $('input[type="file"]').click(function(e){
    if($('body').attr('signed') == 0){
       e.stopPropagation();
       e.preventDefault();
        swal({
            title: "",
            text: "You need to login to upload file",
            type: "alert",
            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
        }).then((value) => {
            
        });
    }
  });
  $('input[type="file"]').change(function(){
      var formData = new FormData();
      
      
      if($(this).attr('filename') == "" && $(this).attr('id') != "engraveryFile" && $(this).attr('id') != "cardboardFile")
        app.total += 120;
      else if($(this).attr('filename') == "" && $(this).attr('id') == "engraveryFile")
        app.total += 80;
      else if($(this).attr('filename') == "" && $(this).attr('id') == "cardboardFile")
        app.total += 500;
      formData.append('file', $(this)[0].files[0]);
      self = this;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
             url : 'configurator-fileupload',
             type : 'POST',
             data : formData,
             processData: false,  // tell jQuery not to process the data
             contentType: false,  // tell jQuery not to set contentType
             success : function(data) {
                 if(data != 'failed')
                    $(self).attr('filename','data');
             }
      });  

      
  });

  $('#save_address').click(function(){
    var formData = new FormData();

    formData.append('invoice_company',$('#invoice_company').val());
    formData.append('invoice_name',$('#invoice_name').val());
    formData.append('invoice_country',$('#invoice_country').val());
    formData.append('invoice_taxid',$('#invoice_taxid').val());
    formData.append('shipping_company',$('#shipping_company').val());
    formData.append('shipping_address',$('#shipping_address').val());
    formData.append('shipping_city',$('#shipping_city').val());
    formData.append('shipping_state',$('#shipping_state').val());
    formData.append('shipping_postcode',$('#shipping_postcode').val());
    formData.append('shipping_contactperson',$('#shipping_contactperson').val());
    formData.append('shipping_phone',$('#shipping_phone').val());
    formData.append('shipping_country',$('#shipping_country').val());

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
           url : 'address_save',
           type : 'POST',
           data : formData,
           processData: false,  // tell jQuery not to process the data
           contentType: false,  // tell jQuery not to set contentType
           success : function(data) {
              window.location.href = "../summary"
               
           }
    });

  });



});
  
