<?php

function stnl_inout(){

	st_export_page();

	st_import_page();

}



function st_import_page(){

global $wpdb, $table_prefix;

	

?>

<div class="wrap">

	<h2><?php _e('Import Subscriber List', 'stnl');?></h2>

	<p><?php _e("This will currently only accept a CSV(comma-seperated values) file in a specific format. You will be able to map the values to the correct fields in the next step. It also assumes that all values are subscribers who have already opted-in.  I recommend splitting your data into seperate lists of 100 to prevent server timeouts or connection errors.  If you are importing additional data besides just the email, you will need to follow the format listed below:", 'stnl');?> </p>
<code>
<?php _e('"EMAIL","VERIFIED","EXTRAS","SubscribeIP","SubscribeDATE","CATEGORIES"
"info@shiftthis.net","1","FirstName[:]Shift[*]LastName[:]This","192.168.0.1","10:31am 29/07/2007","1[|]2"', 'stnl');?>
</code>
<p><?php _e('The VERIFIED field can be either 1 (verified) or 0 (unverified). The EXTRAS field must be formated with your field name with all spaces removed with the format of "FieldName[:]UserData" each field needs to be seperated with "[*]" as well - see example above (Also note that you must have these fields setup within your Options page as well). The CATEGORIES Field contains the category ID, multiple categories must be seperated with "[|]".','stnl');?></p>
	<p><?php _e("Your CSV file needs to have each line terminated with a line break and each field terminated with a comma(,).  You should be able to open your CSV file in Notepad and view it without any strange characters showing up.  Check out the example files in the plugins 'csv-samples' folder.  If your CSV file includes headings in the first row, make sure to select the option to ignore the first row in the next step.", 'stnl');?></p>

	<p><?php _e("You will need to make sure your", 'stnl');?> <a href='<?php echo get_option('home');?>/wp-admin/options-misc.php'><?php _e("Upload Directory", 'stnl');?></a><?php _e(" is writable.", 'stnl');?></p>

	

	<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;upload=true">

		<input type="hidden" name="MAX_FILE_SIZE" value="30000" />

		<?php _e('Import this file:', 'stnl');?> <input name="userfile" type="file" /><br />

	    <input type="submit" value="<?php _e('Upload File', 'stnl');?>" />

	</form>
<p><?php _e('If you are having problems uploading via this form you will need to name your file "import.csv" and FTP this file into the "wp-content/" folder and click the button below','stnl');?></p>
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;upload=true">
		<input type="hidden" name="ftp" value="wp-content/import.csv" />
	    <input type="submit" value="<?php _e('Import FTP File', 'stnl');?>" />

	</form>


</div>

<?php

if($_GET['upload'] == true && $_GET['import'] != true){

	if($_POST['ftp'] == true){
		$uploadfile = ABSPATH.'/'.$_POST['ftp'];
		$ftp = true;
		$ext = explode('.', $_POST['ftp']);
	}else{
		$file = basename($_FILES['userfile']['name']);
		$ext = explode('.', $file);
		$uploaddir = ABSPATH.get_option('upload_path').'/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	}
		if($ext[1] == 'csv' || $ext[1] == 'txt'){

			

			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile) || $ftp) {

				$fd = fopen ($uploadfile, "r");

				$contents = fread ($fd,filesize ($uploadfile));

				fclose ($fd);

				$delimiter = "\n";

				$splitcontents = explode($delimiter, $contents);

				$counter = "";

				$data = implode('|~|',$splitcontents);



?>

<div class="wrap">

<h2><?php _e('Match Fields For Import', 'stnl');?></h2>

<?php _e('<p>Select the value that matches the Label.</p>', 'stnl');?>

<?php

//$data = serialize($splitcontents);

$samplerow = explode(',',$splitcontents[0]);

$fields .= '<option value="">'.__('N/A', 'stnl').'</option>';



	foreach($samplerow as $key => $row){

		$fields .= '<option value="'.$key.'">'.$row.'</option>';

	} ?>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;import=true">

	<label><?php _e('Import First Row?:', 'stnl');?></label> <label><?php _e("Yes", 'stnl');?><input type="radio" name="row1" value="yes" checked="checked" /></label> <label><?php _e("No", 'stnl');?><input type="radio" name="row1" value="no" /></label><br />

	<label><?php _e('Email:', 'stnl');?> <select name="st_email"><?php echo $fields;?></select></label><br />

	<label><?php _e('Extras:', 'stnl');?> <select name="st_extras"><?php echo $fields;?></select></label><br />

	<label><?php _e('Categories:', 'stnl');?> <select name="st_cat"><?php echo $fields;?></select></label><br />
    
    <label><?php _e('Subscriber IP:', 'stnl');?> <select name="st_subip"><?php echo $fields;?></select></label><br />
    
    <label><?php _e('Subscribe Date:', 'stnl');?> <select name="st_subdate"><?php echo $fields;?></select></label><br />
    
    <label><?php _e('Confirmed:', 'stnl');?> <select name="st_confirm"><?php echo $fields;?></select></label><br /><br />

	<label><?php _e('Update current data','stnl');?> <input type="checkbox" name="st_update" value="update" checked="checked" /></label><br />
    <small><?php _e('If this option is unchecked all values will be added as a new which may cause duplicates','stnl');?></small><br />


<input type="hidden" name="contents" value='<?php echo $data;?>' />

<input type="submit" value="Import Values" onclick="return confirm('<?php _e("Please make sure your mapped selections are correct. \n Once imported, you will have to delete manually if anything is set incorrectly.", 'stnl');?>');" />

<?php



				//echo "File is valid, and was successfully uploaded.\n";

			} else {

				_e("File Upload has failed! Please make sure your Upload Directory is writable.", 'stnl');

			}

			

			

		}else{ echo '<div class="wrap"><strong>'.__("WRONG FILETYPE.  MUST BE A COMMA SEPERATED VALUE LIST IN EITHER '.csv' or '.txt' format.", 'stnl').'</strong></div>'; }

	}

	

if($_GET['import'] == true){

		//MAP TO FIELDS

		$rowone = $_POST['row1'];

		$map_email = $_POST['st_email'];

		$map_extras = $_POST['st_extras'];

		$map_cats = $_POST['st_cat'];
		
		$map_subip = $_POST['st_subip'];
		
		$map_subdate = $_POST['st_subdate'];
		
		$map_confirm = $_POST['st_confirm'];
		
		$update = $_POST['st_update'];

		//END MAP

		//$n_confirmed = "1";

		//$n_confip = __('IMPORTED', 'stnl');

		//$n_confdate = date('g:ia d/m/Y'); 

		

		$importrows =$_POST['contents'];

		$importrows = str_replace('\\"','',$importrows);

		$importrows = str_replace('"\\','',$importrows);

		$data = explode('|~|', $importrows);

		if($rowone != "yes"){

			unset($data[0]);

		}

		$updates = array();

		foreach ($data as $row){

			if ($row != ''){

				$cell = explode(',',$row);

					$n_code = genunique(20);

					$n_email = $cell[$map_email];

					$n_extras = $cell[$map_extras];
					if($n_extras)$update_extras = "st_extras = '$n_extras',";

					$n_cats = $cell[$map_cats];
					if($n_cats)$update_cats = "st_cat = '$n_cats', ";
					
					$n_confip = $cell[$map_subip];
					if($n_confip)$update_confip = "st_confip = '$n_confip',";

					$n_confdate = $cell[$map_subdate];
					if($n_confdate)$update_confdate = "st_confdate = '$n_confdate',";
					
					$n_confirmed = $cell[$map_confirm];
					if($n_confirmed)$update_confirmed = "st_status = '$n_confirmed',";

					if($update){
					//echo 'updatecheck=true';
						$dupe = stnl_dupecheck($n_email);
						$update_this = substr($update_extras.$update_cats.$update_confirmed.$update_confip.$update_confdate, 0,-1);
						//echo $dupe;
						if($dupe){
							$update = "UPDATE ".$table_prefix."st_mailinglist SET $update_this WHERE st_id = $dupe LIMIT 1";
							$wpdb->query($update);
	
						}else{
							$import = "INSERT INTO ".$table_prefix."st_mailinglist(st_email, st_extras, st_cat, st_status, st_code, st_confip, st_confdate) VALUES ('$n_email', '$n_extras', '$n_cats', '$n_confirmed', '$n_code', '$n_confip', '$n_confdate');";
							$wpdb->query($import);	
						}
					}else{



					$import = "INSERT INTO ".$table_prefix."st_mailinglist(st_email, st_extras, st_cat, st_status, st_code, st_confip, st_confdate) VALUES ('$n_email', '$n_extras', '$n_cats', '$n_confirmed', '$n_code', '$n_confip', '$n_confdate');";
					$wpdb->query($import);	

					}

					$success .= $n_email.'<br />';

			}

		}

		

		//echo $import;

			//if ($wpdb->query($import)){

				echo '<div class="wrap"><p><strong>'.__('Your data has been successfully imported.', 'stnl').'</strong></p></div>';

				echo '<div class="wrap"><h2>'.__('Data Imported', 'stnl').'</h2><p>'.$success.'</p></div>';

		//	}



}



}



function st_export_page(){

global $wpdb, $table_prefix;

	

	if($_GET['sub_export'] == true){

		

		$get_subs = "SELECT * FROM ".$table_prefix."st_mailinglist ORDER BY st_ID asc";

		$subs = $wpdb->get_results($get_subs);

		

		$headers = '"ID","EMAIL","VERIFIED","CODE","EXTRAS","SUBIP","CONFIP","SUBDATE","CONFDATE","CATEGORIES","RESPONDERS"'."\n";

		foreach($subs as $ml){

			foreach($ml as $val){

				$output .= '"'.str_replace(chr(10), '', str_replace(chr(13), '', $val)).'",';

			}

			$new = rtrim($output, ',');

			$out .= $new."\n";

			$output = '';

		}

		$save = $headers.$out;

		//echo $out;

		$server = str_replace('http://', '', get_option('home'));
		$server = str_replace('/', '_', $server);
		$server = str_replace('.', '_', $server);

		$myfile = $server."-subscribers-".date('Y-m-d').".csv";

		//$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");

		//fclose($ourFileHandle);

		

		$uploaddir = ABSPATH.get_option('upload_path').'/';

		$uploadfile = $uploaddir . $myfile;

		$fd = fopen ($uploadfile, "w")  or die("can't create file");

		$contents = fwrite ($fd, $save);

		fclose ($fd);

		

		$dl = __('Download', 'stnl').': <a href="'.get_option('siteurl').'/'.get_option('upload_path').'/'.$myfile.'"> '.$myfile.'</a> <small>'.__('(right-click to save)', 'stnl').'</small>';



	}

	

	?>

	<div class="wrap">

		<h2><?php _e('Export Subscriber List', 'stnl');?></h2>

		<p><a class="edit" style="width:350px; border:solid 1px #ccc" href="<?php  echo stnl_uri('inout-newsletter');?>&amp;sub_export=true"><?php _e('Export to CSV file (comma-seperated values)', 'stnl');?></a></p>

		<?php echo $dl;?>

	</div>

	

	<?php

}

?>