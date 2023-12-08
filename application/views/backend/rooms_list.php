
      <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
         style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid"
         aria-describedby="datatable_info">
         <thead>
            <tr role="row">
               <th class="sorting_desc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                  style="width: 189px;" aria-label="Name: activate to sort column ascending" aria-sort="descending">Room
                  No. </th>
               <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 286px;"
                  aria-label="Position: activate to sort column ascending">Room Name</th>
               <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 137px;"
                  aria-label="Office: activate to sort column ascending">Tenent Name</th>
               <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                  style="width: 137px;" aria-label="Office: activate to sort column ascending">Action</th>

            </tr>
         </thead>
         <tbody>

            <?php foreach ($rooms as $room) { ?>
               <tr class="odd">
                  <td class="dtr-control sorting_1" tabindex="0">
                     <?php echo $room['room_no']; ?>
                  </td>
                  <td class="dtr-control sorting_1" tabindex="0">
                     <?php echo $room['room_name']; ?>
                  </td>
                  <td class="dtr-control sorting_1" tabindex="0">
                     <?php echo $room['tenent_name']; ?>
                  </td>

                  <td class="text-center">
                     <a href="<?php echo $room['edit']; ?>" class="p-2"><i class="fa fa-edit" aria-hidden="true"
                           style="font-size: 15px;"></i></a>
                     <a href="<?php echo $room['delete']; ?>" room_no="<?php echo $room['room_no']; ?>"
                        class="p-2 delete"><i class="fa fa-trash" aria-hidden="true"
                           style="font-size: 15px; color:red;"></i></a>
                  </td>

               </tr>
            <?php } ?>


         </tbody>
      </table>

      <div class="clearfix">


         <div id="pagination">
            <?php echo $pagination; ?>
         </div>
         <?php echo $result ?>

      </div>


   



<script type="text/javascript">

$('.page-link').on('click', function (e) {
   e.preventDefault();

console.log( $(this).attr('data-ci-pagination-page'))
      var baseurl = '<?php echo base_url(); ?>';
      var from_url = baseurl + 'Room/list/';
         $.ajax({

         url: from_url+ $(this).attr('data-ci-pagination-page'),
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
   $('.delete').on('click', function (e) {
      e.preventDefault();
      var id = $(this).attr('room_no');
      var baseurl = '<?php echo base_url(); ?>';
      var from_url = baseurl + 'room/delete';

      $.ajax({

         url: from_url,
         data: { room_no: id },
         dataType: 'json',
         type: 'POST',
         beforeSend(xhr) {


         },
         success: function (result) {
            console.log(result);
            location.reload();

         }
      });


   });



</script>