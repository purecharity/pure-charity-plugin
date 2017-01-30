jQuery(function ($) {
    window.setTimeout(function () {
        jQuery(document).ready(function () {
            var main_color = jQuery("#main_color").val();
            jQuery("#main_color").spectrum({
                preferredFormat: "hex",
                color: main_color,
                showInitial: true,
                showInput: true
            });
        });
    }, 1000);

    $('.add-key').on('click', function () {
        var row = $(this).closest('td');
        row.find('fieldset').first().clone().insertAfter(row.find('fieldset').last()).find('input').val('');
    })

    $(document).on('click', '.remove-key', function () {
        if ($(this).closest('td').find('fieldset').length == '1') {
            alert('Sorry you couldn\'t remove last key');
            return false;
        }
        $(this).closest('fieldset').remove();
    });
})

// Back/more links
function toggle_link_fields(){
  var show_back_link = jQuery('input[name="purecharity_sponsorships_settings[back_link]"]');
  var show_more_link = jQuery('input[name="purecharity_sponsorships_settings[more_link]"]');
  
  if(jQuery(show_back_link).is(':checked')){
    jQuery(show_back_link).parents('tr').next().show();
  }else{
    jQuery(show_back_link).parents('tr').next().hide();
  }

  if(jQuery(show_more_link).is(':checked')){
    jQuery(show_more_link).parents('tr').next().show();
  }else{
    jQuery(show_more_link).parents('tr').next().hide();
  }
}


// Custom Fields manager
function save_custom_fields(){
  var custom_fields = Array();
  jQuery('li.custom_field').each(function(){
    custom_fields.push(jQuery(this).find('.right b:first').text()+'|'+jQuery(this).find('.left b:first').text())
  })
  jQuery('#custom_fields_value').val(custom_fields.join(';'))
  return false;
}

// Check if a field already exists
function field_exists(key){
  var exists = false;
  jQuery('.custom_field').each(function(){
    if(jQuery(this).find('.right b:first').text() == key){
      exists = true;
      return exists;
    }
  })
  return exists;
}

// Add a new example custom field
function new_example_custom_field(original, display){
  var html = '<li class="custom_field">'
      + '<div class="left">'
      + '<b>'+display+'</b>'
      + '<input type="text" value="'+display+'">'
      + ' <a href="#" class="edit">edit</a>'
      + ' <a href="#" class="save">save</a>'
      + '</div>'
      + '<div class="right">'
      + '<b>'+original+'</b>'
      + '<input type="text" value="'+original+'">'
      + ' <a href="#" class="edit">edit</a>'
      + ' <a href="#" class="save">save</a>'
      + '</div>'
      + '<div class="options">'
      + '<a href="#" class="remove">remove</a>'
      + '</div>'
      + '<br style="clear:both" />'
      + '</li>';
  jQuery('ul.pcs_custom_field:last').append(html);
}

// Add a new custom field
function new_custom_field(){
  var html = '<li class="custom_field">'
      + '<div class="left">'
      + '<b>Display Value</b>'
      + '<input type="text" value="Display Value">'
      + ' <a href="#" class="edit">edit</a>'
      + ' <a href="#" class="save">save</a>'
      + '</div>'
      + '<div class="right">'
      + '<b>CustomFieldIdentifier</b>'
      + '<input type="text" value="CustomFieldIdentifier">'
      + ' <a href="#" class="edit">edit</a>'
      + ' <a href="#" class="save">save</a>'
      + '</div>'
      + '<div class="options">'
      + '<a href="#" class="remove">remove</a>'
      + '</div>'
      + '<br style="clear:both" />'
      + '</li>';
  jQuery('ul.pcs_custom_field:last').append(html);
}

jQuery(function(jQuery) {
  jQuery(document).ready(function(){

    /* Show/hide back and more link options */
    toggle_link_fields(); // Initialize
    jQuery(document).on('change', 'input[name="purecharity_sponsorships_settings[more_link]"],input[name="purecharity_sponsorships_settings[back_link]"]', function(){
      toggle_link_fields();
    })
    /* Show/hide back and more link options */

    /* Custom Fields Sortable Config */
    jQuery( ".sortable" ).sortable({
      stop: function(){
        save_custom_fields();
      },
      axis: 'Y'
    });
    jQuery( ".sortable" ).disableSelection();

    jQuery(document).on('change', 'input[name="purecharity_sponsorships_settings[plugin_style]"]', function(){
      if(jQuery(this).val() == 'pure-sponsorships-option3'){
        jQuery('input[name="purecharity_sponsorships_settings[show_back_link]"]').attr({ disabled: false })
        jQuery('input[name="purecharity_sponsorships_settings[show_more_link]"]').attr({ disabled: false })
      }else{
        jQuery('input[name="purecharity_sponsorships_settings[show_back_link]"]').attr({ disabled: true })
        jQuery('input[name="purecharity_sponsorships_settings[show_more_link]"]').attr({ disabled: true })
      }
    })

    // For editing of each field
    jQuery(document).on('click', '.custom_field a.edit', function(){
      jQuery(this).hide();
      jQuery(this).parent().find('b').hide();
      jQuery(this).parent().find('input').show();
      jQuery(this).parent().find('.save').show();
      return false;
    })
    jQuery(document).on('click', '.custom_field a.save', function(){
      var text = jQuery(this).parent().find('input').val();
      if(text == ''){ alert("Value can't be empty."); return false; }
      jQuery(this).hide();
      jQuery(this).parent().find('b').show().text(text);
      jQuery(this).parent().find('input').hide();
      jQuery(this).parent().find('.edit').show();
      save_custom_fields();
      return false;
    })

    // Prevents enter tu submit the form
    jQuery(document).on('keydown', '.custom_field input', function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        jQuery(this).parent().find('.save').click();
        return false;
      }
    })
    jQuery(document).on('keydown', '#example-program-slug', function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        jQuery(this).next().click();
        return false;
      }
    })

    // Remove an item
    jQuery(document).on('click', '.custom_field .remove', function(event){
      if(confirm("Are you sure you want to remove this field?")){
        jQuery(this).parents('li').remove();
        save_custom_fields();
      }
      return false;
    })
    /* Custom Fields Sortable Config */

    jQuery('#custom-fields-example').on('click', function(){
      jQuery(this).hide()
      jQuery('#custom-fields-example-cancel').show()
      jQuery('#custom-fields-loader').show()
      return false;
    })
    jQuery('#custom-fields-example-cancel').on('click', function(){
      jQuery(this).hide()
      jQuery('#custom-fields-example').show()
      jQuery('#custom-fields-loader').hide()
      return false;
    })

    jQuery('#generate-example').on('click', function(){
      jQuery('#generate-example').text('Loading...');
      var slug = jQuery('#example-program-slug').val()

      jQuery.ajax({
        type: 'GET',
        url: jQuery(this).parent().attr('data-api-url')+slug,
        success: function(data){
          parsed_data = JSON.parse(data.custom_fields);

                var existing_fields = Array();
                Object.keys(parsed_data).forEach(function (key) {
                    if(field_exists(key)){
                        existing_fields.push(key);
                    }else{
                        new_example_custom_field(key, parsed_data[key]);
                    }
                });

                if(existing_fields.length > 0){
                    alert("The following fields already exist and were not imported:\n"+existing_fields.join('\n'))
                }
            },
        error: function(e){ console.log(e) },
            complete: function(data){
                jQuery('#generate-example').text('Load Example');
            }
      });
    });
  });
});
