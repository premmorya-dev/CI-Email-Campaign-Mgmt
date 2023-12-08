<form id="add_room" enctype="multipart/form-data">
<div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Room No.</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="room_no" value = "<?php echo isset($room['room_no']) ? $room['room_no'] : '' ?> " type="text" placeholder="Room No." id="example-text-input">
                                                <div id="error-room_no"></div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Room Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="room_name" value = "<?php echo isset($room['room_name']) ? $room['room_name'] : '' ?> " placeholder="Room Name" id="example-text-input">
                                                <div id="error-room_name"></div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Tenent Name</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text"  name="tenent_name" value = "<?php echo isset($room['tenent_name']) ? $room['tenent_name'] : '' ?> " placeholder="Tenent Name" id="example-text-input">
                                                <div id="error-tenent_name"></div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="address" value = "<?php echo isset($room['address']) ? $room['address'] : '' ?> "placeholder="Address" id="example-text-input">
                                                <div id="error-address"></div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-tel-input" class="col-sm-2 col-form-label">Telephone</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="tel" name="telephone" value = "<?php echo isset($room['telephone']) ? $room['telephone'] : '' ?> " placeholder="1-(555)-555-5555" id="example-tel-input">
                                                <div id="error-telephone"></div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="row mb-3">
                                            <label for="example-password-input" class="col-sm-2 col-form-label">Image</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="file" name="image" value = "<?php echo isset($room['image']) ? $room['image'] : '' ?> " id="example-password-input">
                                                <div id="error-image"></div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row mb-3">
                                                <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light me-1" id="add">
                                                        Submit
                                                    </button>
                                                    <a href="<?php echo base_url('Room'); ?>" class="btn btn-secondary waves-effect">
                                                        Cancel
                                                    </a>
                                                </div>
                                            </div>
                                        <!-- end row -->
                                     
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        <input type="hidden" name="room_edit" id="room_edit" value = "<?php echo isset($room['room_no']) ? $room['room_no'] : '' ?>"  />
</form>
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

 <script>

        var baseurl = '<?php echo base_url(); ?>';
        var from_url = '';
        if( $('#room_edit').val() ){
             from_url = baseurl + 'room/update/' + $('#room_edit').val();
        }else{
             from_url = baseurl + 'room/store';
        }
		
      


		$('#add').on('click', function (e) { 
			e.preventDefault();         
			$.ajax({

				url: from_url,
				data: new FormData(document.querySelector('#add_room')),
				dataType: 'json',
				processData: false,
				contentType: false,
				type: 'POST',
				beforeSend(xhr) {


				},
				success: function (result) {
					
					if (result.error == 1) {

						if (result.error_message.room_no) {
							$('#error-room_no').html(result.error_message.room_no);
						} else {
							$('#error-room_no').html('');
						}
                       
						if (result.error_message.room_name) {
							$('#error-room_name').html(result.error_message.room_name);
						} else {
							$('#error-room_name').html('');
						}

                        if (result.error_message.tenent_name) {
							$('#error-tenent_name').html(result.error_message.tenent_name);
						} else {
							$('#error-tenent_name').html('');
						}

						if (result.error_message.address) {
							$('#error-address').html(result.error_message.address);
						} else {
							$('#error-address').html('');
						}

						if (result.error_message.telephone) {
							$('#error-telephone').html(result.error_message.telephone);
						} else {
							$('#error-telephone').html('');
						}
                        if (result.error_message.image) {
							$('#error-image').html(result.error_message.image);
						} else {
							$('#error-image').html('');
						}

					} else {
                        
						$('#error-room_no').html('');
						$('#error-room_name').html('');
                        $('#error-tenent_name').html('');
                        $('#error-address').html('');
                        $('#error-telephone').html('');
                        $('#error-image').html('');
						window.location = "/Room";
					
					}
				}
			});
		});



      
</script>