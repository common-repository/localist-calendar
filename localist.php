<?php
/**
* Plugin Name: Localist Calendar for WordPress
* Plugin URI: http://www.localist.com
* Description: The most powerful way to highlight events on your WordPress website.
* Version: 1.0
* Author: Localist Corporation
* Author URI: http://localist.com
* License: GPLv2+
*/



/** Step 2 (from text above). */
add_action( 'admin_menu', 'localist_menu' );


/** Step 1. */
function localist_menu() {
	add_menu_page('Localist Options', 'Localist Calendar', 'manage_options', 'localist_calendar_setting','localist_options','dashicons-calendar');
	add_submenu_page('localist_calendar_setting','Add New Widget','Add New Widget','manage_options','localist_calendar_setting');
}

/** Step 3. */
function localist_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<?php
	 if(isset($_GET['id']) && intval($_GET['id']) > 0){
		 $id = intval($_GET['id']);
		global $wpdb;
		$table = $wpdb->prefix.'localistCalendar';
		$sql= $wpdb->prepare("SELECT * FROM `".$table."` where `id`= %d", $id);
		$results = $wpdb->get_results($sql) or die('Record does not exist.');

			$widget_id=$results[0]->widget_id;
			$widget_data=$results[0]->data;
			$data=unserialize($widget_data);

			$data_name=$data['wid_name'];
			$data_url=$data['url'];
			if(isset($data['template'])){
				$data_template=$data['template'];
			}else{
				$data_template='';
			}
			if(isset($data['community'])){
				$data_community=$data['community'];
			}else{
				$data_community='';
			}
			$data_results=$data['results'];
			$data_day=$data['day'];
			if(isset($data['keywords'])){
				$data_keywords=$data['keywords'];
			}else{
				$data_keywords='';
			}
			if(isset($data['match'])){
				$data_match=$data['match'];
			}else{
				$data_match='';
			}
			if(isset($data['feature'])){
				$data_feature=$data['feature'];
			}else{
				$data_feature='';
			}
			if(isset($data['sponsored'])){
				$data_sponsored=$data['sponsored'];
			}else{
				$data_sponsored='';
			}
			if(isset($data['instances'])){
				$data_instances=$data['instances'];
			}else{
				$data_instances='';
			}
			if(isset($data['past_event'])){
				$data_past_event=$data['past_event'];
			}else{
				$data_past_event='';
			}
			if(isset($data['past_event'])){
				$data_past_event=$data['past_event'];
			}else{
				$data_past_event='';
			}
			if(isset($data['widget_type'])){
				$data_widget_type=$data['widget_type'];
			}else{
				$data_widget_type='';
			}
			if(isset($data['hide_desc'])){
				$data_hide_desc=$data['hide_desc'];
			}else{
				$data_hide_desc='';
			}
			if(isset($data['trunca_desc'])){
				$data_trunca_desc=$data['trunca_desc'];
			}else{
				$data_trunca_desc='';
			}
			if(isset($data['render_html'])){
				$data_render_html=$data['render_html'];
			}else{
				$data_render_html='';
			}
			if(isset($data['hide_image'])){
				$data_hide_image=$data['hide_image'];
			}else{
				$data_hide_image='';
			}
			if(isset($data['hide_time'])){
				$data_hide_time=$data['hide_time'];
			}else{
				$data_hide_time='';
			}
			if(isset($data['hide_dropdown'])){
				$data_hide_dropdown=$data['hide_dropdown'];
			}else{
				$data_hide_dropdown='';
			}
			if(isset($data['open_links'])){
				$data_open_links=$data['open_links'];
			}else{
				$data_open_links='';
			}
			if(isset($data['style'])){
				$data_style=$data['style'];
			}else{
				$data_style='';
			}
			$status="edit";

			$filters='';
			if(isset($data['filters'])){
				foreach($data['filters'] as $k => $v){
					if(isset($v) && !empty($v)){
						foreach($v as $j=>$c){
							if($c !=''){$filters.='<span class="hide" value="'.esc_attr($c).'" name="'.esc_attr($k).'" ftype="filters"></span>';}
						}
					}
				}
			}
			$exclude_filters='';
			if(isset($data['exclude_filters'])){
				foreach($data['exclude_filters'] as $k => $v){
					if(isset($v) && !empty($v)){
						foreach($v as $j=>$c){
							if($c !=''){$exclude_filters.='<span class="hide" value="'.esc_attr($c).'" name="'.esc_attr($k).'" ftype="exclude_filters"></span>';}
						}
					}
				}
			}
			$groups='';
			if(isset($data['groups']) && !empty($data['groups'])){
				foreach($data['groups'] as $k => $g){
					if($g !=''){
						$groups.='<span class="hide" value="'.esc_attr($g).'"  ftype="groups"></span>';
					}
				}
			}
			$places='';
			if(isset($data['places']) && !empty($data['places'])){
				foreach($data['places'] as $k => $p){
					if($p !=''){
						$places.='<span class="hide" value="'.esc_attr($p).'"  ftype="places"></span>';
					}
				}
			}
	 }else{
			$data_name='';
			$data_url='';
			$data_template='';
			$data_community='';
			$data_results='50';
			$data_day='31';
			$data_keywords='';
			$data_match='';
			$data_feature='';
			$data_sponsored='';
			$data_instances='';
			$data_past_event='';
			$data_widget_type='';
			$data_hide_desc='';
			$data_trunca_desc='';
			$data_render_html='';
			$data_hide_image='';
			$data_hide_time='';
			$data_hide_dropdown='';
			$data_open_links='';
			$data_style='';
			$status="new";
			$count=0;
			$filters='';
			$exclude_filters='';

	 }
	if($data_feature == 'on'){
		$checked='checked="checked"';
	}else{
		$checked='';
	}
	if($data_sponsored == 'on'){
		$sponsored='checked="checked"';
	}else{
		$sponsored='';
	}if($data_instances == 'on'){
		$instances='checked="checked"';
	}else{
		$instances='';
	}if($data_past_event == 'on'){
		$past_event='checked="checked"';
	}else{
		$past_event='';
	}if($data_hide_desc == 'on'){
		$data_hide_desc='checked="checked"';
	}else{
		$data_hide_desc='';
	}
	if($data_trunca_desc == 'on'){
		$data_trunca_desc='checked="checked"';
	}else{
		$data_trunca_desc='';
	}
	if($data_render_html == 'on'){
		$data_render_html='checked="checked"';
	}else{
		$data_render_html='';
	}
	if($data_hide_image == 'on'){
		$data_hide_image='checked="checked"';
	}else{
		$data_hide_image='';
	}if($data_hide_time == 'on'){
		$data_hide_time='checked="checked"';
	}else{
		$data_hide_time='';
	}if($data_hide_dropdown == 'on'){
		$data_hide_dropdown='checked="checked"';
	}else{
		$data_hide_dropdown='';
	}if($data_open_links == 'on'){
		$data_open_links='checked="checked"';
	}else{
		$data_open_links='';
	}

?>
<div class="container">
	<div class="wrap margin">
		<h1>Localist Calendar Widgets</h1>
		<div class="hide form-res"></div>
	</div>
	<div class="cleft form-width">
		<form id="setting" action="?page=localist_calendar_setting" method="post">
			<div class="filter_labels">	</div>

			<table class="form-table ">
				<tbody class="wrape_container first">
					<tr class="heading"><th ><span>Plugin Setting</span></th></tr>
					<tr class="wrape form-field form-required">
						<th scope="row"><label>Localist Calendar URL</label></th>

						<td><span class="url"><input name="url" type="text" placeholder="Enter the Localist Calendar URL" value="<?php if($data_url != ''){ echo esc_attr($data_url);}else{echo esc_attr(get_option('localisturl',''));}?>"></span></td>

					</tr>
				</tbody>
			</table>
			<div class="submit_button">
				<input type="submit" name="configure_widget" value='Save Calendar URL'>
			</div>
		</form>
	<?php if(isset($_POST['configure_widget'])){
				$response = check_localist_validity($_POST['url']);
		if(get_option('localisturl') !=''){
			if($response == 'true'){
					update_option('localisturl',$_POST['url'],'','');
					echo "<script>location.reload();</script>";
				}else{
					echo "<span class='err_message hide'>Please enter valid Localist Calendar URL.</span><span class='err_url hide'>".esc_html($_POST['url'])."</span>";
				}
			}else{
				if($response == 'true'){
					add_option( 'localisturl', $_POST['url'], '', 'yes' );
					echo "<script>location.reload();</script>";
				}else{
					echo "<span class='err_message hide'>Please enter valid Localist Calendar URL.</span><span class='err_url hide'>".esc_html($_POST['url'])."</span>";
					echo "<span class='err_message hide'>Please enter valid Localist Calendar URL.</span><span class='err_url hide'>".esc_html($_POST['url'])."</span>";
				}
			 }
			 //echo "<script>location.reload();</script>";
	}

	?>
	<?php if(get_option('localisturl')!= ''){
			if($status == 'new'){
				$url=get_option('localisturl').'/api/2/';
			}else{
				$url=$data_url.'/api/2/';
			}
			$q='?pp=100';

	?>
		<form id="configuration" action="?page=localist_calendar_setting" method="post" status="<?php echo esc_attr($status);?>">
		<?php
			if(isset($_GET['id']) && intval($_GET['id']) > 0){
				echo $filters;
				echo $exclude_filters;
				echo $groups;
				echo $places;
				}
			?>
			<table class="form-table">
				<tbody class="border wrape_container">
					<tr class="heading"><th ><span>widget builder</span>
						<?php if(isset($_GET['id'])){?>
							<input type="hidden" name="localist_id" value="<?php echo esc_attr($_GET['id']);?>">
							<input type="hidden" name="widget_id" value="<?php echo esc_attr($widget_id);?>">
						<?php }?>
						<input name="url" type="hidden" value="<?php if($data_url != ''){ echo esc_attr($data_url);}else{echo esc_attr(get_option('localisturl',''));}?>">
					</tr>


					<tr class="wrape form-field" style="display:none;">
						<th scope="row"><label>Template </label></th>
						<td><select name="template" sv="<?php echo esc_attr($data_template);?>">
							<option value="">Default</option>
						</select></td>
					</tr>
					<?php

					//community here...
						if(isset($url)){
							/*echo get_transient( $url.'organizations'.$q );
							exit;*/
							if(false === ( $str = get_transient( $url.'organizations'.$q ) )){
								//echo "exit";
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $url.'organizations'.$q);

								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								$str = curl_exec($ch);
								curl_close($ch);
								set_transient( $url.'organizations'.$q, $str, 24 * HOUR_IN_SECONDS );
							}
						//$str = file_get_contents($url.'organizations'.$q);

							if(isset($str)){
								$result=array();
								$data=json_decode($str);
								foreach($data->organizations as $k => $v){
									//echo 'key is'.$k;
								//	foreach($v as $r){
										$id = $v->organization->id;
										$name = $v->organization->urlname;
										echo '<input type="hidden" name="organization_name" value="'.$name.'">';
										/*echo "starts here --- <pre>";
										print_r($v);
										echo "</pre>";*/
										//exit;

										if(isset($id)){
											$urlobj = $url.'organizations/'.$id.'/communities'.$q;
										if(false === ( $communities = get_transient( $url.'organizations/'.$id.'/communities'.$q) )){
										$ch = curl_init();
										curl_setopt($ch, CURLOPT_URL, $url.'organizations/'.$id.'/communities'.$q);

										curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
										$communities = curl_exec($ch);
										curl_close($ch);
										set_transient( $url.'organizations/'.$id.'/communities'.$q, $communities, 24 * HOUR_IN_SECONDS );
										}
											//$communities = file_get_contents($url.'organizations/'.$id.'/communities'.$q);
											$communities=json_decode($communities);
											$result=getAllresult($urlobj,$communities->page->total);
											if(isset($result) && !empty($result)){
												echo '<tr class="wrape form-field"><th scope="row"><label>Community</label></th><td><select name="community" sv="'.esc_attr($data_community).'"><option value="">-None-</option>';
												foreach($result as $key => $res){
													echo '<option value="'.esc_attr($key).'">'.esc_html($res).'</option>';
												}
												echo '</select></td></tr>';
											}
									//	}
									}
								}

							}
						}


					?>

					<tr class="wrape form-field">
						<th scope="row"><label>Number of Results ?</label></th>
						<td><input name="results" type="text" value="<?php echo esc_attr($data_results);?>"></td>
					</tr>
					<tr class="wrape form-field">
						<th scope="row"><label>Days Ahead ?</label></th>
						<td><input name="day" type="text" value="<?php echo esc_attr($data_day);?>"></td>
					</tr>
					<?php
					//groups here...
					if(isset($url)){
						$result=array();
						$urlobj=$url.'groups'.$q;
						//echo "before";exit;
						if(false === ( $grps = get_transient( $url.'groups'.$q) )){
						//	echo "tttt";
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url.'groups'.$q);

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$grps = curl_exec($ch);
						curl_close($ch);
						set_transient( $url.'groups'.$q, $grps, 24 * HOUR_IN_SECONDS );
						}
						//echo "test"; exit;

						//$grps = file_get_contents($url.'groups'.$q);
						if(isset($grps)){
							$grs=json_decode($grps);
							$result=getAllresult($urlobj,$grs->page->total);
							if(isset($result) && !empty($result)){
								echo '<tr class="wrape form-field"><th scope="row"><label>Groups</label></th><td><select name="groups[]" ftype="groups"><option value="">-None-</option>';
								foreach($result as $key => $res){
									echo '<option value="'.esc_attr($key).'">'.esc_html($res).'</option>';
								}
								echo '</select></td></tr>';
							}
						}
					}
//					echo "test"; exit;


					?>

					<tr class="wrape form-field">
						<th scope="row"><label>Keywords and Tags</label></th>
						<td><input name="keywords" type="text" placeholder="Separate keywords with commas" value="<?php echo esc_attr($data_keywords);?>"></td>
					</tr>
					<tr class="wrape form-field">
						<th scope="row"><label>Only Show Featured</label></th>

						<td><input name="feature" type="checkbox" <?php echo $checked;?>></td>
					</tr>
					<tr class="wrape form-field">
						<th scope="row"><label>Only Show Sponsored</label></th>
						<td><input name="sponsored" type="checkbox" <?php echo $sponsored;?>></td>
					</tr>
					<tr class="wrape form-field">
						<th scope="row"><label>Include All Matching Instances</label></th>
						<td><input name="instances" type="checkbox" <?php echo $instances;?> ></td>
					</tr>

					<?php
					//place here...
					if(isset($url)){
						$result=array();
						$urlobj=$url.'places'.$q;
						if(false === ( $plcs = get_transient( $url.'places'.$q) )){
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url.'places'.$q);

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$plcs = curl_exec($ch);
						curl_close($ch);
						set_transient( $url.'places'.$q, $plcs, 24 * HOUR_IN_SECONDS );
						}

						//$plcs = file_get_contents($url.'places'.$q);
						if(isset($plcs)){
							$pls=json_decode($plcs);
							$result=getAllresult($urlobj,$pls->page->total);
							if(isset($result) && !empty($result)){
								echo '<tr class="wrape form-field"><th scope="row"><label>Places</label></th><td><select  size="4" multiple name="places[]" ftype="places"><option value="">-All-</option>';
								foreach($result as $key => $res){
									echo '<option value="'.esc_attr($key).'">'.esc_html($res).'</option>';
								}
								echo '</select></td></tr>';
							}
						}
					}
					?>
					</tbody>
				</table>
				<table id="filters_area"  class="form-table top">
					<tbody>
					<?php
					//All filters here...
					if(isset($url)){
						$lable=array();
						$filter_arr=array();
						if(false === ( $lables = get_transient( $url.'events/labels') )){
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url.'events/labels');

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$lables = curl_exec($ch);
						curl_close($ch);
						set_transient( $url.'events/labels', $lables, 24 * HOUR_IN_SECONDS );
						}

						//$lables = file_get_contents($url.'events/labels');
						$lbls=json_decode($lables);
						foreach($lbls->filters as $x => $y)
						{
								$lable[$x]=$y;
						}
						if(false === ( $filters = get_transient( $url.'events/filters') )){
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url.'events/filters');

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$filters = curl_exec($ch);
						curl_close($ch);
						set_transient( $url.'events/filters', $filters, 24 * HOUR_IN_SECONDS );
						}

						//$filters=file_get_contents($url.'events/filters');
						$all_filters=json_decode($filters);
						$list_html='';
						$list_html_excluded='';
						foreach($all_filters as $s => $filter){
							$filter_arr = array();
							$list_html.= '<tr class="wrape form-field filter_area"><th style="width:205px;" scope="row"><label>'.esc_html($lable[$s]).'</label></th><td><select  multiple size="4" name="filters['.esc_attr($s).'][]" fname="'.esc_attr($s).'"><option value="">-All-</option>';
							$list_html_excluded.= '<tr class="wrape form-field excluded_filter_area"><th style="display:block;" scope="row"><label>'.esc_html($lable[$s]).'</label></th><td><select multiple size="4" name="exclude_filters['.esc_attr($s).'][]" fname="'.esc_attr($s).'"><option value="">-None-</option>';
							foreach($filter as $k => $w){
								if($w->parent_id == ''){
									$filter_arr['parent'][$w->id]=$w->name;
								}else{
									$filter_arr[$w->parent_id][$w->id]=$w->name;
								}
							}
							/*echo "<pre>";
							print_r($filter_arr);
							echo "</pre>";*/


							asort ($filter_arr['parent']);

							foreach($filter_arr['parent'] as $k =>$val){
								$list_html.='<option value="'.esc_attr($k).'">'.esc_html($val).'</option>';
								$list_html_excluded.='<option value="'.esc_attr($k).'">'.esc_html($val).'</option>';
								$list_html_child = filters_level_call($k,$filter_arr,1,'');
								$list_html_excluded_child = filters_level_call($k,$filter_arr,1,'');
								$list_html .= $list_html_child;
								$list_html_excluded .= $list_html_excluded_child;
								/*if(isset($filter_arr[$k]) && !empty($filter_arr[$k])){
									foreach($filter_arr[$k] as $d =>$val){
										$list_html.='<option value="'.$d.'">&nbsp;&nbsp;'.$val.'</option>';
										$list_html_excluded.='<option value="'.$d.'">&nbsp;&nbsp;'.$val.'</option>';
									}
								}*/
							}
							$list_html.='</select></td></tr>';
							$list_html_excluded.='</select></td></tr>';
						}
						echo $list_html;
					}
					?>
					</tbody>
				</table>

				<table  class="form-table top">
					<tbody>
					<tr class="wrape form-field">
						<th scope="row"><label>Match</label></th>
						<td><select name="match" sv="<?php echo esc_attr($data_match);?>">
							<option value="">At least one keyword or tag, and one filter item</option>
							<option value="any">Any keyword, tag, or filter item</option>
							<option value="all">All keywords, tags, and filter items</option>
						</select></td>
					</tr>
					</tbody>
				</table>
					<table id="filters_area_excluded"  class="form-table top">
						<tbody>
						<tr class="heading"><th ><span>excluded content</span></th></tr>
							<?php echo @$list_html_excluded;?>
						</tbody>
					</table>
					<table  class="form-table top">
						<tbody>
						<tr class="wrape_container">
							<tr class="wrape form-field">
								<th scope="row"><label>Hide Past Events</label></th>
								<td><input name="past_event" type="checkbox" <?php echo $past_event;?>>
							</tr>
						</tr>
					<tr class="heading"><th><span>display options</span></th></tr>
							<tr class="wrape form-field">
								<th><label>Widget Type</label></th>
								<td><select name="widget_type" id="widget_type" sv="<?php echo esc_attr($data_widget_type);?>">
									<option value="view">List</option>
									<option value="combo">Mini Calendar + List</option>
								</select></td>
							</tr>
							<tr class="wrape form-field">
								<th scope="row"><label>Style</label></th>
								<td><select name="style" value="style" sv="<?php echo esc_attr($data_style);?>">
								  <option value="modern">Modern</option>
								  <option value="">Classic</option>
								  <option value="card">Card</option>
								  <option value="none">None</option>
								</select></td>
							</tr>
							<tr class="wrape form-field">
								<th scope="row"><label>Hide Descriptions</label></th>
								<td><input name="hide_desc" type="checkbox" <?php echo $data_hide_desc;?>></td>
							</tr>
							<tr class="wrape form-field">
								<th scope="row"><label>Truncate Descriptions</label></th>
								<td><input name="trunca_desc" type="checkbox" <?php echo $data_trunca_desc;?>></td>
							</tr>
							<tr class="wrape form-field">
								<th scope="row"><label>Render HTML in Descriptions</label></th>
								<td><input name="render_html" type="checkbox" <?php echo $data_render_html;?>></td>
							</tr>
							<tr class="wrape form-field">
								<th scope="row"><label>Hide Event Images</label></th>
								<td><input name="hide_image" type="checkbox" <?php echo $data_hide_image;?>></td>
							</tr>
							<tr class="wrape form-field">
								<th scope="row"><label>Hide Event Times</label></th>
								<td><input name="hide_time" type="checkbox" <?php echo $data_hide_time;?>></td>
							</tr>
							<tr class="wrape form-field hide">
								<th scope="row"><label>Hide Filter Dropdown</label></th>
								<td><input name="hide_dropdown" type="checkbox" <?php echo $data_hide_dropdown;?>></td>
							</tr>
							<tr class="wrape form-field">
								<th scope="row"><label>Open Links in New Window</label></th>
								<td><input name="open_links" type="checkbox" <?php echo $data_open_links;?>></td>
							</tr>
							<tr class="wrape first form-field form-required">
								<th scope="row"><label>Widget Name</label></th>
								<td><span class="widget_title"><input name="wid_name" type="text" placeholder="Enter the calendar widget name" value="<?php echo esc_attr($data_name);?>"></span></td>
							</tr>
					</tbody>
					</table>
					<table class="form-table top">
					<tbody class="border display wrape_container">
						<tr class="wrape embed form-field">
								<th><label>Widget Embed Code</label></th>
								<td><textarea id="embed" name="script_tag"></textarea></td>
							</tr>
					</tbody>
			</table>
			<div class="submit_button top">
				<input type="submit" name="save_widget" value='Save as WordPress Widget' view="noview">
				<input type="button" name="generate_embedded_code" value='Generate Embed Code' view="view">
				<input type="hidden" name="generated_widget_url" id="generated_widget_url" value="">
			</div>
		</form>
	<?php }?>
	</div>
	<div class="cright width" id="available-widgets">
	<?php
			if(isset($_GET['id']) && intval($_GET['id']) > 0){
				echo "<style>.data_id-".intval($_GET['id'])."{border: 1px solid #999;}</style>";
			}
			global $wpdb;
			$table = $wpdb->prefix.'localistCalendar';
			$sql="SELECT * FROM `".$table."`";
			$results = $wpdb->get_results($sql) or die('No Widgets Found');
			foreach($results as $result){

			// get the widget title...
				if($result->widget_id !=0){
					$id='text-'.$result->widget_id;
					$wdgtvar = 'widget_'._get_widget_id_base( $id );
					$idvar = _get_widget_id_base( $id );
					$instance = get_option( $wdgtvar );
					$idbs = str_replace( $idvar.'-', '', $id );
					$title=$instance[$idbs]['title'];
					$server=$_SERVER['REQUEST_URI'];
					$surl=explode('?',$server);
					if(isset($title)){
			// genrate edit links here...
					echo '<div class="widget-box widget-top widget_id-'.$result->widget_id.' data_id-'.$result->id.'">
							<div class="widget-title">
								<a class="widget-link" href="'.esc_attr($surl[0].'?page=localist_calendar_setting&id='.$result->id).'">
									<span class="title">'.esc_html($title).'</span>

								</a>
							</div>
					</div>';}
				}
			}
	?>
	</div>
</div>

<?php }

/**
 * Register style sheet.
 */
function localist_styles() {

	wp_enqueue_style( 'Localist',plugin_dir_url( __FILE__ ).'css/localist.css' );
	wp_enqueue_script( 'Localist',plugin_dir_url( __FILE__ ).'js/localist.js' );

}

// Register style sheet.
add_action( 'admin_enqueue_scripts', 'localist_styles' );

//create tabel on plugin install

function localist_install() {

	global $jal_db_version;
	$jal_db_version = '1.0';

  global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix.'localistCalendar';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE ".$table_name." (
		id int(9) NOT NULL AUTO_INCREMENT,
		data varchar(5000) DEFAULT '',
		widget_id int(10) DEFAULT '0' NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	ob_clean();
	add_option( 'jal_db_version', $jal_db_version );


}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'localist_install');

//delete tabel on plugin uninstall
function localist_uninstall(){
	 global $wpdb;
        $table = $wpdb->prefix."localistCalendar";

        //Delete any options thats stored also?
	//delete_option('wp_yourplugin_version');

	$wpdb->query("DROP TABLE IF EXISTS ".$table);
	delete_option('localisturl');
	ob_clean();
}
register_uninstall_hook( __FILE__, 'localist_uninstall' );


//get all results....
function getAllresult($url,$total){
	if(isset($url)){
	$res=array();
	for($i=1;$i<=$total;$i++){

		if(false === ( $json = get_transient( $url.'&page='.$i) )){

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url.'&page='.$i);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$json = curl_exec($ch);
			curl_close($ch);
			set_transient( $url.'&page='.$i, $json, 24 * HOUR_IN_SECONDS );
		}

		//$json = file_get_contents($url.'&page='.$i);
		$jsn_opt=json_decode($json);
		foreach($jsn_opt as $k => $jsn){
			if(isset($jsn) && !empty($jsn)){
			 foreach($jsn as $j => $v){
				if (is_array($v) || is_object($v))
				{	foreach($v as $m => $n){
						$name=$v->$m->name;
						$urlname=$v->$m->urlname;
						$res[$urlname]=$name;
					}
				}
			  }
			}
		 }
	}
	return $res;
	}
}

?>
<?php

//form submition handler.....
 if(isset($_POST['save_widget'])){
	 	global $wpdb;
		$table = $wpdb->prefix."localistCalendar";


		if(isset($_POST['generated_widget_url'])) {
			$generated_widget_url = isset($_POST['generated_widget_url']) ? sanitize_text_field($_POST['generated_widget_url']) : null;
			$scriptags = '<script type="text/javascript" src="' . $generated_widget_url .'"></script><div id="lclst_widget_footer"><a rel="nofollow" style="margin-left:auto;margin-right:auto;display:block;width:81px;margin-top:10px;" title="Widget powered by Localist Online Calendar Software" href="http://www.localist.com?utm_source=widget&utm_campaign=widget_footer&utm_medium=branded%20link"><img src="//d3e1o4bcbhmj8g.cloudfront.net/assets/platforms/default/about/widget_footer.png" alt="Localist Online Calendar Software" style="vertical-align: middle;" width="81" height="23"></a></div>';
		} else {
			// fall back to the generated script tag, although this should *never* be run or used.
			$scriptags=isset($_POST['script_tag']) ? $_POST['script_tag'] : null;
		}

		// Extract the data we need from POST
		$data = array();

		$data['wid_name'] = sanitize_text_field($_POST['wid_name']);
		$data['url'] = sanitize_text_field($_POST['url']);
		if(isset($_POST['template'])) {
			$data['template'] = sanitize_text_field($_POST['template']);
		}
		if(isset($_POST['community'])) {
			$data['community'] = sanitize_text_field($_POST['community']);
		}
		if(isset($_POST['results']) && intval($_POST['results']) > 0) {
			$data['results'] = intval($_POST['results']);
		} else {
			$data['results'] = 50;
		}

		if(isset($_POST['day']) && intval($_POST['day']) > 0) {
			$data['day'] = intval($_POST['day']);
		} else {
			$data['day'] = 31;
		}

		if(isset($_POST['keywords'])) {
			$data['keywords'] = sanitize_text_field($_POST['keywords']);
		}

		if(isset($_POST['match'])) {
			$data['match'] = sanitize_text_field($_POST['match']);
		}

		if(isset($_POST['feature'])) {
			$data['feature'] = sanitize_text_field($_POST['feature']);
		}

		if(isset($_POST['sponsored'])) {
			$data['sponsored'] = sanitize_text_field($_POST['sponsored']);
		}

		if(isset($_POST['instances'])) {
			$data['instances'] = sanitize_text_field($_POST['instances']);
		}

		if(isset($_POST['past_event'])) {
			$data['past_event'] = sanitize_text_field($_POST['past_event']);
		}

		if(isset($_POST['widget_type'])) {
			$data['widget_type'] = sanitize_text_field($_POST['widget_type']);
		}

		if(isset($_POST['hide_desc'])) {
			$data['hide_desc'] = sanitize_text_field($_POST['hide_desc']);
		}

		if(isset($_POST['trunca_desc'])) {
			$data['trunca_desc'] = sanitize_text_field($_POST['trunca_desc']);
		}

		if(isset($_POST['render_html'])) {
			$data['render_html'] = sanitize_text_field($_POST['render_html']);
		}

		if(isset($_POST['hide_image'])) {
			$data['hide_image'] = sanitize_text_field($_POST['hide_image']);
		}

		if(isset($_POST['hide_time'])) {
			$data['hide_time'] = sanitize_text_field($_POST['hide_time']);
		}

		if(isset($_POST['hide_dropdown'])) {
			$data['hide_dropdown'] = sanitize_text_field($_POST['hide_dropdown']);
		}

		if(isset($_POST['open_links'])) {
			$data['open_links'] = sanitize_text_field($_POST['open_links']);
		}

		if(isset($_POST['style'])) {
			$data['style'] = sanitize_text_field($_POST['style']);
		}

		// array inputs (filters, exclude_filters, groups, places)
		if(!empty($_POST['filters'])) {
			$data['filters'] = array();
			foreach($_POST['filters'] as $k => $v) {
				$data['filters'][$k] = array();

				foreach($v as $c) {
					if(!empty($c)) $data['filters'][$k][] = intval($c);
				}
			}
		}

		if(!empty($_POST['exclude_filters'])) {
			$data['exclude_filters'] = array();
			foreach($_POST['exclude_filters'] as $k => $v) {
				$data['exclude_filters'][$k] = array();

				foreach($v as $c) {
					if(!empty($c)) $data['exclude_filters'][$k][] = intval($c);
				}
			}
		}

		if(!empty($_POST['groups'])) {
			$data['groups'] = array();
			foreach($_POST['groups'] as $group) {
				if(!empty($group)) $data['groups'][] = sanitize_text_field($group);
			}
		}

		if(!empty($_POST['places'])) {
			$data['places'] = array();
			foreach($_POST['places'] as $place) {
				if(!empty($place)) $data['places'][] = sanitize_text_field($place);
			}
		}

		$data=serialize($data);

		if(isset($_POST['localist_id']) && intval($_POST['localist_id'] > 0)){
			$lid=intval($_POST['localist_id']);
			$wid=isset($_POST['widget_id']) ? intval($_POST['widget_id']) : 0;
			$tw_id='text-'.$wid;
			$wdgtvar = 'widget_'._get_widget_id_base( $tw_id );
			$idvar = _get_widget_id_base( $tw_id );
			$instance = get_option( $wdgtvar );
			$idbs = str_replace( $idvar.'-', '', $tw_id );
			$title=$instance[$idbs]['title'];
			if(!empty($_POST['wid_name'])){
					$name = sanitize_text_field($_POST['wid_name']);
				}else{$name='';}
			if(isset($title)){
				localist_update_widget_text_by_title($title,$scriptags,$name,$wid);
			}else{

				localist_pre_set_widget( 'sidebar-1', 'text',array(
						'title' => $name,
						'text' => $scriptags,
						'filter' => false,
					));
			}
			$query = $wpdb->prepare("UPDATE `$table` SET `id` = %d, `data` = %s, `widget_id` = %d WHERE `id` = %d", $lid, $data, $wid, $lid);
			$result=$wpdb->query($query);

			if($result===1 || $result===0){
				 $server='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
				 $server=str_replace("admin.php","",$server).'widgets.php';
				echo "<span class='message hide update'>Your widget configuration has been updated. you will go and see the widget in <a href='".esc_attr($server)."'>inactive widget</a> block.</span>";
			}
		}else{
			$query = $wpdb->prepare("INSERT INTO `$table` (`id`, `data`, `widget_id`) VALUES ('', %s, '0')", $data);
			$res=$wpdb->query($query);
			$rowid=$wpdb->insert_id;
			if($_POST['wid_name']){
				$name=$_POST['wid_name'];
			}else{$name='';}
			$widget_id=localist_pre_set_widget( 'sidebar-1', 'text',array(
					'title' => $name,
					'text' => $scriptags,
					'filter' => false,
				)
			);
			$query = $wpdb->prepare("UPDATE `$table` SET `widget_id` = %d WHERE `$table`.`id` = %d", $widget_id, $rowid);
			$result=$wpdb->query($query);
			if($res==1){
				 $server='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
				 $server=str_replace("admin.php","",$server).'widgets.php';
				echo "<span class='message hide new'>Your new widget configuration has been saved. You will see the widget in the <a href='".esc_attr($server)."'>inactive widget</a> block.</span>";
			}
		}
 }
/**
**Create a new text widget instances.....
**/
function localist_pre_set_widget($sidebar,$name,$args = array()) {
    if ( ! $sidebars = get_option( 'sidebars_widgets' ) )
        $sidebars = array();

    // Create the sidebar if it doesn't exist.
    if ( ! isset( $sidebars[ $sidebar ] ) )
        $sidebars[ $sidebar ] = array();

    // Check for existing saved widgets.
    if ( $widget_opts = get_option( "widget_".$name ) ) {
        // Get next insert id.

        ksort( $widget_opts );
        end( $widget_opts );
        $insert_id = key( $widget_opts );

    } else {
        // None existing, start fresh.
        $widget_opts = array( '_multiwidget' => 1 );
        $insert_id = 0;
    }

	$insert_id = $insert_id+1;
    // Add our settings to the stack.
    $widget_opts[$insert_id] = $args;

    // Add our widget!
    $sidebars[ 'wp_inactive_widgets' ][] = $name.'-'.$insert_id;

    update_option( 'sidebars_widgets', $sidebars );
    update_option( "widget_".$name, $widget_opts );
	//$this->id;
	//echo "<pre>";print_r($this->id);echo "</pre>";exit;
	//echo $insert_id; exit;
	return  $insert_id;
}

/**
**Update widget data by compairing title of widget.....
**/
function localist_update_widget_text_by_title($search_title,$new_text,$name,$wid)
{
    // Get all data from text widgets
    $widgets = get_option( 'widget_text' );

    foreach( $widgets as $key => $widget )
    {
        // Compare and ignore case:
        if( mb_strtolower( $search_title ) === mb_strtolower( $widget['title'] ) )
        {
            // Replace the widget text:
            $widgets[$wid]['title'] = $name;
			$widgets[$wid]['text'] = $new_text;

            // Update database and exit on first found match:
            return update_option( 'widget_text', $widgets );
        }
    }
    return false;
}

function filters_level_call($k,$filter_arr,$counter,$list_html){
		//foreach
		$nbsp = '&nbsp;';
		$i = '';
		//$list_html= '';
		for($i=1;$i<=$counter;$i++){
			$nbsp .= '&nbsp;';
		}
		if(isset($filter_arr[$k]) && !empty($filter_arr[$k])){
			asort($filter_arr[$k]);
			foreach($filter_arr[$k] as $d =>$val){
				//echo $val.'<br/>';
				$list_html.='<option value="'.esc_attr($d).'">'.$nbsp.esc_html($val).'</option>';
				//unset($filter_arr[$k]);
				//$list_html_excluded.='<option value="'.$d.'">'.$val.'</option>';

				//check if this child has some grand child
				if(isset($filter_arr[$d])){
					//echo "control here again";
					//foreach($filter_arr[$d] as $gk => $gv)
					$counter++;
				//	echo "call here fir more child";
					asort($filter_arr[$d]);
					foreach($filter_arr[$d] as $gk => $gv){
						$list_html.='<option value="'.esc_attr($gk).'">'.$nbsp.$nbsp.esc_html($gv).'</option>';
					}
					//$grandchild_list_html = grand_filters_level_call($d,$filter_arr,$counter,$list_html);
					//$list_html .= $grandchild_list_html;
					//filters_level_call($d,$filter_arr,$counter,$list_html);

				}
			}
			//echo '<select>'.$list_html.'</select>';
		}

		return $list_html;
}
function grand_filters_level_call($k,$filter_arr,$counter,$list_html){
		//foreach
		$nbsp = '&nbsp;';
		$i = '';
		//$list_html= '';
		for($i=1;$i<=$counter;$i++){
			$nbsp .= '&nbsp;';
		}
		if(isset($filter_arr[$k]) && !empty($filter_arr[$k])){

			foreach($filter_arr[$k] as $d =>$val){
				//echo $val.'<br/>';
				//$list_html.='<option value="'.$d.'">'.$nbsp.$val.'</option>';
				//$list_html_excluded.='<option value="'.$d.'">'.$val.'</option>';

				//check if this child has some grand child
				if(isset($filter_arr[$d])){
					//echo "control here again";
					//foreach($filter_arr[$d] as $gk => $gv)
					$counter++;
					//echo "call here fir more child";
					$grandchild_list_html = grand_filters_level_call($d,$filter_arr,$counter,$list_html);;
					//filters_level_call($d,$filter_arr,$counter,$list_html);

				}
			}
			//echo '<select>'.$list_html.'</select>';
		}

		return $list_html;
}
function check_localist_validity($url){
		$headers = get_headers($url.'/api/2/organizations',1);
		if($headers[0] == 'HTTP/1.1 200 OK'){
			return "true";
		}else{
			return "false";
		}
	}
?>
