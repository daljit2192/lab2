    
$(document).ready(function(){
    $("._deleteCountry").on("click",function(){
        var countryId = $(this).data("countryid");
        $("input[name='country_id_hidden']").val(countryId);
    });

    $("._deleteState").on("click",function(){
        var stateId = $(this).data("stateid");
        $("input[name='state_id_hidden']").val(stateId);
    });

    $("body").on("click",".add_state_div",function(){
    	if($("._stateImage").length == 5){
    		alert("Maximum image option reached");
    	} else {
	        $(this).parent("._stateImage").clone().insertAfter("div._stateImage:last");
    	}
    });
    
    $("body").on("click",".remove_state_div",function(){
    	if($("._stateImage").length > 1){
	        $(this).parent("._stateImage").remove();
    	} else {
    		alert("One image option is required");
    	}
    });

});

