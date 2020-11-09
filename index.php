<?php include 'submit.php';?>
<html lang="en">
    <head>
        <title>Form Validations</title>
        <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
        <div class="container">
            <?php if (!isset($_GET['country'])){?>
                <h3>List of countries</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Acronym</th>
                            <th scope="col">Country Name</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($countries['data'] as $country){ ?>
                            <tr>
                                <th scope="row"><?php echo $country["id"]; ?></th>
                                <td scope="row"><?php echo $country["country_acronym"]; ?></td>
                                <td >
                                    <a href="index.php?country=<?php echo $country["id"]; ?>">
                                        <?php echo $country["country_name"]; ?>
                                </td>
                                <td ><?php $created_at = explode(' ',$country["created_at"]);
                                        $created_at = $created_at[0]; 
                                        echo $created_at; 
                                    ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-dark btn-sm">
                                        <i class="fa fa-pencil" onClick="document.location.href='index.php?editCountry=<?php echo $country['id']; ?>'"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#deleteCountry" data-countryid="<?php echo $country['id']; ?>" class="delete btn btn-danger btn-sm _deleteCountry">
                                        <i class="fa fa-trash-o" style=""></i>
                                    </button>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
                <hr>
                <?php if(!isset($_GET['editCountry'])){ ?>
                    <h3>Add new country</h3>
                    <form method="post">
                        <?php
                            // Display Error message
                            if(!empty($country['error'])){
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> <?= $country['error'] ?>
                                </div>
                            <?php
                            }
                            // Display Success message
                            if(!empty($country['success'])){
                            ?>
                                <div class="alert alert-success">
                                    <strong>Success!</strong> <?= $country['success'] ?>
                                </div>
                            <?php
                            }
                        ?>
                       <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Country Name</label>
                          <div class="col-sm-4">
                                <input type="text" name="country_name" class="form-control" placeholder="Name">
                          </div>
                       </div>
                       <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Country Acronym</label>
                          <div class="col-sm-4">
                                <input type="text" name="country_acronym" class="form-control" placeholder="Acronym">
                          </div>
                       </div>
                       <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" name="add_country" class="btn btn-success">Add country</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                       </div>
                    </form>
            <?php } else { ?>
                    <h3>Update country</h3>
                    <form method="post">
                        <?php
                            // Display Error message
                            if(!empty($countries['error'])){
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> <?= $countries['error'] ?>
                                </div>
                            <?php
                            }
                            // Display Success message
                            if(!empty($countries['success'])){
                            ?>
                                <div class="alert alert-success">
                                    <strong>Success!</strong> <?= $countries['success'] ?>
                                </div>
                            <?php
                            }
                        ?>
                       <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Country Name</label>
                          <div class="col-sm-4">
                             <input type="text" name="country_name" value = "<?php echo $singleCountry['country_name']; ?>" class="form-control" placeholder="Name">
                             <input type="hidden" name="country_id" value = "<?php echo $singleCountry['id']; ?>">
                          </div>
                       </div>
                       <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Country Name</label>
                          <div class="col-sm-4">
                             <input type="text" name="country_acronym" value = "<?php echo $singleCountry['country_acronym']; ?>" class="form-control" placeholder="Name">
                          </div>
                       </div>
                       <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" onclick="resetForm();" name="update_country" class="btn btn-primary">Update country</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                       </div>
                    </form>
            <?php } ?>

            <?php } else { ?>
                <?php if(count($states['data'])>0){ ?>
                    <h3>List of states in <?php echo $states['parent_country']["country_name"]; ?></h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Profile Image</th>
                                <th scope="col">Country</th>
                                <th scope="col">State</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($states['data'] as $state){ ?>
                                <tr>
                                    <th scope="row"><?php echo $state["id"]; ?></th>
                                    <td >
                                        <?php echo $states['parent_country']["country_name"]; ?>
                                    </td>
                                    <td >
                                        <?php 
                                        	if($state['state_image'] !== null){ ?>

        <img height="50px" width="50px" src="<?php echo $state['state_image_path'].$state['state_image']; ?>" >
                                        	<?php } else { ?>
        <img height="50px" width="50px" src="images/default_profile.png" >
                                        	<?php } ?>	
                                    </td>
                                    <td >
                                        <?php echo $state["state_name"]; ?>
                                    </td>
                                    <td ><?php $created_at = explode(' ',$state["created_at"]);
                                            $created_at = $created_at[0]; 
                                            echo $created_at; 
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-dark btn-sm">
                                            <i class="fa fa-pencil" onClick="document.location.href='index.php?country=<?php echo $_GET['country']; ?>&editState=<?php echo $state['id']; ?>'"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-target="#deleteState" data-stateid="<?php echo $state['id']; ?>" class="delete btn btn-danger btn-sm _deleteState">
                                            <i class="fa fa-trash-o" style=""></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                <?php } else { ?>
                    
                <?php } ?>
                <hr>
                <?php if(!isset($_GET['editState'])){ ?>
                <h3>Add new state</h3>
                <form method="post" enctype="multipart/form-data">
                    <?php
                        // Display Error message
                        if(!empty($states['error'])){
                        ?>
                            <div class="alert alert-danger">
                                <strong>Error!</strong> <?= $states['error'] ?>
                            </div>
                        <?php
                        }
                        // Display Success message
                        if(!empty($states['success'])){
                        ?>
                            <div class="alert alert-success">
                                <strong>Success!</strong> <?= $states['success'] ?>
                            </div>
                        <?php
                        }
                    ?>
                   <div class="form-group row">
                      <label class="col-sm-2 col-form-label">State Name</label>
                      <div class="col-sm-4">
                            <input type="text" name="state_name" class="form-control" placeholder="Name">
                            <input type="hidden" name="country_id" value = "<?php echo $_GET['country']; ?>"class="form-control" placeholder="Name">
                      </div>
                      
                   </div>
                   <div class="form-group row">
                        <label class="col-sm-2 col-form-label">State profile image</label>
                        <div class="col-sm-4">
                            <input type="file" name="state_profile_image" class="form-control">
                        </div>
                   </div>
                   <div class="form-group row _stateImage">
                        <label class="col-sm-2 col-form-label">State image</label>
                        <div class="col-sm-4">
                            <input type="file" name="state_sample_images[]" class="form-control">
                        </div>
                        <i class="fa fa-plus add_state_div" style="color: green; cursor: pointer;"></i>
                        <i class="fa fa-minus remove_state_div" style="color: red; cursor: pointer;"></i>
                   </div>
                   <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" name="add_state" class="btn btn-success">Add state</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                   </div>
                </form>

                <?php } else { ?>
                <h3>Update state</h3>
                <form method="post" enctype="multipart/form-data">
                    <?php
                        // Display Error message
                        if(!empty($states['error'])){
                        ?>
                            <div class="alert alert-danger">
                                <strong>Error!</strong> <?= $states['error'] ?>
                            </div>
                        <?php
                        }
                        // Display Success message
                        if(!empty($states['success'])){
                        ?>
                            <div class="alert alert-success">
                                <strong>Success!</strong> <?= $states['success'] ?>
                            </div>
                        <?php
                        }
                    ?>
                   	<div class="form-group row">
                      	<label class="col-sm-2 col-form-label">State Name</label>
                      	<div class="col-sm-4">
                            <input type="text" name="state_name" value = "<?php echo $singleState['state_name']; ?>" class="form-control" placeholder="Name">
                             <input type="hidden" name="state_id" value = "<?php echo $singleState['id']; ?>">
                             <input type="hidden" name="country_id" value = "<?php echo $_GET['country']; ?>">
                      	</div>
                    	
                   	</div>
                   	<div class="form-group row _stateImage">
                        <label class="col-sm-2 col-form-label">State profile image</label>
                        <div class="col-sm-4">
                            <input type="file" id="filetag" name="state_profile_image" class="form-control">
                            <?php if($singleState["state_image_path"]!= null) {?>
                            	<img height="70" width="70" src="<?php echo $singleState['state_image_path'].$singleState['state_image']; ?>"  id="preview">
                            <?php } else { ?>
                            	<img src=""  id="preview">
                            <?php } ?>
                        </div>
                   	</div>
                   	<div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" name="update_state" class="btn btn-primary">Update state</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                   </div>
                </form>
                <?php } ?>
                <?php } ?>
                <?php if (isset($_GET['country'])){?>
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-4">
                        <button type="button" class="btn btn-info" name="back" value="Back to countrys" onClick="document.location.href='index.php'">Back to countries</button>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="modal fade" id="deleteCountry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Delete Country !!</h3>
                            
                        </div>
                        <div class="modal-body">
                            <h4 >Are you sure you want to delete this country?</h4>
                            <input type="hidden" name="country_id_hidden" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger" name="delete_country">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteState" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h3 class="modal-title">Delete State !!</h3>
                        </div>
                        <div class="modal-body">
                            <h4 >Are you sure you want to delete this state?</h4>
                            <input type="text" name="state_id_hidden" value="">
                            <input type="hidden" name="state_country_id_hidden" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger" name="delete_state">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/custom.js"></script>
    <script type="text/javascript">
    	var fileTag = document.getElementById("filetag"),
	    preview = document.getElementById("preview");
	        
	    fileTag.addEventListener("change", function() {
	      changeImage(this);
	    });

	    function changeImage(input) {
	      var reader;

	      if (input.files && input.files[0]) {
	        reader = new FileReader();

	        reader.onload = function(e) {
	          preview.setAttribute('src', e.target.result);
	          preview.setAttribute('height', 70);
	          preview.setAttribute('width', 70);
	        }

	        reader.readAsDataURL(input.files[0]);
	      }
	    }
    </script>
</html>