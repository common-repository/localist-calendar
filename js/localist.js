jQuery('document').ready(function(e){
	jQuery('.widget_title input[name="wid_name"],.url input[type="text"]').bind("blur",function(e){
		//keydown keypress keyup
		if(jQuery(this).val()!=''){
			jQuery('.widget_title,.url').parent().parent().removeClass('form-invalid');
		}
		if(e.keyCode==13){
			e.preventDefault();
		}
	});


	jQuery('input[name="configure_widget"]').on('click',function(e){
		//e.preventDefault();
			var txt=jQuery('.url input[type="text"]').val();
			if(txt == ''){
				var mes='<p><strong>ERROR:</strong> Please enter a url.</p>'
				jQuery('.form-res').html('');
			    jQuery('.form-res').append(mes).addClass('error').removeClass('hide');
				jQuery('.url').parent().parent().addClass('form-invalid');
				e.preventDefault();
			}else if(is_valid_url(txt)!=1){
				jQuery('.form-res').html('');
				var mes='<p><strong>ERROR:</strong> Please enter a valid url.</p>'
			    jQuery('.form-res').append(mes).addClass('error').removeClass('hide');
				jQuery('.url').parent().parent().addClass('form-invalid');
				e.preventDefault();
			}else {
				jQuery('.url').parent().parent().removeClass('form-invalid');
				jQuery('.form-res').html('').addClass('hide');
				jQuery('#setting').submit();
			}

	});
	jQuery('input[name="save_widget"]').on('click',function(e){

		var name=jQuery('.widget_title input[name="wid_name"]').val();
		var txt=jQuery('.url input[type="text"]').val();
		var j='';
		var n='';
		if(name.length == 0){
			jQuery('.widget_title').parent().parent().addClass('form-invalid');
			e.preventDefault();
			var mes='<p><strong>ERROR:</strong> Please enter a valid name.</p>'
			jQuery('.form-res').html(mes).addClass('error').removeClass('hide');
		}else{
			j=1;
		}
		if(is_valid_url(txt)!=1){
			jQuery('.url').parent().parent().addClass('form-invalid');
			e.preventDefault();
			var mes='<p><strong>ERROR:</strong> Please enter a valid url.</p>'
			jQuery('.form-res').append(mes).addClass('error').removeClass('hide');
		}else{n=1;}
		if(n==1 && j==1){
				scriptgenration(txt,'noview');
				jQuery('.widget_title,.url').parent().parent().removeClass('form-invalid');
		}
	});

	jQuery('input[name="generate_embedded_code"]').click(function(e){
	// create a mainurl...
		var txt=jQuery('input[name="url"]').val();
		var view=jQuery(this).attr('view');
		scriptgenration(txt,view);
	});

	selection(jQuery('select[name="widget_type"] option:selected').val());
	jQuery('select[name="widget_type"]').change(function(e){
		selection(jQuery(this).find('option:selected').val(),'onchange');
	});
	jQuery('input[name="hide_desc"]').change(function() {
		hideshowcheckbox();
	});
});
jQuery(window).load(function(e){
	var st=jQuery('#configuration').attr('status');

	if(jQuery('.message').html()){
		var mes=jQuery('.message').html();
		jQuery('.form-res').html(mes).addClass('updated notice is-dismissible res').removeClass('hide');
	}
	if(jQuery('.err_message').html()){
		var mes=jQuery('.err_message').html();
		var err_url=jQuery('.err_url').html();
		jQuery('.url').parent().parent().addClass('form-invalid');
		jQuery('.form-res').html('');
		var mes='<p><strong>ERROR: </strong>'+jQuery('.err_message').html()+'</p>'
		jQuery('.form-res').html(mes).addClass('error').removeClass('hide');
		jQuery('#configuration').addClass('hide');
		jQuery('.url input[type="text"]').val('');
		jQuery('.url input[type="text"]').val(err_url);
	}else{
			jQuery('#configuration').removeClass('hide');
	}
	if(st=="edit" || st=="new"){
		var txt=jQuery('.url input[type="text"]').val();
		if(is_valid_url(txt)==1){
			jQuery('.display').css('display','block');
		}else{
			jQuery('.display').css('display','none');
		}

	}

	if(st=="edit"){
			jQuery('#configuration select').each(function(e){
				var value=jQuery(this).attr('sv');
				jQuery(this).find('option').each(function(e){
                  var opt=jQuery(this).val();
                    if(opt == value){
                        jQuery(this).prop('selected','selected');
                        jQuery(this).attr('selected','selected');
                    }
				});
			});
			jQuery('span[ftype="filters"]').each(function(e){
				var input= jQuery(this);
				if(input.attr('value')!= ''){
					var val=input.attr('value');
					var name=input.attr('name');
					jQuery('.filter_area select[fname="'+name+'"] option').each(function(e){
						var opt=jQuery(this).val();
						if(opt == val){
							jQuery(this).prop('selected','selected');
							jQuery(this).attr('selected','selected');
						}
					});
				}
			});
			jQuery('span[ftype="exclude_filters"]').each(function(e){
				var input= jQuery(this);
				if(input.attr('value')!= ''){
					var val=input.attr('value');
					var name=input.attr('name');
					jQuery('.excluded_filter_area select[fname="'+name+'"] option').each(function(e){
						var opt=jQuery(this).val();
						if(opt == val){
							jQuery(this).prop('selected','selected');
							jQuery(this).attr('selected','selected');
						}
					});
				}
			});
			selection(jQuery('select[name="widget_type"] option:selected').val(),'load');
			jQuery('span[ftype="groups"]').each(function(e){
				var input= jQuery(this);
				if(input.attr('value')!= ''){
					var val=input.attr('value');
					var name=input.attr('ftype');
					jQuery('select[ftype="'+name+'"] option').each(function(e){
						var opt=jQuery(this).val();
						if(opt == val){
							jQuery(this).prop('selected','selected');
							jQuery(this).attr('selected','selected');
						}
					});
				}
			});
			jQuery('span[ftype="places"]').each(function(e){
				var input= jQuery(this);
				if(input.attr('value')!= ''){
					var val=input.attr('value');
					var name=input.attr('ftype');
					jQuery('select[ftype="'+name+'"] option').each(function(e){
						var opt=jQuery(this).val();
						if(opt == val){
							jQuery(this).prop('selected','selected');
							jQuery(this).attr('selected','selected');
						}
					});
				}
			});
		}
	hideshowcheckbox();
});
function scriptgenration(txt,view){
	if(is_valid_url(txt) && txt != ''){
		var type=[];
		var exclude_type=[];
		var groups=[];
		var places=[];
		var mainurl=txt+'/widget/';
	//select list filters..
		var temp=jQuery('select[name="template"] option:selected').val();
		var community=jQuery('select[name="community"] option:selected').val();
		var match=jQuery('select[name="match"] option:selected').val();
		var style=jQuery('select[name="style"] option:selected').val();
		var widget_type=jQuery('select[name="widget_type"] option:selected').val();
		jQuery('select[ftype="groups"] option:selected').each(function(e){
			groups.push(jQuery(this).val());
		});
		var all_groups=groups.join('%2C');
		jQuery('select[ftype="places"] option:selected').each(function(e){
			places.push(jQuery(this).val());
		});
		var all_places=places.join('%2C');
	//input text type filters..
		var results=jQuery('input[name="results"]').val();
		var day=jQuery('input[name="day"]').val();
		var keywords=jQuery('input[name="keywords"]').val();
	//input checkbox type filters..
		var feature=jQuery('input[name="feature"]');
		var sponsored=jQuery('input[name="sponsored"]');
		var instances=jQuery('input[name="instances"]');
		var past_event=jQuery('input[name="past_event"]');
		var hide_desc=jQuery('input[name="hide_desc"]');
		var trunca_desc=jQuery('input[name="trunca_desc"]');
		var render_html=jQuery('input[name="render_html"]');
		var hide_image=jQuery('input[name="hide_image"]');
		var hide_time=jQuery('input[name="hide_time"]');
		var hide_dropdown=jQuery('input[name="hide_dropdown"]');
		var open_links=jQuery('input[name="open_links"]');
		var org_name=jQuery('input[name="organization_name"]').val();
		jQuery('#filters_area select').each(function(e){
			var val=jQuery(this).find('option:selected').each(function(e){
					type.push(jQuery(this).val());
			});

		});
		var types=type.join('%2C');

		jQuery('#filters_area_excluded select').each(function(e){
			var val=jQuery(this).find('option:selected').each(function(e){
					exclude_type.push(jQuery(this).val());
			});
		});
		var exclude_types=exclude_type.join('%2C');

	//condition here....
		if(widget_type && widget_type != ''){
			mainurl+=widget_type+'?';
		}
		if(org_name && org_name != ''){
			mainurl+='schools='+org_name;
		}
		if(temp && temp != ''){
			//mainurl+='template='+temp;
		}
		if(community && community != ''){
			mainurl+='campuses='+community;
		}
		if(all_groups && all_groups != ''){
			mainurl+='&groups='+all_groups;
		}
		if(all_places && all_places != ''){
			mainurl+='&venues='+all_places;
		}
		if(style && style == 'none'){
			mainurl+='&style='+style;
		}else if(style && style != 'none' && style != ''){
			mainurl+='&template='+style;
		}



		if(types && types != ''){
			mainurl+='&types='+types;
		}

		if(match && match != ''){
			mainurl+='&match='+match;
		}


		if(exclude_types && exclude_types != ''){
			mainurl+='&exclude_types='+exclude_types;
		}

		if(results && results != ''){
			mainurl+='&num='+results;
		}
		if(day && day != ''){
			mainurl+='&days='+day;
		}
		if(keywords && keywords != ''){
			mainurl+='&tags='+keywords;
		}
		if(feature.is(":checked")){
			mainurl+='&picks=1';
		}
		if(sponsored.is(":checked")){
			mainurl+='&sponsored=1';
		}
		if(instances.is(":checked")){
			mainurl+='&all_instances=1';
		}
		if(past_event.is(":checked")){
			mainurl+='&hide_past=1';
		}
		if(hide_desc.is(":checked")){
			mainurl+='&hidedesc=1';
		}
		if(trunca_desc.is(":checked")){
			mainurl+='&expand_descriptions=1';
		}
		if(render_html.is(":checked")){
			mainurl+='&html_descriptions=1';
		}
		if(hide_image.is(":checked")){
			mainurl+='&hideimage=1';
		}
		if(hide_time.is(":checked")){
			mainurl+='&show_times=0';
		}
		if(hide_dropdown.is(":checked")){
			mainurl+='&show_types=0';
		}
		if(open_links.is(":checked")){
			mainurl+='&target_blank=1';
		}

		jQuery('#generated_widget_url').val(mainurl);
		
		var scriptags = '<script type="text/javascript" src="'+mainurl+'"></script><div id="lclst_widget_footer"><a rel="nofollow" style="margin-left:auto;margin-right:auto;display:block;width:81px;margin-top:10px;" title="Widget powered by Localist Online Calendar Software" href="http://www.localist.com?utm_source=widget&utm_campaign=widget_footer&utm_medium=branded%20link"><img src="//d3e1o4bcbhmj8g.cloudfront.net/assets/platforms/default/about/widget_footer.png" alt="Localist Online Calendar Software" style="vertical-align: middle;" width="81" height="23"></a></div>';
		jQuery('#embed').val(' ');
		jQuery('#embed').val(scriptags);
		if(view == "view"){
			jQuery('.embed').css('display','block');
			jQuery('.form-res').html('').removeClass('error').addClass('hide');
		}else{
			jQuery('#configuration').submit();
		}
	}else{
		var mes='<p><strong>ERROR:</strong> Please enter a valid url.</p>'
		jQuery('.form-res').html('');
		jQuery('.form-res').append(mes).addClass('error').removeClass('hide');
		jQuery('.url').parent().parent().addClass('form-invalid');
	}
}
function is_valid_url(url) {
    return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url);
}
function selection(val,type){
	if(val =='combo'){
		jQuery('input[name="hide_dropdown"]').parent().parent().removeClass('hide');

	}else{
		jQuery('input[name="hide_dropdown"]').parent().parent().addClass('hide');
		if(type =='onchange'){
			jQuery('input[name="hide_dropdown"]').removeAttr('checked');
		}
	}
}
function hideshowcheckbox(){
	if(jQuery('input[name="hide_desc"]').is(':checked')){
			jQuery('input[name="trunca_desc"],input[name="render_html"]').removeAttr('checked').parent().parent().hide();
		}else{
			jQuery('input[name="trunca_desc"],input[name="render_html"]').parent().parent().show();
		}
}
