<?php
function stnl_swifttest(){
	$stnl_testconfig = get_option('stnl_testconfig');
	echo '<div class="wrap">';
	?>
	<h2><?php _e('About Swift Mailer', 'stnl');?></h2>
	<p><?php _e("This plugin is currently using <a href='http://www.swiftmailer.org/'>Swift Mailer </a> v3.3.1.  Swift is a fully OOP Library for sending e-mails from PHP websites and applications. It does not rely on PHP's native mail() function which is known for using high server resources when sending multiple emails. Instead, Swift communicates directly with an SMTP server or a MTA binary to send mail quickly and efficiently.", 'stnl');?></p>
	<p><?php _e("Before releasing your Newsletter upon the world, it's recommended to make sure that your Swift setup is working properly.  Below you will find a number of simple test emails to run for your website.  Try using the <strong>Swift Sendmail</strong> option first as it is the quickest and easiest way to send email.  If your server does not support the Sendmail Option, use the SMTP option.", 'stnl');?></p>
    <h2><?php _e('Swift Testing Options', 'stnl');?></h2>
    <p><?php _e('You will need to make wp-content/plugins/st_newsletter/Swift/tests/tmp/ writable to the web user (usually "noobody" or "apache") (chmod 0777 will do this).', 'stnl');?></p>
   <?php
   		$check = 'admin.php';
				$page = $_SERVER['REQUEST_URI'];
				if(strpos($page, $check) === false){
					$page = $page.'admin.php';
				}
	?>
    <form method="post" action="<?php echo $page;?>">
		    	<input type="hidden" name="newsletter_submit_testoptions" value="true" />
		  <table class="optiontable"> 

		
                <tr valign="top"> 
		<th scope="row"><label for="from"><?php _e('From Email:', 'stnl');?></label></th>
					 <td><input name="stn_from" id="from" type="text" value="<?php echo $stnl_testconfig['from'];?>" size="20" /></td>
					 </tr>
                 <tr valign="top"> 
		<th scope="row"><label for="fname"><?php _e('From Name:', 'stnl');?></label></th>
					 <td><input name="stn_fname" id="fname" type="text" value="<?php echo $stnl_testconfig['fname'];?>" size="20" /></td>
					 </tr>
                 <tr valign="top"> 
		<th scope="row"><label for="to"><?php _e('To Email:', 'stnl');?></label></th>
					 <td><input name="stn_to" id="to" type="text" value="<?php echo $stnl_testconfig['to'];?>" size="20" /></td>
					 </tr>
                 <tr valign="top"> 
		<th scope="row"><label for="tname"><?php _e('To Name:', 'stnl');?></label></th>
					 <td><input name="stn_tname" id="tname" type="text" value="<?php echo $stnl_testconfig['tname'];?>" size="20" /></td>
					 </tr>
                     <tr valign="top"> 
		<th scope="row"><label for="conn"><?php _e("Connection Type:", 'stnl');?></label></th>
		<td><select name="stn_conn" id="conn">
						<option value="sendmail" <?php if ($stnl_testconfig['conn'] == "sendmail"){echo 'selected="selected"';} ?>>Swift Sendmail <?php _e('(recommended)', 'stnl');?></option>
							<option value="smtp" <?php if ($stnl_testconfig['conn'] == "smtp"){echo 'selected="selected"';} ?>>Swift SMTP <?php _e('(slower)', 'stnl');?></option>
							
							<option value="nativemail" <?php if ($stnl_testconfig['conn'] == "nativemail"){echo 'selected="selected"';} ?>>Native Mail <?php _e('(not recommended)', 'stnl');?></option>
					</select></td>
				</tr>
          </table>
          <fieldset class="options"><legend><?php _e('Swift SMTP Settings:', 'stnl');?></legend>
	<table class="optiontable">
					 <tr valign="top"> 
		<th scope="row"><label for="server"><?php _e('Server:', 'stnl');?></label></th>
					<td> <input name="stn_smtpserver" id="server" type="text" value="<?php echo $stnl_testconfig['smtpserver'];?>" size="20" /> (smtp.yourhost.com)</td>
					</tr>
			<tr valign="top"> 
			
		<th scope="row"><label for="user"><?php _e("Username", 'stnl');?> </label></th>
					<td><input name="stn_smtpuser" id="user" type="text" value="<?php echo $stnl_testconfig['smtpuser']?>" size="20" /></td>
					</tr>
					
				<tr valign="top"> 
		<th scope="row"><label for="pass"><?php _e("Password", 'stnl');?></label></th>
				<td> <input name="stn_smtppass" id="pass" type="password" value="<?php echo $stnl_testconfig['smtppass']?>" size="20" /></td>
				</tr>
				
				<tr valign="top"> 
		<th scope="row"><?php _e("Should we use TLS or SSL?:", 'stnl');?> </th>
		<td><label><input name="stn_smtptls" type="radio" value="false" <?php if ($stnl_testconfig['smtptls'] == "false"){echo 'checked="checked"';} ?> /><?php _e("No");?></label> <label><input name="stn_smtptls" type="radio" value="tls" <?php if ($stnl_testconfig['smtptls'] == "tls"){echo 'checked="checked"';} ?> /> TLS</label> <label><input name="stn_smtptls" type="radio" value="ssl" <?php if ($stnl_testconfig['smtptls'] == "ssl"){echo 'checked="checked"';} ?> /> SSL</label></td>
		</tr>
		
				 <tr valign="top"> 
		<th scope="row"><label for="port"><?php _e("Port:", 'stnl');?> </label></th>
				<td><input name="stn_smtpport" id="port" type="text" value="<?php echo $stnl_testconfig['smtpport'];?>" /></td>
				</tr>
			</table>
</fieldset>
	 <fieldset class="options"><legend><?php _e('Additional Options:', 'stnl');?></legend>
	<table class="optiontable">
    	<tr valign="top"> 
		<th scope="row"><label for="sendmail"><?php _e("Sendmail Path:", 'stnl');?> </label></th>
				<td><input name="stn_sendmail" id="sendmail" type="text" value="<?php echo $stnl_testconfig['sendmail'];?>" /><small><strong>Default:</strong> /usr/sbin/sendmail -bs</small></td>
				</tr>
    	<!-- <tr valign="top"> 
		<th scope="row"><label for="simpletest"><?php _e("SimpleTest Path:", 'stnl');?> </label></th>
				<td> --><input name="stn_simpletest" id="simpletest" type="hidden" value="<?php echo str_replace(ABSPATH, '', $stnl_testconfig['simpletest']);?>" />
                <!-- <?php _e("Requires you to download <a href='http://sourceforge.net/projects/simpletest'>SimpleTest</a> and upload onto you server. Path is based from: ", 'stnl'); echo ABSPATH;?> </td>
				</tr> -->
	 </table>
 </fieldset>
			    <p class="submit">
			      	<input type="submit" name="Submit" value="<?php _e('Update Testing Options &raquo;', 'stnl');?>" />
			    </p>
			</form>
	<h2><?php _e("Smoke Tests", 'stnl');?></h2>
     <p><?php _e('A message will be sent for each test. If the message sent successfully a green bar will appear and a set of instructions. If the message did not send successfully a red bar will appear along with the set of instructions and an error message.', 'stnl');?></p>
	<p><?php _e('Each smoke test contains an image to use as a guide to following the instructions. Be aware that you may see subtle differences as various mail clients will render emails slightly differently. This is perfectly normal.', 'stnl');?></p>
	<p><small><?php _e("Please note that these tests will open in a new window.", 'stnl');?></small></p>
	<ol style="width:200px;">
    <?php 	$phpv = stnl_phpversion(); ?>
	<li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/smokes/runTestOfBasicSend.php" target="_blank" class="edit"><?php _e("Basic Send Test", 'stnl');?></a></li>
	<li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/smokes/runTestOfMultipart.php" target="_blank" class="edit"><?php _e("Multipart Test", 'stnl');?></a></li>
	<li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/smokes/runTestOfAttachment.php" target="_blank" class="edit"><?php _e("Attachment Test", 'stnl');?></a></li>
	<li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/smokes/runTestOfHeaderEncoding.php"target="_blank" class="edit"><?php _e("Header Encoding Test", 'stnl');?></a></li>
	<li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/smokes/runTestOfEmbeddedImage.php" target="_blank" class="edit"><?php _e("Embedded Image Test", 'stnl');?></a></li>
	</ol>
	<p>&nbsp;</p>
	<h2><?php _e("Unit Tests", 'stnl');?></h2>
    <p><?php _e("Unit Tests go into much finer detail. They analyze the internals of the library from many different angles and make lots of expectations about what is supposed to happen. Several thousand expectations are made on this library and we want every single one of them to be satisfied.", 'stnl');?></p>
    <ol style="width:200px;">
    	<li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/units/runTests.php" target="_blank" class="edit"><?php _e("Run Unit Tests", 'stnl');?></a></li>
    </ol>
    <!-- <p>&nbsp;</p>
    <h2><?php _e("Benchmarks", 'stnl');?></h2>
	<p><?php _e('The Benchmarks simply measure memory usage and timescales to perform operations. They use a PHP extension called <a href="http://www.xdebug.org/">XDebug2</a>.', 'stnl');?> </p>
<p><?php _e('To run the benchmark tests, you will need to have XDebug2 installed on the server with Memory Limit support compiled into <acronym title="Hypertext Preprocessor">PHP</acronym>.  You can get XDebug2 by running', 'stnl');?></p>
<pre class="code"><?php _e('#- $   pecl install xdebug-2.0.0RC3  #or whatever is the latest at the time', 'stnl');?></pre>

    <ol style="width:200px;">
    	<li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/benchmarks/mem_attachments_with_swift.php" target="_blank" class="edit"><?php _e("Attachment Memory Usage", 'stnl');?></a></li>
        <li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/benchmarks/mem_sending_with_swift.php" target="_blank" class="edit"><?php _e("Sending Memory Usage", 'stnl');?></a></li>
        <li><a href="<?php echo stnl_dir();?>Swift<?php echo $phpv;?>/tests/benchmarks/time_sending_with_swift.php" target="_blank" class="edit"><?php _e("Sending Timescale", 'stnl');?></a></li>
       </ol> -->
    <p><?php _e('Please refer to the <a href="http://www.swiftmailer.org/wikidocs/v3/testing">Swift Documentation</a> for any further help with running any of these tests.', 'stnl');?></p>
	<?php
	echo '</div>';
}
?>