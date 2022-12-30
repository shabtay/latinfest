// getting all required elements
const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");
const icon = searchWrapper.querySelector(".icon");
let linkTag = searchWrapper.querySelector("a");
let webLink;

inputBox.addEventListener( "keypress", function( event ) {
	if (event.key === "Enter") {
		do_search();
	}
} );

// if user press any key and release
inputBox.onkeyup = (e)=>{
	return;
    let userData = e.target.value; //user enetered data
    let emptyArray = [];
    if(userData){
        icon.onclick = ()=>{
 //           webLink = `https://www.google.com/search?q=${userData}`;
 //           linkTag.setAttribute("href", webLink);
 //           linkTag.click();
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
            allList[i].setAttribute("onclick", "select(this);do_search()");
        }
    }else{
        searchWrapper.classList.remove("active"); //hide autocomplete box
    }
}

function select(element){
    let selectData = element.textContent;
    inputBox.value = selectData;
    icon.onclick = ()=>{
        //webLink = `https://www.google.com/search?q=${selectData}`;
        //linkTag.setAttribute("href", webLink);
        //linkTag.click();
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

function do_search( action ) {
	var search_term = $("#search_term").val();
	if ( search_term.trim().length < 4 ) {
		alert( "write at least 4 characters" );
		return;
	}
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

$("#divDatePicker").hide();

$("#btn_calendar").click(function(){
	$("#divDatePicker").toggle();
}); 

var availableDates;
get_available_dates();

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
