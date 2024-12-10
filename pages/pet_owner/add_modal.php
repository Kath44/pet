<!-- Your modal HTML code -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg"> <!-- Changed modal size to large -->
        <form method="post" action="function/addPetOwner.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Pet Owner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row"> <!-- Start row -->
                        <div class="col-md-6"> <!-- First column -->
                            <div class="form-group">
                                <label for="pet_owner_name">Pet Owner Name</label>
                                <input class="form-control" type="text" id="pet_owner_name" name="pet_owner_name" required>
                                <div id="response"></div> <!-- Response container -->
                            </div>
                            <div class="form-group">
                                <label for="pet_owner_email">Email Address</label>
                                <input class="form-control" type="email" id="pet_owner_email" name="pet_owner_email" required>
                            </div>
                            <div class="form-group">
                                <label for="pet_owner_contact">Contact Number</label>
                                <input class="form-control" type="text" id="pet_owner_contact" name="pet_owner_contact" required>
                            </div>
                            <div class="form-group">
                                <label for="pet_owner_address">Address</label>
                                <input class="form-control" type="text" id="pet_owner_address" name="pet_owner_address" required>
                            </div>
                            
                        </div> <!-- End first column -->
                        <div class="col-md-6"> <!-- Second column -->
                            <div class="form-group">
                                <label for="pet_owner_profile">Profile Image</label>
                                <input class="form-control-file" type="file" id="pet_owner_profile" name="pet_owner_profile" accept="image/*" onchange="previewImage()">
                                <!-- Image preview container -->
                                <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100%; display: none;">
                            </div>
                        </div> <!-- End second column -->
                    </div> <!-- End row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" id="add_button" name="add" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Include jQuery library -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Integrate the provided JavaScript code -->
<script>
    // Define a function to check for duplicate pet owner usernames
    function checkDuplicate() {
        var petOwnerName = $('#pet_owner_name').val().trim();
        if (petOwnerName != '') {
            $.ajax({
                url: 'function/checkDuplicate.php', // PHP script to check for duplicate pet owner usernames
                type: 'post',
                data: { petOwnerName: petOwnerName },
                success: function (response) {
                    console.log('Success:', response); // Log success message
                    $('#response').html(response); // Display response message
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error); // Log error message
                }
            });
        } else {
            $("#response").html(""); // Clear response container
        }
    }

    $(document).ready(function () {
        // Call the checkDuplicate function each time a key is pressed in the #pet_owner_username input field
        $("#pet_owner_name").keyup(checkDuplicate);
    });

    // Function to preview the selected image
    function previewImage() {
        var fileInput = document.getElementById('pet_owner_profile');
        var imagePreview = document.getElementById('imagePreview');

        // Check if any file is selected
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            // Set up the reader to read the image file
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Display the image preview
            }

            // Read the image file as a data URL
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>