$(document).ready(function () {
    $("#trxmax").DataTable({ 
		pagingType: "simple_numbers", 
		lengthChange: !1, 
		searching: !1, 
		pageLength: 10 
	}), 
	$(".dataTables_length").addClass("bs-select");
});
$(document).ready(function () {
    $("#trxmin").DataTable({ 
		pagingType: "simple_numbers", 
		lengthChange: !1, 
		searching: !1, 
		pageLength: 3 
	}), 
	$(".dataTables_length").addClass("bs-select");
});
