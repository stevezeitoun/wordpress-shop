jQuery(document).ready(function() {
  jQuery(".fm-themes-tabs li a").on("click", function(){
    jQuery(".fm-themes-tabs-container .fm-themes-container").hide();
    jQuery(".fm-themes-tabs li a").removeClass("fm-theme-active-tab");
    jQuery("#"+jQuery(this).attr("id")+'-content').show();
    jQuery(this).addClass("fm-theme-active-tab");
    jQuery("#active_tab").val(jQuery(this).attr("id"));
    return false;
  });
  jQuery('.color').spectrum({
    showAlpha: true,
    showInput: true,
    showSelectionPalette: true,
    preferredFormat: "hex",
    allowEmpty: true,
    move: function(color){
      jQuery(this).val(color);
      jQuery(this).trigger("change");
    },
    change: function(color){
      jQuery(this).val(color);
      jQuery(this).trigger("change");
    }
  });
  jQuery('.fm-preview-form').show();

  var fm_form_example_pos = jQuery('.form-example-preview').offset().top;
  jQuery(window).scroll(function () {
    if (jQuery(window).width() > 768 && jQuery(this).scrollTop() > fm_form_example_pos - 32) {
      jQuery('.form-example-preview').css({
        'position': 'fixed',
        'top': '32px',
        'z-index': '10000',
        'width': jQuery(".form-example-preview").outerWidth() + 'px'
      });
    }
    else {
      jQuery('.form-example-preview').css({'position': 'relative', 'top': '0', 'z-index': '', 'width': ''});
    }
  });
});

angular.module('ThemeParams', []).controller('FMTheme', function($scope) {
    $scope.DefaultVar = DefaultVar;
});

function submitbutton(version) {
  var all_params = '';
  if (version == 1) {
    all_params = jQuery('textarea[name=CUPCSS]').serializeObject();
  }
  else {
    all_params = jQuery('#form_maker_themes').serializeObject();
  }
  jQuery('#params').val(JSON.stringify(all_params).replace(plugin_url, '[SITE_ROOT]'));
  return true;
}