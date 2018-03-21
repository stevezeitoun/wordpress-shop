function remove_whitespace(node) {
  var ttt;
  for (ttt = 0; ttt < node.childNodes.length; ttt++) {
    if (node.childNodes[ttt] && node.childNodes[ttt].nodeType == '3' && !/\S/.test(node.childNodes[ttt].nodeValue)) {
      node.removeChild(node.childNodes[ttt]);
      ttt--;
    }
    else {
      if (node.childNodes[ttt].childNodes.length) {
        remove_whitespace(node.childNodes[ttt]);
      }
    }
  }
  return;
}

function remove_empty_columns() {
	jQuery('.wdform_section').each(function() {
		if(jQuery(this).find('.wdform_column').last().prev().html()=='') {
			if(jQuery(this).children().length>2) {
				jQuery(this).find('.wdform_column').last().prev().remove();
				remove_empty_columns();
			}
		}	
	});
}

function sortable_columns() {
  jQuery( ".wdform_column" ).sortable({
		connectWith: ".wdform_column",
		cursor: 'move',
		placeholder: "highlight",
		start: function(e, ui) {
      jQuery(".add-new-button").off("click");
			jQuery('.wdform_column').each(function() {
        if (jQuery(this).html()) {
					jQuery(this).append(jQuery('<div class="wdform_empty_row" style="height:80px;"></div>'));
					jQuery( ".wdform_column" ).sortable( "refresh" );
				}
			});
		},
		update: function(event, ui) {
			jQuery('.wdform_section .wdform_column:last-child').each(function() {
        if (jQuery(this).html()) {
          jQuery(this).parent().append(jQuery('<div></div>').addClass("wdform_column"));
          sortable_columns();
				}		
			});
		},
		stop: function(event, ui) {
			jQuery('.wdform_empty_row').remove();
      if (ui.item.attr("id") == "add_field" && ui.item.parent().attr("id") != "add_field_cont") {
        nextID = jQuery("#add_field").next(".wdform_row").attr("wdid"); //find next row id for position
				jQuery("#add_field").parent().attr("id", "cur_column");  // add id cur_column to this column

        popup_ready();
				Enable();
				return false;
			}
			remove_empty_columns();
		}
  });
}

function all_sortable_events() {
  jQuery(".wdform_row, .wdform_tr_section_break").on("hover, touchstart", function (event) {
    if (!jQuery(this).find('.wdform_arrows').is(':visible')) {
      jQuery('.wdform_arrows').hide();
      jQuery(this).find('.wdform_arrows').show();
      event.preventDefault();
      return false;
    }
  });
  jQuery(".wdform_row, .wdform_tr_section_break").on("mouseleave", function () {
    jQuery(this).find('.wdform_arrows').hide();
  });
}

jQuery(document).on( "dblclick", ".wdform_row, .wdform_tr_section_break", function() {
	if(jQuery("#enable_sortable").val() == 1) { // disable double click event when sortable is disabled
		edit(jQuery(this).attr("wdid"));
	}
});
	
function fm_change_radio(elem) {	
	if(jQuery( elem ).hasClass( "fm-yes" )) {
		jQuery( elem ).val('0');
		jQuery( elem ).next().val('0');
		jQuery( elem ).removeClass('fm-yes').addClass('fm-no');
		jQuery(elem).find("span").animate({
			right: parseInt(jQuery( elem ).css( "width")) - 14 + 'px'
		}, 400, function() {
		}); 
	}	
	else {
		jQuery( elem ).val('1');
		jQuery( elem ).next().val('1');
		jQuery(elem).find("span").animate({
			right: 0
		}, 400, function() {
			jQuery( elem ).removeClass('fm-no').addClass('fm-yes');
		}); 
	}	
	if(jQuery( elem ).next().attr('name') == 'mail_verify') {
		show_verify_options(jQuery( elem ).val() == 1 ? true : false);
	}	
}
		
function enable_drag(elem) {
	fm_change_radio(elem);
	if(jQuery('#enable_sortable').val() == 1) {
		jQuery('.wdform_column').sortable( "enable" );
		jQuery('.wdform_arrows_advanced').hide();
    jQuery( ".wdform_field" ).css("cursor", "");
    jQuery( "#add_field .wdform_field" ).css("cursor", "");
		all_sortable_events();
	}
	else {
		jQuery('.wdform_column').sortable( "disable" );
    jQuery('.wdform_arrows_advanced').show();
		jQuery( ".wdform_field" ).css("cursor", "default");
		jQuery( "#add_field .wdform_field" ).css("cursor", "pointer");
		all_sortable_events();
	}
}

function refresh_() {
	document.getElementById('counter').value = gen;
	for (i = 1; i <= form_view_max; i++) {
		if (document.getElementById('form_id_tempform_view' + i)) {
			if (document.getElementById('page_next_' + i)) {
				document.getElementById('page_next_' + i).removeAttribute('src');
      }
			if (document.getElementById('page_previous_' + i)) {
				document.getElementById('page_previous_' + i).removeAttribute('src');
      }
			document.getElementById('form_id_tempform_view' + i).parentNode.removeChild(document.getElementById('form_id_tempform_view_img' + i));
		}
  }
  jQuery("#take div").removeClass("ui-sortable ui-sortable-disabled ui-sortable-handle");
	jQuery( "#add_field_cont" ).remove(); // remove add new button from div content
	document.getElementById('form_front').value = document.getElementById('take').innerHTML;
}

function fm_add_submission_email(toAdd_id, value_id, parent_id, cfm_url) {
  var value = jQuery("#" + value_id).val();
  if (value) {
    var mail_div = jQuery("<p>").attr("class", "fm_mail_input").prependTo("#" + parent_id);
    jQuery("<span>").attr("class", "mail_name").text(value).appendTo(mail_div);
    jQuery("<span>").attr("class", "dashicons dashicons-trash").attr("onclick", "fm_delete_mail(this, '" + value + "')").attr("title", "Delete Email").appendTo(mail_div);
    jQuery("#" + value_id).val("");
    jQuery("#" + toAdd_id).val(jQuery("#" + toAdd_id).val() + value + ",");
  }
}

function fm_delete_mail(img, value) {
  jQuery(img).parent().remove();
  jQuery("#mail").val(jQuery("#mail").val().replace(value + ',', ''));
}

function form_maker_options_tabs(id) {
    var tab = fm_option_tabs_mail_validation();
  	if(tab === true) {
        jQuery("#fieldset_id").val(id);
        jQuery(".fm_fieldset_active").removeClass("fm_fieldset_active").addClass("fm_fieldset_deactive");
        jQuery("#" + id + "_fieldset").removeClass("fm_fieldset_deactive").addClass("fm_fieldset_active");
        jQuery(".fm_fieldset_tab").removeClass("active");
        jQuery("#" + id).addClass("active");
    }
  return false;
}

function set_type(type) {
  switch(type) {
    case 'post':
    document.getElementById('post').removeAttribute('style');
    document.getElementById('page').setAttribute('style','display:none');
    document.getElementById('custom_text').setAttribute('style','display:none');
    document.getElementById('url').setAttribute('style','display:none');
    break;
    case 'page':
      document.getElementById('page').removeAttribute('style');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').setAttribute('style','display:none');
      document.getElementById('url').setAttribute('style','display:none');
      break;
    case 'custom_text':
      document.getElementById('page').setAttribute('style','display:none');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').removeAttribute('style');
      document.getElementById('url').setAttribute('style','display:none');
      break;
    case 'url':
      document.getElementById('page').setAttribute('style','display:none');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').setAttribute('style','display:none');
      document.getElementById('url').removeAttribute('style');
      break;
    case 'none':
      document.getElementById('page').setAttribute('style','display:none');
      document.getElementById('post').setAttribute('style','display:none');
      document.getElementById('custom_text').setAttribute('style','display:none');
      document.getElementById('url').setAttribute('style','display:none');
      break;
  }
}

function insertAtCursor(myField, myValue) {
 if ( tinyMCE.get(myField) ) {
	tinyMCE.get(myField).focus();
 }
  var myField = document.getElementById(myField);
  if (myField.style.display == "none") {
    tinyMCE.execCommand('mceInsertContent', false, "%" + myValue + "%");
    return;
  }
  if (document.selection) {
    myField.focus();
    sel = document.selection.createRange();
    sel.text = myValue;
  }
  else if (myField.selectionStart || myField.selectionStart == '0') {
    var startPos = myField.selectionStart;
    var endPos = myField.selectionEnd;
    myField.value = myField.value.substring(0, startPos)
      + "%" + myValue + "%"
      + myField.value.substring(endPos, myField.value.length);
  }
  else {
    myField.value += "%" + myValue + "%";
  }
}

function check_isnum(e) {
  var chCode1 = e.which || e.keyCode;
  if ( chCode1 > 31
		&& (chCode1 < 48 || chCode1 > 57)
		&& (chCode1 != 46)
		&& (chCode1 != 45)
		&& (chCode1 < 35 || chCode1 > 40) ) {
    return false;
  }
  return true;
}

// Check Email.
function fm_check_email(id) {
  if (document.getElementById(id) && jQuery('#' + id).val() != '') {
    var email_array = jQuery('#' + id).val().split(',');
	var re = /^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,61}$/;
    for (var email_id = 0; email_id < email_array.length; email_id++) {
      var email = email_array[email_id].replace(/^\s+|\s+$/g, '');
      if ( ! re.test( email ) ) {
        alert('This is not a valid email address.');
        jQuery('#' + id).css('border', '1px solid #FF0000');
        jQuery('#' + id).focus();
        jQuery('html, body').animate({
          scrollTop:jQuery('#' + id).offset().top - 200
        }, 500);
        return true;
      }
    }
	jQuery('#' + id).css('border', '1px solid #ddd');
  }
  return false;
}

function wdhide(id) {
	document.getElementById(id).style.display = "none";
}
function wdshow(id) {
	document.getElementById(id).style.display = "block";
}
function delete_field_condition(id) {
	var cond_id = id.split("_");
	document.getElementById("condition"+cond_id[0]).removeChild(document.getElementById("condition_div"+id));
}

function change_choices(value, ids, types, params) {
	value = value.split("_");
	global_index = value[0];
	id = value[1];
	index = value[2];
	ids_array = ids.split("@@**@@");
	types_array = types.split("@@**@@");
	params_array = params.split("@@**@@");

	switch(types_array[id]) {
		case "type_text":
		case "type_password":
		case "type_textarea":
		case "type_name":
		case "type_submitter_mail":
		case "type_number":
		case "type_phone":
		case "type_paypal_price":
		case "type_paypal_price_new":
		case "type_spinner":
		case "type_date_new":
		case "type_phone_new":
			if(types_array[id]=="type_number" || types_array[id]=="type_phone")
				var keypress_function = "return check_isnum_space(event)";
			else
				if(types_array[id]=="type_paypal_price" || types_array[id]=="type_paypal_price_new")
					var keypress_function = "return check_isnum_point(event)";
				else
					var keypress_function = "";
		
			if(document.getElementById("field_value"+global_index+"_"+index).tagName=="SELECT") {
				document.getElementById("condition_div"+global_index+"_"+index).removeChild(document.getElementById("field_value"+global_index+"_"+index));				
				var label_input = document.createElement('input');
					label_input.setAttribute("id", "field_value"+global_index+'_'+index);
					label_input.setAttribute("type", "text");
					label_input.setAttribute("value", "");	
					label_input.setAttribute("class", "fm_condition_field_input_value");

					label_input.setAttribute("onKeyPress", keypress_function);

				document.getElementById("condition_div"+global_index+"_"+index).insertBefore(label_input,document.getElementById("delete_condition"+global_index+"_"+index));
				document.getElementById("condition_div"+global_index+"_"+index).insertBefore(document.createTextNode(' '),document.getElementById("delete_condition"+global_index+"_"+index));
			}
			else {
				document.getElementById("field_value"+global_index+'_'+index).value="";
				document.getElementById("field_value"+global_index+'_'+index).setAttribute("onKeyPress", keypress_function);
			}
		break;
		
		case "type_own_select":
		case "type_radio":
		case "type_checkbox":
			if(types_array[id]=="type_own_select")
				w_size = params_array[id].split('*:*w_size*:*');
			else
				w_size = params_array[id].split('*:*w_flow*:*');
		
			w_choices = w_size[1].split('*:*w_choices*:*');
			w_choices_array = w_choices[0].split('***');
			if(w_size[1].indexOf('*:*w_value_disabled*:*') !== -1){
				w_value_disabled = w_size[1].split('*:*w_value_disabled*:*');
				w_choices_value = w_value_disabled[1].split('*:*w_choices_value*:*');
				w_choices_value_array = w_choices_value[0].split('***');
			}
			else{
				w_choices_value_array = w_choices_array;
			}
			
			var choise_select = document.createElement('select');
				choise_select.setAttribute("id", "field_value"+global_index+'_'+index);
				choise_select.setAttribute("class", "fm_condition_field_select_value");

				if(types_array[id]== "type_checkbox") {
					choise_select.setAttribute('multiple', 'multiple');
					choise_select.setAttribute('class', 'multiple_select');
				}

			for(k=0; k<w_choices_array.length; k++) {
				var choise_option = document.createElement('option');
					choise_option.setAttribute("id", "choise_"+global_index+'_'+k);
					choise_option.setAttribute("value", w_choices_value_array[k]);
					choise_option.innerHTML = w_choices_array[k];	
					if(w_choices_array[k].indexOf('[') === -1 && w_choices_array[k].indexOf(']') === -1) {
            choise_select.appendChild(choise_option);
          }
			}
			
			document.getElementById("condition_div"+global_index+"_"+index).removeChild(document.getElementById("field_value"+global_index+"_"+index));
			document.getElementById("condition_div"+global_index+"_"+index).insertBefore(choise_select,document.getElementById("delete_condition"+global_index+"_"+index));
			document.getElementById("condition_div"+global_index+"_"+index).insertBefore(document.createTextNode(' '),document.getElementById("delete_condition"+global_index+"_"+index));
		
		break;	
		
		case "type_paypal_select":	
		case "type_paypal_radio":
		case "type_paypal_checkbox":
		case "type_paypal_shipping":
			if(types_array[id]=="type_paypal_select")
				w_size = params_array[id].split('*:*w_size*:*');
			else
				w_size = params_array[id].split('*:*w_flow*:*');
		
			w_choices = w_size[1].split('*:*w_choices*:*');
			w_choices_array = w_choices[0].split('***');

			w_choices_price = w_choices[1].split('*:*w_choices_price*:*');
			w_choices_price_array = w_choices_price[0].split('***');
			
			var choise_select = document.createElement('select');
				choise_select.setAttribute("id", "field_value"+global_index+'_'+index);
				choise_select.setAttribute("class", "fm_condition_field_select_value");

				if(types_array[id]== "type_paypal_checkbox") {
					choise_select.setAttribute('multiple', 'multiple');
					choise_select.setAttribute('class', 'multiple_select');
				}

			for(k=0; k<w_choices_array.length; k++) {
				var choise_option = document.createElement('option');
					choise_option.setAttribute("id", "choise_"+global_index+'_'+k);
					choise_option.setAttribute("value", w_choices_array[k]+'*:*value*:*'+w_choices_price_array[k]);
					choise_option.innerHTML = w_choices_array[k];	
					if(w_choices_array[k].indexOf('[') === -1 && w_choices_array[k].indexOf(']') === -1) {
						choise_select.appendChild(choise_option);
					}
			}
			
			document.getElementById("condition_div"+global_index+"_"+index).removeChild(document.getElementById("field_value"+global_index+"_"+index));
			document.getElementById("condition_div"+global_index+"_"+index).insertBefore(choise_select,document.getElementById("delete_condition"+global_index+"_"+index));
			document.getElementById("condition_div"+global_index+"_"+index).insertBefore(document.createTextNode(' '),document.getElementById("delete_condition"+global_index+"_"+index));
		break;	
		case "type_address":
			countries = form_maker.countries;
		
		var choise_select = document.createElement('select');
			choise_select.setAttribute("id", "field_value"+global_index+'_'+m);
      choise_select.setAttribute("class", "fm_condition_field_select_value");
      jQuery.each( countries, function( key, value ) {
        var choise_option = document.createElement('option');
        choise_select.setAttribute("id", "field_value" + global_index + '_' + index);
        choise_option.setAttribute("value", value);
        choise_option.innerHTML = value;

        choise_select.appendChild(choise_option);
      });
			
			document.getElementById("condition_div"+global_index+"_"+index).removeChild(document.getElementById("field_value"+global_index+"_"+index));
			document.getElementById("condition_div"+global_index+"_"+index).insertBefore(choise_select,document.getElementById("delete_condition"+global_index+"_"+index));
			document.getElementById("condition_div"+global_index+"_"+index).insertBefore(document.createTextNode(' '),document.getElementById("delete_condition"+global_index+"_"+index));
			
		break;
	}
}

function add_condition_fields(num, ids1, labels1, types1, params1) {
	ids = ids1.split("@@**@@");
	labels = labels1.split("@@**@@");
	types = types1.split("@@**@@");
	params = params1.split("@@**@@");
	
	for(i=500; i>=0; i--) {
		if(document.getElementById('condition_div'+num+'_'+i))
			break;
	}
	m=i+1;
	
	var condition_div = document.createElement('div');
		condition_div.setAttribute("id", "condition_div"+num+'_'+m);
	
	var labels_select = document.createElement('select');
		labels_select.setAttribute("id", "field_labels"+num+'_'+m);
		labels_select.setAttribute("onchange", "change_choices(options[selectedIndex].id+'_"+m+"','"+ids1+"','"+types1+"','"+params1.replace(/\'/g,"\\'")+"')");
   		labels_select.setAttribute("class", "fm_condition_field_labels");

	for(k=0; k<labels.length; k++) {
		if(ids[k]!=document.getElementById('fields'+num).value) {
			var labels_option = document.createElement('option');
				labels_option.setAttribute("id", num+"_"+k);
				labels_option.setAttribute("value", ids[k]);
				labels_option.innerHTML = labels[k];	
				
			labels_select.appendChild(labels_option);	
		}
	}
	
	condition_div.appendChild(labels_select);	
	condition_div.appendChild(document.createTextNode(' '));
	
	var is_select = document.createElement('select');
		is_select.setAttribute("id", "is_select"+num+'_'+m);
		is_select.setAttribute("class", "fm_condition_is_select");


	var	is_option = document.createElement('option');
		is_option.setAttribute("id", "is");
		is_option.setAttribute("value", "==");
		is_option.innerHTML = "is";

	var	is_notoption = document.createElement('option');
		is_notoption.setAttribute("id", "is_not");
		is_notoption.setAttribute("value", "!=");
		is_notoption.innerHTML = "is not";
	
	var	is_likoption = document.createElement('option');
		is_likoption.setAttribute("id", "like");
		is_likoption.setAttribute("value", "%");
		is_likoption.innerHTML = "like";
		
	var	is_notlikoption = document.createElement('option');
		is_notlikoption.setAttribute("id", "not_like");
		is_notlikoption.setAttribute("value", "!%");
		is_notlikoption.innerHTML = "not like";
		
	var	is_emptyoption = document.createElement('option');
		is_emptyoption.setAttribute("id", "empty");
		is_emptyoption.setAttribute("value", "=");
		is_emptyoption.innerHTML = "empty";
		
	var	is_notemptyoption = document.createElement('option');
		is_notemptyoption.setAttribute("id", "not_empty");
		is_notemptyoption.setAttribute("value", "!");
		is_notemptyoption.innerHTML = "not empty";
		
		
		is_select.appendChild(is_option);	
		is_select.appendChild(is_notoption);
        is_select.appendChild(is_likoption);
        is_select.appendChild(is_notlikoption);
        is_select.appendChild(is_emptyoption);
        is_select.appendChild(is_notemptyoption);		

		condition_div.appendChild(is_select);
		condition_div.appendChild(document.createTextNode(' '));
		
	if(ids[0]!=document.getElementById('fields'+num).value)
		var index_of_field = 0;
	else
		var index_of_field = 1;
	
	switch(types[index_of_field]) {
		case "type_text":
		case "type_password":
		case "type_textarea":
		case "type_name":
		case "type_submitter_mail":
		case "type_phone":
		case "type_number":
		case "type_paypal_price":
		case "type_paypal_price_new":
		case "type_spinner":
		case "type_date_new":
		case "type_phone_new":
		if(types[index_of_field]=="type_number" || types[index_of_field]=="type_phone")
				var keypress_function = "return check_isnum_space(event)";
			else
				if(types[index_of_field]=="type_paypal_price" || types[index_of_field]=="type_paypal_price_new")
					var keypress_function = "return check_isnum_point(event)";
				else
					var keypress_function = "";
		
		var label_input = document.createElement('input');
			label_input.setAttribute("id", "field_value"+num+'_'+m);
			label_input.setAttribute("type", "text");
			label_input.setAttribute("value", "");	
			label_input.setAttribute("class", "fm_condition_field_input_value");

			label_input.setAttribute("onKeyPress", keypress_function);
			
		condition_div.appendChild(label_input);
		
		break;
		
		case "type_checkbox":
		case "type_radio":
		case "type_own_select":
			if(types[index_of_field]=="type_own_select")
				w_size = params[index_of_field].split('*:*w_size*:*');
			else
				w_size = params[index_of_field].split('*:*w_flow*:*');
				
			w_choices = w_size[1].split('*:*w_choices*:*');
			w_choices_array = w_choices[0].split('***');
			
			if(w_size[1].indexOf('*:*w_value_disabled*:*') !== -1){
				w_value_disabled = w_size[1].split('*:*w_value_disabled*:*');
				w_choices_value = w_value_disabled[1].split('*:*w_choices_value*:*');
				w_choices_value_array = w_choices_value[0].split('***');
			}
			else{
				w_choices_value_array = w_choices_array;
			}
			
			var choise_select = document.createElement('select');
				choise_select.setAttribute("id", "field_value"+num+'_'+m);
				choise_select.style.cssText = "vertical-align: top; width:200px;";
				if(types[index_of_field]== "type_checkbox") {
					choise_select.setAttribute('multiple', 'multiple');
					choise_select.setAttribute('class', 'multiple_select');
				}
					
			for(k=0; k<w_choices_array.length; k++)	 {
				var choise_option = document.createElement('option');
					choise_option.setAttribute("id", "choise_"+num+'_'+k);
					choise_option.setAttribute("value", w_choices_value_array[k]);
					choise_option.innerHTML = w_choices_array[k];	
					
				if(w_choices_array[k].indexOf('[') === -1 && w_choices_array[k].indexOf(']') === -1) {
					choise_select.appendChild(choise_option);
				}
			}
			condition_div.appendChild(choise_select);	
			
		break;
		
		case "type_paypal_select":
		case "type_paypal_checkbox":
		case "type_paypal_radio":
		case "type_paypal_shipping":
			if(types[index_of_field]=="type_paypal_select")
				w_size = params[index_of_field].split('*:*w_size*:*');
			else
				w_size = params[index_of_field].split('*:*w_flow*:*');
				
			w_choices = w_size[1].split('*:*w_choices*:*');
			w_choices_array = w_choices[0].split('***');
			
			w_choices_price = w_choices[1].split('*:*w_choices_price*:*');
			w_choices_price_array = w_choices_price[0].split('***');
			
			var choise_select = document.createElement('select');
				choise_select.setAttribute("id", "field_value"+num+'_'+m);
				choise_select.style.cssText = "vertical-align: top; width:200px;";
				if(types[index_of_field]== "type_paypal_checkbox") {
					choise_select.setAttribute('multiple', 'multiple');
					choise_select.setAttribute('class', 'multiple_select');
				}
					
			for(k=0; k<w_choices_array.length; k++)	 {
				var choise_option = document.createElement('option');
					choise_option.setAttribute("id", "choise_"+num+'_'+k);
					choise_option.setAttribute("value", w_choices_array[k]+'*:*value*:*'+w_choices_price_array[k]);
					choise_option.innerHTML = w_choices_array[k];	
					
				if(w_choices_array[k].indexOf('[') === -1 && w_choices_array[k].indexOf(']') === -1 ) {
					choise_select.appendChild(choise_option);
				}
			}
			condition_div.appendChild(choise_select);	
		break;
		
		case "type_address":
      countries = form_maker.countries;
		
		var choise_select = document.createElement('select');
			choise_select.setAttribute("id", "field_value"+num+'_'+m);
      choise_select.setAttribute("class", "fm_condition_field_select_value");
      jQuery.each( countries, function( key, value ) {
        var choise_option = document.createElement('option');
        choise_option.setAttribute("id", "choise_" + num + '_' + k);
        choise_option.setAttribute("value", value);
        choise_option.innerHTML = value;

        choise_select.appendChild(choise_option);
      });
			condition_div.appendChild(choise_select);	
		break;
	}
	condition_div.appendChild(document.createTextNode(' '));
	
	var	trash_icon = document.createElement('span');
		trash_icon.setAttribute('class', 'dashicons dashicons-trash');
		trash_icon.setAttribute('id','delete_condition'+num+'_'+m);
		trash_icon.setAttribute('onClick','delete_field_condition("'+num+'_'+m+'")');
		trash_icon.style.cssText = "vertical-align: middle";

	condition_div.appendChild(trash_icon);
	document.getElementById('condition'+num).appendChild(condition_div);
}

function add_condition(ids1, labels1, types1, params1, all_ids, all_labels) {
	for(i=500; i>=0; i--) {
		if(document.getElementById('condition'+i))
			break;
	}
	
	num=i+1;

	ids = all_ids.split("@@**@@");
	labels = all_labels.split("@@**@@");

	var condition_div = document.createElement('div');
		condition_div.setAttribute("id", "condition"+num);
		condition_div.setAttribute("class", "fm_condition");
	
	var conditional_fields_div = document.createElement('div');
		conditional_fields_div.setAttribute("id", "conditional_fileds"+num);
	
	var show_hide_select = document.createElement('select');
		show_hide_select.setAttribute("id", "show_hide"+num);
		show_hide_select.setAttribute("name", "show_hide"+num);
		show_hide_select.setAttribute("class", "fm_condition_show_hide");

	var show_option = document.createElement('option');
		show_option.setAttribute("value", "1");
		show_option.innerHTML = "show";

	var hide_option = document.createElement('option');
		hide_option.setAttribute("value", "0");
		hide_option.innerHTML = "hide";	
	
	show_hide_select.appendChild(show_option);
	show_hide_select.appendChild(hide_option);
	
	var fields_select = document.createElement('select');
		fields_select.setAttribute("id", "fields"+num);
		fields_select.setAttribute("name", "fields"+num);
    	fields_select.setAttribute("class", "fm_condition_fields");

	for(k=0; k<labels.length; k++) {
		var fields_option = document.createElement('option');
			fields_option.setAttribute("value", ids[k]);
			fields_option.innerHTML = labels[k];
			
		fields_select.appendChild(fields_option);
	}

	var span = document.createElement('span');
		span.innerHTML = 'if';	
				
	var all_any_select = document.createElement('select');
		all_any_select.setAttribute("id", "all_any"+num);
		all_any_select.setAttribute("name", "all_any"+num);
		all_any_select.setAttribute("class", "fm_condition_all_any");


	var all_option = document.createElement('option');
		all_option.setAttribute("value", "and");
		all_option.innerHTML = "all";

	var any_option = document.createElement('option');
		any_option.setAttribute("value", "or");
		any_option.innerHTML = "any";	
		
	all_any_select.appendChild(all_option);
	all_any_select.appendChild(any_option);

	var span1 = document.createElement('span');
    	span1.style.maxWidth ='235px';
    	span1.style.width ='100%';
    	span1.style.display='inline-block';
		span1.innerHTML = 'of the following match:';

	var add_icon = document.createElement('span');
		add_icon.setAttribute('class', 'dashicons dashicons-plus-alt');
		add_icon.setAttribute('onClick','add_condition_fields("'+num+'", "'+ids1+'", "'+labels1.replace(/\'/g,"\\'").replace(/\"/g,"&quot;")+'", "'+types1.replace(/\'/g,"\\'").replace(/\"/g,"&quot;")+'", "'+params1.replace(/\'/g,"\\'").replace(/\"/g,"&quot;")+'")');
	
	var delete_icon = document.createElement('span');
		delete_icon.setAttribute('class','dashicons dashicons-trash');
		delete_icon.setAttribute('onClick','delete_condition("'+num+'")');		
	
	conditional_fields_div.appendChild(show_hide_select);	
	conditional_fields_div.appendChild(document.createTextNode(' '));
	conditional_fields_div.appendChild(fields_select);
	conditional_fields_div.appendChild(document.createTextNode(' '));
	conditional_fields_div.appendChild(span);	
	conditional_fields_div.appendChild(document.createTextNode(' '));
	conditional_fields_div.appendChild(all_any_select);	
	conditional_fields_div.appendChild(document.createTextNode(' '));
	conditional_fields_div.appendChild(span1);	
	conditional_fields_div.appendChild(document.createTextNode(' '));
	conditional_fields_div.appendChild(delete_icon);	
	conditional_fields_div.appendChild(document.createTextNode(' '));
	conditional_fields_div.appendChild(add_icon);	

	condition_div.appendChild(conditional_fields_div);	
	document.getElementById('conditions_fieldset_wrap').appendChild(condition_div);	
}

function delete_condition(num) {
	document.getElementById('conditions_fieldset_wrap').removeChild(document.getElementById('condition'+num));	
}

function acces_level(length) {
	var value='';
	for(i=0; i<=parseInt(length); i++) {
    if (document.getElementById('user_'+i).checked) {
      value=value+document.getElementById('user_'+i).value+',';			
    }	
  }
	document.getElementById('user_id_wd').value=value;
}

function check_isnum_space(e) {
	var chCode1 = e.which || e.keyCode;	
	if (chCode1 ==32) {
		return true;
  }
  if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57)) {
		return false;
  }
	return true;
}

function check_isnum_point(e) {
  var chCode1 = e.which || e.keyCode;	
	if (chCode1 ==46) {
		return true;
	}
	if (chCode1 > 31 && (chCode1 < 48 || chCode1 > 57)) {
    return false;
  }
	return true;
}

function check_stripe_required_fields() {
  if (jQuery('#paypal_mode2').prop('checked')) {
    if (jQuery('#stripemode').val() == '1') {
      fields = ['live_sec', 'live_pub'];
      fields_titles = ['Live secret key', 'Live publishable key'];
    }
    else {
      fields = ['test_sec', 'test_pub'];
      fields_titles = ['Test secret key', 'Test publishable key'];
    }
    for (i=0; i < fields.length; i++) {
      if (!jQuery('#' + fields[i]).val()) {
        form_maker_options_tabs('payment');
        jQuery('#' + fields[i]).focus();
        alert(fields_titles[i] + ' is required.');
        return true;
      }
    }
  }
  return false;
}

function check_calculator_required_fields() {
	var empty_textarea = 0;
	jQuery(jQuery('#wd_calculated_field_table').find('[id^="wdc_equation_"]')).each(function() {
		if(jQuery( this ).val() == ''){
			var field_id = jQuery( this ).attr('id').replace('wdc_equation_','');
			var label_name = jQuery(jQuery('#wd_calculated_field_table').find("[data-field='" + field_id + "']")).html();
			empty_textarea = 1;
			jQuery( this ).focus();
			alert('Set equation for the field ' + label_name);
		}
		if(empty_textarea == 1)
			return false;
		});
	if(empty_textarea == 1)
		return true;
		
	return false;
}

function set_theme() {
  theme_id = jQuery('#theme').val() == '0' ? default_theme : jQuery('#theme').val();
  jQuery("#edit_css").attr("onclick", "window.open('"+ theme_edit_url +"&current_id=" + theme_id + "'); return false;");
  if (jQuery('#theme option:selected').attr('data-version') == 1) {
    jQuery("#old_theme_notice").show();
  }
  else {
    jQuery("#old_theme_notice").hide();
  }
}