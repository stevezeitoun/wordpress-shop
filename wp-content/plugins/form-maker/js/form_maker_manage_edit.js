/**
 * Check if form is changed but not saved.
 */
jQuery(window).on('beforeunload', function() {
	form_changed = !FormManageSubmitButton(true);
	if (form_changed) {
		return 'Changes you made may not be saved.';
	}
});

jQuery(window).on("load", function () {
	formOnload(gen);
});

jQuery( document ).ready(function() {
	jQuery('.wdform_section .wdform_column:last-child').each(function() {
	  if (jQuery(this).html()) {
      jQuery(this).parent().append(jQuery('<div></div>').addClass("wdform_column"));
    }
	});

	sortable_columns();
	if( is_sortable == 1) {
		jQuery( ".wdform_arrows_advanced" ).hide();
	}
	else {
		jQuery('.wdform_column').sortable( "disable" );
		jQuery( ".wdform_arrows_advanced" ).show();
	}
  all_sortable_events();
});

/**
* Prepare form to save.
*
* @param check_for_changes
* @returns {boolean}
*/
function FormManageSubmitButton(check_for_changes) {
  if (check_for_changes == undefined) {
    check_for_changes = false;
    jQuery(window).off('beforeunload');
  }
  tox = '';
  form_fields = '';
  if (!check_for_changes) {
    document.getElementById('take').style.display = "none";
    document.getElementById('page_bar').style.display = "none";
  }
  jQuery('#saving').html('<div class="fm-loading-container"><div class="fm-loading-content"></div></div>');
  jQuery('.wdform_section').each(function () {
    var this2 = this;
    jQuery(this2).find('.wdform_column').each(function () {
      if (!jQuery(this).html() && jQuery(this2).children().length > 1) {
        jQuery(this).remove();
      }
    });
  });

  remove_whitespace(document.getElementById('take'));
  l_id_array = labels_id_array;
  l_label_array = labels_label_array;
  l_type_array = labels_type_array;
  l_id_removed = [];

  for (x = 0; x < l_id_array.length; x++) {
    l_id_removed[l_id_array[x]] = true;
  }

  for (t = 1; t <= form_view_max; t++) {
    if (document.getElementById('form_id_tempform_view' + t)) {
      wdform_page = document.getElementById('form_id_tempform_view' + t);
      remove_whitespace(wdform_page);
      n = wdform_page.childNodes.length - 2;
      for (q = 0; q <= n; q++) {
        if (!wdform_page.childNodes[q].getAttribute("wdid")) {
          wdform_section = wdform_page.childNodes[q];
          for (x = 0; x < wdform_section.childNodes.length; x++) {
            wdform_column = wdform_section.childNodes[x];
            if (wdform_column.firstChild) {
              for (y = 0; y < wdform_column.childNodes.length; y++) {
                is_in_old = false;
                wdform_row = wdform_column.childNodes[y];
                if (wdform_row.nodeType == 3) {
                  continue;
                }
                wdid = wdform_row.getAttribute("wdid");
                if (!wdid) {
                  continue;
                }
                l_id = wdid;
                l_label = document.getElementById(wdid + '_element_labelform_id_temp').innerHTML;
                l_label = l_label.replace(/(\r\n|\n|\r)/gm, " ");
                wdtype = wdform_row.firstChild.getAttribute('type');

                for (var z = 0; z < l_id_array.length; z++) {
                  if (l_type_array[z] == "type_address") {
                    if (document.getElementById(l_id + "_mini_label_street1") || document.getElementById(l_id + "_mini_label_street2") || document.getElementById(l_id + "_mini_label_city") || document.getElementById(l_id + "_mini_label_state") || document.getElementById(l_id + "_mini_label_postal") || document.getElementById(l_id + "_mini_label_country")) {
                      l_id_removed[l_id_array[z]] = false;
                    }
                  }
                  else {
                    if (l_id_array[z] == wdid) {
                      l_id_removed[l_id] = false;
                    }
                  }
                }

                if (wdtype == "type_address") {
                  addr_id = parseInt(wdid);
                  id_for_country = addr_id;
                  if (document.getElementById(id_for_country + "_mini_label_street1")) {
                    tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_street1").innerHTML + '#**label**#type_address#****#';
                  }
                  addr_id++;
                  if (document.getElementById(id_for_country + "_mini_label_street2")) {
                    tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_street2").innerHTML + '#**label**#type_address#****#';
                  }
                  addr_id++;
                  if (document.getElementById(id_for_country + "_mini_label_city")) {
                    tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_city").innerHTML + '#**label**#type_address#****#';
                  }
                  addr_id++;
                  if (document.getElementById(id_for_country + "_mini_label_state")) {
                    tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_state").innerHTML + '#**label**#type_address#****#';
                  }
                  addr_id++;
                  if (document.getElementById(id_for_country + "_mini_label_postal")) {
                    tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_postal").innerHTML + '#**label**#type_address#****#';
                  }
                  addr_id++;
                  if (document.getElementById(id_for_country + "_mini_label_country")) {
                    tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_country").innerHTML + '#**label**#type_address#****#';
                  }
                }
                else {
                  tox = tox + wdid + '#**id**#' + l_label + '#**label**#' + wdtype + '#****#';
                }

                id = wdid;
                form_fields += wdid + "*:*id*:*";
                form_fields += wdtype + "*:*type*:*";
                w_choices = new Array();
                w_choices_value = new Array();
                w_choices_checked = new Array();
                w_choices_disabled = new Array();
                w_choices_params = new Array();
                w_allow_other_num = 0;
                w_property = new Array();
                w_property_type = new Array();
                w_property_values = new Array();
                w_choices_price = new Array();
                if (document.getElementById(id + '_element_labelform_id_temp').innerHTML) {
                  w_field_label = document.getElementById(id + '_element_labelform_id_temp').innerHTML.replace(/(\r\n|\n|\r)/gm, " ");
                }
                else {
                  w_field_label = " ";
                }
                if (document.getElementById(id + '_label_sectionform_id_temp')) {
                  if (document.getElementById(id + '_label_sectionform_id_temp').style.display == "block") {
                    w_field_label_pos = "top";
                  }
                  else {
                    w_field_label_pos = "left";
                  }
                }
                if (document.getElementById(id + "_elementform_id_temp")) {
                  s = document.getElementById(id + "_elementform_id_temp").style.width;
                  w_size = s.substring(0, s.length - 2);
                }
                if (document.getElementById(id + "_label_sectionform_id_temp")) {
                  s = document.getElementById(id + "_label_sectionform_id_temp").style.width;
                  w_field_label_size = s.substring(0, s.length - 2);
                }
                if (document.getElementById(id + "_requiredform_id_temp")) {
                  w_required = document.getElementById(id + "_requiredform_id_temp").value;
                }
                if (document.getElementById(id + "_uniqueform_id_temp")) {
                  w_unique = document.getElementById(id + "_uniqueform_id_temp").value;
                }
                if (document.getElementById(id + '_label_sectionform_id_temp')) {
                  w_class = document.getElementById(id + '_label_sectionform_id_temp').getAttribute("class");
                  if (!w_class) {
                    w_class = "";
                  }
                }
                gen_form_fields();
                if (!check_for_changes) {
                  wdform_row.innerHTML = "%" + id + " - " + l_label + "%";
                }
              }
            }
          }
        }
        else {
          id = wdform_page.childNodes[q].getAttribute("wdid");
          w_editor = document.getElementById(id + "_element_sectionform_id_temp").innerHTML;
          form_fields += id + "*:*id*:*";
          form_fields += "type_section_break" + "*:*type*:*";
          form_fields += "custom_" + id + "*:*w_field_label*:*";
          form_fields += w_editor + "*:*w_editor*:*";
          form_fields += "*:*new_field*:*";
          if (!check_for_changes) {
            wdform_page.childNodes[q].innerHTML = "%" + id + " - " + "custom_" + id + "%";
          }
        }
      }
    }
  }
  if (!check_for_changes) {
    document.getElementById('label_order_current').value = tox;
  }

  for (x = 0; x < l_id_array.length; x++) {
    if (l_id_removed[l_id_array[x]]) {
      tox = tox + l_id_array[x] + '#**id**#' + l_label_array[x] + '#**label**#' + l_type_array[x] + '#****#';
    }
  }
  if (!check_for_changes) {
    document.getElementById('label_order').value = tox;
    document.getElementById('form_fields').value = form_fields;
    refresh_();
    document.getElementById('pagination').value = document.getElementById('pages').getAttribute("type");
    document.getElementById('show_title').value = document.getElementById('pages').getAttribute("show_title");
    document.getElementById('show_numbers').value = document.getElementById('pages').getAttribute("show_numbers");
  }
  form_changed = false;
  if (check_for_changes) {
    if (form_fields != form_fields_initial) {
      form_changed = true;
    }
    jQuery('.fm-check-change').each(function () {
      if (jQuery(this).val() != jQuery(this).attr('data-initial-value')) {
        form_changed = true;
      }
    });
    if (tinyMCE.get('header_description') != null) {
      if (tinyMCE.get('header_description').isDirty()) {
        form_changed = true;
      }
    }
    var header_description_initial = decodeURIComponent(jQuery('#header_description_initial_value').val());
    var header_description = jQuery('#header_description').val();
    if (jQuery('<span>' + header_description_initial + '</span>').html() != jQuery('<span>' + header_description + '</span>').html()) {
      form_changed = true;
    }
    if (jQuery("#header_hide_image").prop('checked') != (jQuery("#header_hide_image").attr('data-initial-value') == 1)) {
      form_changed = true;
    }
  }
  return !check_for_changes || !form_changed;
}
	
function formOnload(rows) {
	for (t = 0; t < rows; t++) {
		if (document.getElementById(t + "_typeform_id_temp")) {
			if (document.getElementById(t + "_typeform_id_temp").value == "type_map" || document.getElementById(t + "_typeform_id_temp").value == "type_mark_map") {
				if_gmap_init(t);
				for (q = 0; q < 20; q++) {
					if (document.getElementById(t + "_elementform_id_temp").getAttribute("long" + q)) {
						w_long = parseFloat(document.getElementById(t + "_elementform_id_temp").getAttribute("long" + q));
						w_lat = parseFloat(document.getElementById(t + "_elementform_id_temp").getAttribute("lat" + q));
						w_info = parseFloat(document.getElementById(t + "_elementform_id_temp").getAttribute("info" + q));
						add_marker_on_map(t, q, w_long, w_lat, w_info, false);
					}
				}
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_name") {
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("#" + myu + "_mini_label_first").on("click", function () {
						if (jQuery(this).children('input').length == 0) {
							var first = "<input type='text' id='first' class='first' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(first);
							jQuery("input.first").focus();
							jQuery("input.first").blur(function () {
								var id_for_blur = document.getElementById('first').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_first").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_last").on("click", function () {
						if (jQuery(this).children('input').length == 0) {
							var last = "<input type='text' id='last' class='last'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(last);
							jQuery("input.last").focus();
							jQuery("input.last").blur(function () {
								var id_for_blur = document.getElementById('last').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_last").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_title").on("click", function () {
						if (jQuery(this).children('input').length == 0) {
							var title_ = "<input type='text' id='title_' class='title_'  style='outline:none; border:none; background:none; width:50px;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(title_);
							jQuery("input.title_").focus();
							jQuery("input.title_").blur(function () {
								var id_for_blur = document.getElementById('title_').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_title").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_middle").on("click", function () {
						if (jQuery(this).children('input').length == 0) {
							var middle = "<input type='text' id='middle' class='middle'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(middle);
							jQuery("input.middle").focus();
							jQuery("input.middle").blur(function () {
								var id_for_blur = document.getElementById('middle').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_middle").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_phone") {
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("label#" + myu + "_mini_label_area_code").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var area_code = "<input type='text' id='area_code' class='area_code' size='10' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(area_code);
							jQuery("input.area_code").focus();
							jQuery("input.area_code").blur(function () {
								var id_for_blur = document.getElementById('area_code').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_area_code").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_phone_number").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var phone_number = "<input type='text' id='phone_number' class='phone_number'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(phone_number);
							jQuery("input.phone_number").focus();
							jQuery("input.phone_number").blur(function () {
								var id_for_blur = document.getElementById('phone_number').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_phone_number").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_date_fields") {
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("label#" + myu + "_day_label").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var day = "<input type='text' id='day' class='day' size='8' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(day);
							jQuery("input.day").focus();
							jQuery("input.day").blur(function () {
								var id_for_blur = document.getElementById('day').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_day_label").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_month_label").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var month = "<input type='text' id='month' class='month' size='8' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(month);
							jQuery("input.month").focus();
							jQuery("input.month").blur(function () {
								var id_for_blur = document.getElementById('month').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_month_label").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_year_label").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var year = "<input type='text' id='year' class='year' size='8' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(year);
							jQuery("input.year").focus();
							jQuery("input.year").blur(function () {
								var id_for_blur = document.getElementById('year').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_year_label").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_time") {
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("label#" + myu + "_mini_label_hh").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var hh = "<input type='text' id='hh' class='hh' size='4' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(hh);
							jQuery("input.hh").focus();
							jQuery("input.hh").blur(function () {
								var id_for_blur = document.getElementById('hh').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_hh").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_mm").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var mm = "<input type='text' id='mm' class='mm' size='4' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(mm);
							jQuery("input.mm").focus();
							jQuery("input.mm").blur(function () {
								var id_for_blur = document.getElementById('mm').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_mm").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_ss").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var ss = "<input type='text' id='ss' class='ss' size='4' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(ss);
							jQuery("input.ss").focus();
							jQuery("input.ss").blur(function () {
								var id_for_blur = document.getElementById('ss').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_ss").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_am_pm").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var am_pm = "<input type='text' id='am_pm' class='am_pm' size='4' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(am_pm);
							jQuery("input.am_pm").focus();
							jQuery("input.am_pm").blur(function () {
								var id_for_blur = document.getElementById('am_pm').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_am_pm").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_paypal_price") {
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("#" + myu + "_mini_label_dollars").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var dollars = "<input type='text' id='dollars' class='dollars' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(dollars);
							jQuery("input.dollars").focus();
							jQuery("input.dollars").blur(function () {
								var id_for_blur = document.getElementById('dollars').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_dollars").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_cents").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var cents = "<input type='text' id='cents' class='cents'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(cents);
							jQuery("input.cents").focus();
							jQuery("input.cents").blur(function () {
								var id_for_blur = document.getElementById('cents').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_cents").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_address") {
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("label#" + myu + "_mini_label_street1").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var street1 = "<input type='text' id='street1' class='street1' style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(street1);
							jQuery("input.street1").focus();
							jQuery("input.street1").blur(function () {
								var id_for_blur = document.getElementById('street1').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_street1").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_street2").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var street2 = "<input type='text' id='street2' class='street2'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(street2);
							jQuery("input.street2").focus();
							jQuery("input.street2").blur(function () {
								var id_for_blur = document.getElementById('street2').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_street2").text(value);
						  });
						}
					});
					jQuery("label#" + myu + "_mini_label_city").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var city = "<input type='text' id='city' class='city'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(city);
							jQuery("input.city").focus();
							jQuery("input.city").blur(function () {
								var id_for_blur = document.getElementById('city').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_city").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_state").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var state = "<input type='text' id='state' class='state'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(state);
							jQuery("input.state").focus();
							jQuery("input.state").blur(function () {
								var id_for_blur = document.getElementById('state').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_state").text(value);
						  });
						}
					});
					jQuery("label#" + myu + "_mini_label_postal").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var postal = "<input type='text' id='postal' class='postal'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(postal);
							jQuery("input.postal").focus();
							jQuery("input.postal").blur(function () {
								var id_for_blur = document.getElementById('postal').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_postal").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_country").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var country = "<input type='country' id='country' class='country'  style='outline:none; border:none; background:none;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(country);
							jQuery("input.country").focus();
							jQuery("input.country").blur(function () {
								var id_for_blur = document.getElementById('country').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_country").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_scale_rating") {
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("#" + myu + "_mini_label_worst").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var worst = "<input type='text' id='worst' class='worst' size='6' style='outline:none; border:none; background:none; font-size:11px;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(worst);
							jQuery("input.worst").focus();
							jQuery("input.worst").blur(function () {
								var id_for_blur = document.getElementById('worst').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_worst").text(value);
						  });
						}
					});
					jQuery("label#" + myu + "_mini_label_best").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var best = "<input type='text' id='best' class='best' size='6' style='outline:none; border:none; background:none; font-size:11px;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(best);
							jQuery("input.best").focus();
							jQuery("input.best").blur(function () {
								var id_for_blur = document.getElementById('best').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_best").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_spinner") {
				var spinner_value = document.getElementById(t + "_elementform_id_temp").value;
				var spinner_min_value = document.getElementById(t + "_min_valueform_id_temp").value;
				var spinner_max_value = document.getElementById(t + "_max_valueform_id_temp").value;
				var spinner_step = document.getElementById(t + "_stepform_id_temp").value;
				jQuery("#" + t + "_elementform_id_temp")[0].spin = null;
				spinner = jQuery("#" + t + "_elementform_id_temp").spinner();
				if ( spinner_value == null ) {
          spinner.spinner("value", "");
        }
				jQuery("#" + t + "_elementform_id_temp").spinner({ min:spinner_min_value});
				jQuery("#" + t + "_elementform_id_temp").spinner({ max:spinner_max_value});
				jQuery("#" + t + "_elementform_id_temp").spinner({ step:spinner_step});
				}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_slider") {
				var slider_value = document.getElementById(t + "_slider_valueform_id_temp").value;
				var slider_min_value = document.getElementById(t + "_slider_min_valueform_id_temp").value;
				var slider_max_value = document.getElementById(t + "_slider_max_valueform_id_temp").value;
				var slider_element_value = document.getElementById(t + "_element_valueform_id_temp");
				var slider_value_save = document.getElementById(t + "_slider_valueform_id_temp");
				jQuery("#" + t + "_elementform_id_temp")[0].slide = null;
				jQuery(function () {
					jQuery("#" + t + "_elementform_id_temp").slider({
						range:"min",
						value:eval(slider_value),
						min:eval(slider_min_value),
						max:eval(slider_max_value),
						slide:function (event, ui) {
							slider_element_value.innerHTML = "" + ui.value;
							slider_value_save.value = "" + ui.value;
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_range") {
				var spinner_value0 = document.getElementById(t + "_elementform_id_temp0").value;
				var spinner_step = document.getElementById(t + "_range_stepform_id_temp").value;
				jQuery("#" + t + "_elementform_id_temp0")[0].spin = null;
				jQuery("#" + t + "_elementform_id_temp1")[0].spin = null;
				spinner0 = jQuery("#" + t + "_elementform_id_temp0").spinner();
				if ( spinner_value0 == null ) {
          spinner0.spinner("value", "");
        }
				jQuery("#" + t + "_elementform_id_temp0").spinner({ step:spinner_step});
				var spinner_value1 = document.getElementById(t + "_elementform_id_temp1").value;
				spinner1 = jQuery("#" + t + "_elementform_id_temp1").spinner();
				if ( spinner_value1 == null ) {
          spinner1.spinner("value", "");
        }
				jQuery("#" + t + "_elementform_id_temp1").spinner({ step:spinner_step});
				var myu = t;
				jQuery(document).ready(function () {
					jQuery("#" + myu + "_mini_label_from").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var from = "<input type='text' id='from' class='from' size='6' style='outline:none; border:none; background:none; font-size:11px;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(from);
							jQuery("input.from").focus();
							jQuery("input.from").blur(function () {
								var id_for_blur = document.getElementById('from').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_from").text(value);
							});
						}
					});
					jQuery("label#" + myu + "_mini_label_to").click(function () {
						if (jQuery(this).children('input').length == 0) {
							var to = "<input type='text' id='to' class='to' size='6' style='outline:none; border:none; background:none; font-size:11px;' value=\"" + jQuery(this).text() + "\">";
							jQuery(this).html(to);
							jQuery("input.to").focus();
							jQuery("input.to").blur(function () {
								var id_for_blur = document.getElementById('to').parentNode.id.split('_');
								var value = jQuery(this).val();
								jQuery("#" + id_for_blur[0] + "_mini_label_to").text(value);
							});
						}
					});
				});
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_date_range") {
				var default_date_start = jQuery("#"+t+"_default_date_id_temp_start").val();
				var default_date_end = jQuery("#"+t+"_default_date_id_temp_end").val();
				var date_format = jQuery("#"+t+"_buttonform_id_temp").attr('format');

				jQuery("#"+t+"_elementform_id_temp0").datepicker();
				jQuery("#"+t+"_elementform_id_temp1").datepicker();
				jQuery("#"+t+"_elementform_id_temp0").datepicker("option", "dateFormat", date_format);
				jQuery("#"+t+"_elementform_id_temp1").datepicker("option", "dateFormat", date_format);

				if(default_date_start =="today")
					jQuery("#"+t+"_elementform_id_temp0").datepicker("setDate", new Date());
				else if(default_date_start.indexOf("d") == -1 && default_date_start.indexOf("m") == -1 && default_date_start.indexOf("y") == -1 && default_date_start.indexOf("w") == -1){
					if(default_date_start !== "")
						default_date_start = jQuery.datepicker.formatDate(date_format, new Date(default_date_start));
					jQuery("#"+t+"_elementform_id_temp0").datepicker("setDate", default_date_start);
				}
				else
					jQuery("#"+t+"_elementform_id_temp0").datepicker("setDate", default_date_start);


				if(default_date_end =="today")
					jQuery("#"+t+"_elementform_id_temp1").datepicker("setDate", new Date());
				else if(default_date_end.indexOf("d") == -1 && default_date_end.indexOf("m") == -1 && default_date_end.indexOf("y") == -1 && default_date_end.indexOf("w") == -1){
					if(default_date_end !== "")
						default_date_end = jQuery.datepicker.formatDate(date_format, new Date(default_date_end));
					jQuery("#"+t+"_elementform_id_temp1").datepicker("setDate", default_date_end);
				}
				else
					jQuery("#"+t+"_elementform_id_temp1").datepicker("setDate", default_date_end);
			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_date_new") {
				var default_date = jQuery("#"+t+"_default_date_id_temp").val();
				var date_format = jQuery("#"+t+"_buttonform_id_temp").attr('format');
				jQuery("#"+t+"_elementform_id_temp").datepicker();
				jQuery("#"+t+"_elementform_id_temp").datepicker("option", "dateFormat", date_format);

				if(default_date =="today")
					jQuery("#"+t+"_elementform_id_temp").datepicker("setDate", new Date());
				else if(default_date.indexOf("d") == -1 && default_date.indexOf("m") == -1 && default_date.indexOf("y") == -1 && default_date.indexOf("w") == -1){
					if(default_date !== "")
						default_date = jQuery.datepicker.formatDate(date_format, new Date(default_date));
					jQuery("#"+t+"_elementform_id_temp").datepicker("setDate", default_date);
				}
				else
					jQuery("#"+t+"_elementform_id_temp").datepicker("setDate", default_date);

			}
			else if (document.getElementById(t + "_typeform_id_temp").value == "type_phone_new") {

				jQuery("#"+t+"_elementform_id_temp").intlTelInput({
					nationalMode: false,
					preferredCountries: [ jQuery("#"+t+"_elementform_id_temp").attr("top-country") ],
				});
				
				jQuery("#"+t+"_elementform_id_temp").intlTelInput("setNumber", jQuery("#"+t+"_elementform_id_temp").val());
			}
		}
	}

	remove_whitespace(document.getElementById('take'));
	form_view = 1;
	
    var form_view_count = jQuery('.wdform-page-and-images').length;

    jQuery( '.wdform-page-and-images' ).each(function() {
        var index = jQuery(this).find('.wdform_page').attr('id').split("form_id_tempform_view");
        i = index[1];
        form_view_max = i;
		page_toolbar_wrap = document.createElement('div');
		page_toolbar_wrap.setAttribute('id', 'form_id_tempform_view_img' + i);
		page_toolbar_wrap.setAttribute('class', 'form_id_tempform_view_img');

		page_title = document.createElement('div');
		page_title.innerHTML = document.getElementById('form_id_tempform_view' + i).getAttribute('page_title');
		page_toolbar_wrap.appendChild(page_title);

		page_toolbar = document.createElement('div');

		var icon_show_hide = document.createElement('span');
		icon_show_hide.setAttribute('title', 'Show or hide the page');
		icon_show_hide.setAttribute("class", "page_toolbar dashicons dashicons-arrow-up-alt2");
		icon_show_hide.setAttribute('id', 'show_page_img_' + i);
		icon_show_hide.setAttribute('onClick', 'show_or_hide("' + i + '"); change_show_hide_icon(this);');

		var icon_remove = document.createElement("span");
		icon_remove.setAttribute('title', 'Delete the page');
		icon_remove.setAttribute("class", "page_toolbar dashicons dashicons-no");
		icon_remove.setAttribute("onclick", 'remove_page("' + i + '")');

		var icon_delete = document.createElement("span");
		icon_delete.setAttribute('title', 'Delete the page with fields');
		icon_delete.setAttribute("class", "page_toolbar dashicons dashicons-dismiss");
		icon_delete.setAttribute("onclick", 'remove_page_all("' + i + '")');

		var icon_edit = document.createElement("span");
		icon_edit.setAttribute('title', 'Edit the page');
		icon_edit.setAttribute("class", "page_toolbar dashicons dashicons-edit");
		icon_edit.setAttribute("onclick", 'edit_page_break("' + i + '")');

		page_toolbar.appendChild(icon_show_hide);
		page_toolbar.appendChild(icon_remove);
		page_toolbar.appendChild(icon_delete);
		page_toolbar.appendChild(icon_edit);
		page_toolbar_wrap.appendChild(page_toolbar);
		var cur_page = document.getElementById('form_id_tempform_view' + i).parentNode;
		cur_page.insertBefore(page_toolbar_wrap, cur_page.childNodes[0]);
    });

	if (form_view_count > 1) {
        firstid = jQuery('.wdform_page').first().attr('id');
        firstid = firstid.split("form_id_tempform_view");
        first_form_view = firstid[1]

        form_view = form_view_max;
		need_enable = false;
		generate_page_nav(first_form_view);
		var icon_edit = document.createElement("span");
			icon_edit.setAttribute("class", "dashicons dashicons-edit");
			icon_edit.setAttribute("onclick", 'el_page_navigation()');
		var edit_page_navigation = document.getElementById("edit_page_navigation");
			edit_page_navigation.appendChild(icon_edit);
		document.getElementById('page_navigation').appendChild(edit_page_navigation);
	}

	if (form_view_count == 1) {
    jQuery(".form_id_tempform_view_img").addClass("form_view_hide");
	}
}

function change_show_hide_icon(obj){
  jQuery(obj).toggleClass('dashicons-arrow-up-alt2').toggleClass('dashicons-arrow-down-alt2');
}

function edit_page_break(id) {
  enable2();
  document.getElementById('editing_id').value = id;
  form_view_element = document.getElementById('form_id_tempform_view' + id);
  page_title = form_view_element.getAttribute('page_title');
  if (form_view_element.getAttribute('next_title')) {
    next_title = form_view_element.getAttribute('next_title');
    next_type = form_view_element.getAttribute('next_type');
    next_class = form_view_element.getAttribute('next_class');
    next_checkable = form_view_element.getAttribute('next_checkable');
    previous_title = form_view_element.getAttribute('previous_title');
    previous_type = form_view_element.getAttribute('previous_type');
    previous_class = form_view_element.getAttribute('previous_class');
    previous_checkable = form_view_element.getAttribute('previous_checkable');
    w_title = [next_title, previous_title];
    w_type = [next_type, previous_type];
    w_class = [next_class, previous_class];
    w_check = [next_checkable, previous_checkable];
  }
  else {
    w_title = ["Next", "Previous"];
    w_type = ["text", "text"];
    w_class = ["", ""];
    w_check = ['true', 'true'];
  }
  w_attr_name = [];
  w_attr_value = [];
  type_page_break(id, page_title, w_title, w_type, w_class, w_check, w_attr_name, w_attr_value);
}