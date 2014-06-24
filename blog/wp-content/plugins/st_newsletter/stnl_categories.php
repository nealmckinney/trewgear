<?php
function stnl_categories(){

	global $table_prefix, $wpdb, $stnl_config;

	$sl = $stnl_config['slashfix'];

	/* Fetch Categories */
	$SQL = "SELECT * FROM ".$table_prefix."st_categories WHERE st_type='nl' ORDER BY st_id";

	$category = $wpdb->get_results($SQL);

	?>

	<div class="wrap">

		<h2><?php _e('Categories', 'stnl');?></h2>

<table class="widefat">

	<thead>

	<tr>

	<th scope="col" style="text-align: center;"><?php _e('ID', 'stnl');?></th>

        <th scope="col"><?php _e('Name', 'stnl');?></th>

        <th scope="col"><?php _e('Type', 'stnl');?></th>

        <th colspan="2" style="text-align: center;"><?php _e('Action', 'stnl');?></th>

	</tr>

	</thead><tbody id="the-list">

			  <?php

			foreach ( $category as $cat ) : 

				$default = $cat->st_default;

					if ($default == 0){

						$default=''; 

					}else{

						$default = "<small>".__('(default)', 'stnl')."</small>";

					}

				$class = ('alternate' != $class) ? 'alternate' : ''; ?>

			  	<tr id='news-<?php echo $cat->st_id; ?>' class='<?php echo $class; ?>'> 

				    <th scope="row" style="text-align: center;"><?php echo $cat->st_id; ?></th> 

					<td><?php echo $cat->st_name; ?> <?php echo $default; ?></td>

					<td><?php if($cat->st_type == 'nl'){ _e('Newsletter', 'stnl');}else if($cat->st_type == 'ar'){ _e('Auto-Responder', 'stnl');} ?> </td>

					<td><a href="<?php echo stnl_uri('cat-newsletter');?>&amp;edit_cat=<?php echo $cat->st_id?>" class="edit"><?php _e('Edit', 'stnl');?></a>

					<a href="<?php echo stnl_uri('cat-newsletter');?>&amp;delete_cat=<?php echo $cat->st_id?>" class="delete" onclick="return confirm('<?php _e('You are about to delete this category', 'stnl');?> <?php echo $cat->st_name;?> \n <?php _e('Any Newsletters within this category will be moved to the default category\n  OK to delete, Cancel to stop.', 'stnl');?>')"><?php _e('Delete', 'stnl');?></a></td>

			  	</tr>

			<?php

			endforeach; ?>

			</tbody>

			</table> 

			<a href="<?php echo stnl_uri('cat-newsletter');?>&amp;new_cat=<?php echo $cat->st_id?>" class="edit"><?php _e('Create new category', 'stnl');?></a>

	

	</div>

	<?php if ( isset($_GET['edit_cat']) ) { ?>

	<?php $h2 = __('Edit Category', 'stnl');?>

	<?php echo newsletter_cat_editing($_GET['edit_cat'], 'nl', $h2);?>

<?php 	}

	if ( isset($_GET['new_cat']) ) { ?>

	<?php $h2 = __('New Category', 'stnl');?>

	<?php echo newsletter_cat_editing('','nl',$h2);?>



<?php }	

}



function newsletter_cat_editing($edit='', $type='nl', $h2=''){

global $table_prefix, $wpdb, $stnl_config;

$sl = $stnl_config['slashfix'];

if ( $edit != '' ) {

	$e_sql = "SELECT * FROM " . $table_prefix . "st_categories WHERE st_id=". $edit;

	$e_cats = $wpdb->get_row($e_sql);	

}	

	if (isset($_POST['Submit'])) {

echo "<div class='updated'><p><strong>".__('Category Updated', 'stnl')."</strong></p></div>";

}



?><div class="wrap">

	<h2 id="edit"><?php echo $h2;?></h2>

	<?php if ($edit != ''){ ?>

		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;edit=true">

	<?php } else { ?>

	  	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;new=true"> 

	<?php } ?>

	    	<input type="hidden" name="category_submit" value="true" />

			<?php if ($edit != ''){ ?>

			<input name="stn_id" type="hidden" value="<?php echo $e_cats->st_id; ?>" />

			<?php } ?>

			<input name="stn_type" type="hidden" value="<?php echo $type; ?>" />

	    	<fieldset>

				<legend><strong><?php _e('Category Title', 'stnl');?></strong></legend>

			        <div><input name="stn_name" type="text" size="50" value="<?php echo $e_cats->st_name; ?>" /></div>

		   <label><input name="stn_default" type="checkbox" value="1" <?php if($e_cats->st_default == '1'){echo 'checked="checked"';} ?>" /> <?php _e('Set as Default Category', 'stnl');?></label>

		      	</fieldset>

	    	<p class="submit">

	      		<input type="submit" name="Submit" value="<?php _e('Save Category', 'stnl');?> &raquo;" />

	    	</p>

	  	</form>

    	

  	</div>

<?php 

}

?>