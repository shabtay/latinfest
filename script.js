// getting all required elements
const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");
const icon = searchWrapper.querySelector(".icon_search");
let linkTag = searchWrapper.querySelector("a");
let webLink;

inputBox.addEventListener( "keypress", function( event ) {
	if (event.key === "Enter") {
		do_search();
	}
} );

// if user press any key and release
inputBox.onkeyup = (e)=>{
    let userData = e.target.value; //user enetered data
    let emptyArray = [];
    if(userData){
        icon.onclick = ()=>{
			do_search();
        }
        emptyArray = suggestions.filter((data)=>{
            //filtering array value and user characters to lowercase and return only those words which are start with user enetered chars
            //return data.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase());
            return ( data.toLocaleLowerCase().search(userData.toLocaleLowerCase()) >= 0 ) ? true : false;
        });
        emptyArray = emptyArray.map((data)=>{
            // passing return data inside li tag
            return data = `<li>${data}</li>`;
        });
        searchWrapper.classList.add("active"); //show autocomplete box
        showSuggestions(emptyArray);
        let allList = suggBox.querySelectorAll("li");
        for (let i = 0; i < allList.length; i++) {
            //adding onclick attribute in all li tag
            allList[i].setAttribute("onclick", "select(this);");
        }
    }else{
        searchWrapper.classList.remove("active"); //hide autocomplete box
    }
}

function select(element){
    let selectData = element.textContent;
    inputBox.value = selectData + " ";
    icon.onclick = ()=>{
		do_search();
    }
    searchWrapper.classList.remove("active");
}

function showSuggestions(list){
    let listData;
    if(!list.length){
        userValue = inputBox.value;
        listData = `<li>${userValue}</li>`;
    }else{
      listData = list.join('');
    }
    suggBox.innerHTML = listData;
}

function do_search() {
	$("#errors").hide();
	
	var search_term = $("#search_term").val();
	if ( search_term.trim().length < 4 ) {
		$("#errors").show();
		$("#errors").html( "Error: Search must contains at least 4 characters" );
		setTimeout( function() { $("#errors").hide(); $("#errors").html( "write at least 4 characters" ); }, 4000 );

		return;
	}
	$("#search").val( search_term );
	$("#search_form").submit();
}

function do_search_post() {
	var search_term = $("#search_term").val();
	$.blockUI({ message: null });
	$.ajax( {
		type:'post',
		url:'get_results.php',		
		data:{
			search:"search",
			search_term:search_term
		},
		success:function(response) {
			if ( response != "" ) {
				$("#buttons").show();
				$("#buttons2").show();
			}
			$("#result_div").html( response );
			setTimeout( $.unblockUI, 50 );
		}
	} );
	return false;
}

function do_next_prev( ac ) {
	var search_term = $("#search_term").val();
	$.blockUI({ message: null }); 

	$.ajax( {
		type:'post',
		url:'get_results.php',
		data:{
			search: "search",
			search_term: search_term,
			action: ac
		},
		success:function(response) {
			$("#result_div").html( response );
			setTimeout( $.unblockUI, 50 );
		}
	} );
 
	return false;}

function move() {	
	var elem = document.getElementById("myBar");
	var width = 1;
	var id = setInterval(frame, 1);
	
	function frame() {
		if (width >= 100) {
			clearInterval(id);
			$("#myBarWrapper").hide();
		} else {
		  width += 1;
		  elem.style.width = width + '%';
		}
	}
}

function disable_next( val ) {
	$("#btn_next1").prop('disabled', val);
	$("#btn_next2").prop('disabled', val);
}

function disable_prev( val ) {
	$("#btn_prev1").prop('disabled', val);
	$("#btn_prev2").prop('disabled', val);
}

function get_available_dates() {
	$.ajax( {
		type:'post',
		url:'get_results.php',		
		data:{
			action: "get_available_dates"
		},
		success:function(response) {
			if ( response != "" ) {
				availableDates = JSON.parse( response );
			}
		}
	} );	
}

function get_search_terms() {
	$.ajax( {
		type:'post',
		url:'get_results.php',		
		data:{
			action: "get_search_terms"
		},
		success:function(response) {
			if ( response != "" ) {
				suggestions = JSON.parse( response );
			}
		}
	} );	
}

$("#divDatePicker").hide();

$("#btn_calendar").click(function(){
	$("#divDatePicker").toggle();
}); 

$("#btn_clear").click(function(){
	$("#search_term").val('');
}); 

var availableDates;
let suggestions;
$( document ).ready(function() { 
	get_available_dates();
	get_search_terms();
	
	$("#tips").accordion({ header: "h3", collapsible: true, active: false });
	
	$('.tip').on('click', function(e) {
		$("#search_term").val( $("#search_term").val() + ( e.target.innerHTML ) + " " );
	});

	setTimeout( function() {
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today.getFullYear();
		
		$("#divDatePicker").datepicker( "setDate", availableDates[0] );
	}, 1000 );
});

$("#divDatePicker").datepicker({
	dateFormat: 'yy-mm-dd',
	onSelect: function(value, date) { 
		//chose date
		$("#search_term").val( $("#search_term").val() + value );
		$("#divDatePicker").hide(); 
	},
	beforeShowDay: function(d) {        
        var year = d.getFullYear(),
            month = ("0" + (d.getMonth() + 1)).slice(-2),
            day = ("0" + (d.getDate())).slice(-2);

        var formatted = year + '-' + month + '-' + day;

        if ($.inArray(formatted, availableDates) != -1) {
            return [true, "","Available"]; 
        } else{
            return [false,"","unAvailable"]; 
        }
    }
});		

$( function() {
	$( "#dialog" ).dialog({
		autoOpen: false,
			show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "blind",
			duration: 1000
		},
		modal: true
	});

	$( "#help" ).on( "click", function() {
		$( "#dialog" ).dialog( "open" );
	});
} );
