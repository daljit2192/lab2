<?php
    include 'lab2.php';

    $lab2Obj = new lab2;
    
    $countries = $lab2Obj->getAllCountries();
    $states = [];
    $singleCountry = [];

    if (isset($_GET['country'])){

        $states = $lab2Obj->getAllStates($_GET['country']);
    }

    if (isset($_GET['editCountry'])){

        $singleCountry = $lab2Obj->getSingleCountry($_GET['editCountry']);
    }

    if (isset($_GET['editState'])){

        $singleState = $lab2Obj->getSingleState($_GET['editState']);
        // echo "<pre>"; print_r($singleState);die;
    }

    if(isset($_POST["add_country"])){
            
        $countries = $lab2Obj->addCountry($_POST["country_name"], $_POST["country_acronym"]);
        // echo "<pre>"; print_r($countries);die;  
    }

    if(isset($_POST["update_country"])){
        $countries = array();
        $countryData = array('country_id'=>$_POST['country_id'], 'country_name'=>$_POST['country_name'], "country_acronym"=>$_POST["country_acronym"]); 
        // echo "<pre>"; print_r($countries);die;  
        $lab2Obj->updateCountry($countryData);
        $singleCountry = $lab2Obj->getSingleCountry($_GET['editCountry']);
        $countries = $lab2Obj->getAllCountries();
    }

    if(isset($_POST["update_state"])){
        $states = array();
        $stateData = array('state_id'=>$_POST['state_id'],'country_id'=>$_POST['country_id'], 'state_profile_image'=>$_FILES["state_profile_image"], 'state_name'=>$_POST['state_name']); 
        $lab2Obj->updateState($stateData);
        $singleState = $lab2Obj->getSingleState($_GET['editState']);
        $states = $lab2Obj->getAllStates($_POST['country_id']);
    }

    if(isset($_POST["add_state"])){

        $stateData = array('state_name'=> $_POST["state_name"], 'country_id'=>$_POST["country_id"], 'state_profile_image'=>$_FILES["state_profile_image"], 'state_sample_images'=>$_FILES["state_sample_images"]);
        // echo "<pre>";print_r($stateData);die;
        $states = $lab2Obj->addState($stateData);
    }

    if(isset($_POST["delete_country"])){
        // echo $_POST["country_id_hidden"];die;
        $lab2Obj->deleteCountry($_POST["country_id_hidden"]);
        $countries = $lab2Obj->getAllCountries();
    }
    
    if(isset($_POST["delete_state"])){
        // echo $_POST["country_id_hidden"];die;
        $lab2Obj->deleteState($_POST["state_id_hidden"]);
        $countries = $lab2Obj->getAllCountries();
    }


?>
