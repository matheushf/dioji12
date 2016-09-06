/**
 * 
 */

$(document).ready(function() {
	$("#erroCns").hide();

	$("form").submit(function(e) {
		e.preventDefault(e);

		validar();

	});
})


function Onlynumbers(e) {
	var tecla = new Number();
	if (window.event) {
		tecla = e.keyCode;
	} else if (e.which) {
		tecla = e.which;
	} else {
		return true;
	}
	// if ((tecla >= "97") && (tecla <= "122")) {
	if ((tecla < "48") || (tecla > "57")) {
		if (tecla != "13") {
			return false;
		} else {
			return true;
		}
	}
}
