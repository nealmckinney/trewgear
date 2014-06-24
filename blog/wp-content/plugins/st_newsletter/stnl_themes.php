<?php
/* Newsletter Themes */
function stnl_get_template($cur=''){

	$theme_dir =  dirname(__FILE__).'/templates';
	
	$myDirectory = opendir($theme_dir);

	// get each entry
	while($entryName = readdir($myDirectory)) {
		$dirArray[] = $entryName;
	}
	
	// close directory
	closedir($myDirectory);
	
	//	count elements in array
	$indexCount	= count($dirArray);
	
	// sort 'em
	sort($dirArray);
	
	// loop through the array of files and print them all
	for($index=0; $index < $indexCount; $index++) {
			if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
				$name =  $dirArray[$index];
				if(is_dir($theme_dir."/".$name)){
					$theme[] = $name;
				}
		}
	}
	foreach($theme as $th){
		?>
        <option value="<?php echo $th;?>" <?php if ($cur == $th){echo 'selected="selected"';} ?>><?php echo $th;?></option>
        <?php
	}
}
?>