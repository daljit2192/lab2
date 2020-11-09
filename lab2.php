<?php 
include 'config.php';
class lab2 extends Config{

	public $countries = array('data' =>array() , 'error'=> '', 'success'=> '' );
	public $states = array('data' =>array() , 'parent_country' => array() , 'state_profile_image'=>array(),'state_image_info'=>array(), 'error'=> '', 'success'=> '' );

	function addCountry($country_name, $country_acronym){
		if($country_name!== "" && $country_acronym!==""){
			$this->resetState();
			$sql = "INSERT INTO country (country_name, country_acronym) VALUES ('".$country_name."','".$country_acronym."')";
	        if ($this->conn->query($sql) === TRUE) {
	            $sql = "SELECT * FROM country WHERE id = ".$this->conn->insert_id;
	            $result = $this->conn->query($sql); 
	            $row = $result->fetch_assoc();
	            array_push($this->countries['data'],$row);
	            $this->countries['success'] = "Country added successfully";

	        } else {
	            $this->countries['error'] = "Error: " . $sql . "<br>" . $this->conn->error;
	        }
		} else {
			$this->countries['error'] = "Please provide name for country field";
		}
        return $this->countries;
	}

	function updateCountry($countryData){
		if($countryData['country_name']!== "" && $countryData["country_acronym"]){
			$this->resetState();
			$sql = "update country set country_name = '".$countryData['country_name']."',  country_acronym = '".$countryData["country_acronym"]."' where id = ".$countryData['country_id']."";
			// echo $sql; die;
	        if ($this->conn->query($sql) === TRUE) {
	            $this->countries['success'] = "Country Updated successfully";

	        } else {
	            $this->countries['error'] = "Error: " . $sql . "<br>" . $this->conn->error;
	        }
		} else {
			$this->countries['error'] = "Please provide name for country field";
		}
        return $this->countries;
	}
    
    function updateState($stateData){
		if($stateData['state_name']!== ""){
			$this->resetState();
			$countryData = $this->getSingleCountry($stateData["country_id"]); 
			if($stateData["state_profile_image"]['size'] != 0 ){
				$sql = "SELECT * FROM state_image WHERE state_id = ".$stateData['state_id'];
	        	$result = $this->conn->query($sql);
	        	$row = $result->fetch_assoc();
	        	if(empty($row)){
	        		$this->uploadStateProfile($stateData, $stateData['state_id'], $countryData);
	        	} else {
		            $this->updateStateProfile($stateData, $stateData['state_id'], $countryData);
	        	}
    		}

			$sql = "update states set state_name = '".$stateData['state_name']."' where id = ".$stateData['state_id']."";
	        if ($this->conn->query($sql) === TRUE) {
	        	
	            $this->states['success'] = "State Updated successfully";

	        } else {
	            $this->states['error'] = "Error: " . $sql . "<br>" . $this->conn->error;
	        }
		} else {
			$this->states['error'] = "Please provide name for country field";
		}
        return $this->states;
	}

	function getAllCountries(){
		$sql = "SELECT * FROM country";
	    $result = $this->conn->query($sql);
	    if ($result->num_rows > 0) {
	    	$this->countries['data'] = array();
	        while($row = $result->fetch_assoc()) {
	            array_push($this->countries['data'],$row);
	        }
	    }
	    return $this->countries;
	}

	function getSingleCountry($country_id){
		$sql = "SELECT * FROM country WHERE id = ".$country_id;
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row;
	}

	function getAllStates($country_id){
		$this->states['data'] = array();
		$sql = "SELECT * FROM state_image RIGHT JOIN states ON states.id = state_image.state_id where country_id = ".$country_id;
		// echo $sql;die;
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($this->states['data'],$row);
            }
            // echo "<pre>"; print_r($this->states);die;
        } else {
            $this->states["error"] = "No states found, add now.";
        }
        $this->states['parent_country'] = $this->getSingleCountry($_GET['country']);
	    return $this->states;

	}

	function getSingleState($state_id){
		$sql = "SELECT * FROM state_image RIGHT JOIN states ON states.id = state_image.state_id where states.id = ".$state_id;
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        echo "<pre>";print_r($row); die;
        return $row;
	}


	function addState($stateData){
		$this->resetState();
		if($stateData['state_name']!== ""){
			$countryData = $this->getSingleCountry($stateData["country_id"]);
			$sql = "INSERT INTO states (state_name, country_id) VALUES ('".$stateData['state_name']."',".$stateData['country_id'].")";
	        if ($this->conn->query($sql) === TRUE) {
	        	$lastStateId = $this->conn->insert_id;
	        	if($stateData["state_profile_image"]['size'] != 0 ){
            		
		            $this->uploadStateProfile($stateData, $this->conn->insert_id, $countryData);
        		}
        		for($i=0;$i<count($stateData["state_sample_images"]["name"]);$i++){

				    $fileData = pathinfo(basename($stateData["state_sample_images"]["name"][$i]));
				    $target_path = 'images/'.$countryData["country_name"]."/".$stateData["state_name"]."/sampleimages/";
					$target_file = $target_path . basename($stateData["state_sample_images"]["name"][$i]);
			
				    if (!file_exists($target_path)) {
			            mkdir($target_path, 0777, true);
			        }

				    if (move_uploaded_file($stateData["state_sample_images"]["tmp_name"][$i], $target_file)){
				    	$image=basename( $stateData["state_profile_image"]["name"][$i]);
						$sql = "INSERT INTO state_sample_images (state_id, image, pathh) VALUES ('".$lastStateId."','".$image."', '".$target_path."')";
						$this->conn->query($sql);
				    }else{
				    	echo "There was an error uploading the file please try again!<br />";
				    }
				}
        		$sql = "SELECT * FROM state_image RIGHT JOIN states ON states.id = state_image.state_id where states.id = ".$this->conn->insert_id;
	            $result = $this->conn->query($sql); 
	            $row = $result->fetch_assoc();
	            array_push($this->states['data'],$row);
	            $this->states['success'] = "State added successfully";

	        } else {
	            $this->states['error'] = "Error: " . $sql . "<br>" . $this->conn->error;
	        }
		} else {
			$this->states['error'] = "Please provide name for state field";
		}
        return $this->states;
	}

	function deleteCountry($country_id){
		$sql = "delete from country where id=".$country_id.";";
        if ($this->conn->query($sql) === TRUE) {
            $sql = "delete from states where country_id=".$country_id.";";
            $result = $this->conn->query($sql);
            
            $this->countries['success'] = "Country deleted successfully";

        } else {
            $this->countries['error'] = "Error: " . $sql . "<br>" . $this->conn->error;
        }
	}
	
	function deleteState($state_id){
		$sql = "SELECT * FROM states WHERE id = ".$state_id;
        $result = $this->conn->query($sql); 
        $row = $result->fetch_assoc();
        // echo "<pre>";print_r($row);die;
        // rmdir($row["state_name"]);
        $sql = "delete from states where id=".$state_id.";";
        $this->conn->query($sql);
        $sql = "delete from state_image where state_id=".$state_id.";";
        $this->conn->query($sql);
        
        $this->states['success'] = "State deleted successfully";
	}
		
	function resetState(){
		$this->states["error"] = "";
		$this->states["success"] = "";
		$this->countries["error"] = "";
		$this->countries["success"] = "";
	}

	function uploadStateProfile($stateData, $stateId, $countryData){
		// echo "<pre>";print_r($stateData["state_profile_image"]);
		$target_path = 'images/'.$countryData['country_name'].'/'.$stateData["state_name"].'/profileimage/';
		$target_file = $target_path . basename($stateData["state_profile_image"]["name"]);
		
		if (!file_exists($target_path)) {
            mkdir($target_path, 0777, true);
        }

        if (move_uploaded_file($stateData["state_profile_image"]["tmp_name"], $target_file))
        {
			$image=basename( $stateData["state_profile_image"]["name"]);
			$sql = "INSERT INTO state_image (state_id, state_image, state_image_path) VALUES ('".$stateId."','".$image."', '".$target_path."')";
			$this->conn->query($sql);
	        

	    } else {
	        echo "Sorry, there was an error uploading your file."; die;
	    }
	}

	function updateStateProfile($stateData, $stateId, $countryData){
		// echo "here"; die;
		$this->rrmdir("images/".$countryData['country_name']);
		// echo "<pre>";print_r($stateData["state_profile_image"]);
		$target_path = 'images/'.$countryData['country_name'].'/'.$stateData["state_name"].'/profileimage/';
		$target_file = $target_path . basename($stateData["state_profile_image"]["name"]);
		
		if (!file_exists($target_path)) {
            mkdir($target_path, 0777, true);
        }

        if (move_uploaded_file($stateData["state_profile_image"]["tmp_name"], $target_file))
        {
			$image=basename( $stateData["state_profile_image"]["name"]);
			$sql = "UPDATE state_image set state_image = '".$image."', state_image_path = '".$target_path."' where state_id = ".$stateId;
			$this->conn->query($sql);
	        

	    } else {
	        echo "Sorry, there was an error uploading your file."; die;
	    }
	}

	function rrmdir($dir) {
  		if (is_dir($dir)) {
    		$objects = scandir($dir);
    		foreach ($objects as $object) {
      		if ($object != "." && $object != "..") {
        		if (filetype($dir."/".$object) == "dir") 
           			$this->rrmdir($dir."/".$object); 
        			else unlink   ($dir."/".$object);
      			}
    		}
    		reset($objects);
    		rmdir($dir);
  		}
 	}
}
?>