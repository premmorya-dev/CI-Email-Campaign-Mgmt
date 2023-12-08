<div class="row" style="background-color:white;">

<div class="col-md-9"  id="list" >
   <?php echo $list; ?>
</div>
   <div class="col-md-3">

      <div class="card">
         <div class="card-body">
            <h3 class="filter-title">Filter</h3>
            <form id="filter">
               <div>
                  <div class="mb-4">
                     <label for="validationCustom01" class="form-label">Room No.</label>
                     <input type="text" class="form-control" id="validationCustom01" placeholder="Room No."
                        name="filter_room_no" value="" required="">
                  </div>
                  <div class="mb-4">
                     <label for="validationCustom01" class="form-label">Room Name</label>
                     <input type="text" class="form-control" id="validationCustom01" placeholder="Room Name"
                        name="filter_room_name" value="" required="">
                  </div>
                  <div class="mb-4">
                     <label for="validationCustom01" class="form-label">Tenent Name</label>
                     <input type="text" class="form-control" id="validationCustom01" placeholder="Tenent Name"
                        name="filter_tenent_name" value="" required="">
                  </div>
               </div>
               <button type="submit" id="filter-form"
                  class="btn btn-primary waves-effect waves-light me-1 filter-button">
                  <i class="fa fa-filter" aria-hidden="true"></i> Filter
               </button>
            </form>
         </div>


      </div>
   </div>

</div>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script type="text/javascript">

   <?php if ($this->session->flashdata('success')) { ?>
      toastr.success("<?php echo $this->session->flashdata('success'); ?>");
   <?php } else if ($this->session->flashdata('error')) { ?>
         toastr.error("<?php echo $this->session->flashdata('error'); ?>");
   <?php } else if ($this->session->flashdata('warning')) { ?>
            toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
   <?php } else if ($this->session->flashdata('info')) { ?>
               toastr.info("<?php echo $this->session->flashdata('info'); ?>");
   <?php } ?>

</script>


<script type="text/javascript">

   $('#filter-form').on('click', function (e) {
      e.preventDefault();
      var baseurl = '<?php echo base_url(); ?>';
      var from_url = baseurl + 'Room/list/';

      $.ajax({

         url: from_url,
         data: new FormData(document.querySelector('#filter')),
         dataType: 'html',
         processData: false,
         contentType: false,
         type: 'POST',
         beforeSend(xhr) {


         },
         success: function (result) {
            console.log(result);
            $('#list').html(result);

         }
      });


   });





</script>