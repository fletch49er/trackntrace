/*
 * ===================================================================
 * Function:	change_form()
 * Purpose:		function to dynamically change with AJAX <input> blocks
 *            between email/mobile and postal address
 * Author:		Mark Fletcher
 * Date:			25.03.2021
 *
 * Input:
 *    dataArray, offset, length
 *
 * Output:
 *    <fieldset><input></fieldset> blocks
 *
 * Notes:
 *
 * ==================================================================
*/
function change_form(dataArray, offset, length) {
	let formBlock = '';
	let detailsNode = document.getElementById('details');
	let name = ['email', 'phone', 'address1', 'address2', 'townCity', 'postcode'];
	// build formBlock string
	for(var x = offset; x < length; x++) {
		formBlock += '<fieldset>\n';
		formBlock += '<label for="'+ name[x] +'">'+ dataArray[''+name[x]+''][0] +':</label><br />\n';
		formBlock += '<input autocomplete="'+ dataArray[''+name[x]+''][4] +'" id="'+ name[x] +'" type="'+ dataArray[''+name[x]+''][1] +'" name="'+ name[x] +'" value="'+ dataArray[''+name[x]+''][3] +'"';
		if ( name[x] != 'postcode') {
			formBlock += ' placeholder="'+ dataArray[''+name[x]+''][2] +'" />\n';
		} else {
			formBlock += ' placeholder="'+ dataArray[''+name[x]+''][2] +'" required />\n';
		}
		formBlock += '</fieldset>\n';
	}
	if (offset == 2) {
		formBlock += '<p id="switch_form" onclick="change_form(formEmail, 0, 2)">\n<i class="fas fa-mobile-alt"></i> Enter email and mobile number instead</p>\n';
	} else {
		formBlock += '<p id="switch_form" onclick="change_form(formAddress, 2, 6)">\n<i class="far fa-envelope"></i> Enter postal address instead</p>\n';
	}
	detailsNode.innerHTML = formBlock;
	window.scrollTo(0, 0);
}
