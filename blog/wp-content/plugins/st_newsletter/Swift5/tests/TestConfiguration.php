<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
define("TEST_CONFIG_PATH", dirname(__FILE__));
define("DEFAULT_WRITABLE_PATH", TEST_CONFIG_PATH . "/tmp");
define("DEFAULT_LIBRARY_PATH", str_replace("tests", "lib", TEST_CONFIG_PATH));
define("FILES_PATH", TEST_CONFIG_PATH . "/files");
define("SIMPLE_PATH", str_replace('tests', 'simpletest', TEST_CONFIG_PATH));
define("WP_BLOG_HEADER_PATH",  TEST_CONFIG_PATH . "/../../../../../");
/*
 * Adjust the values contained inside this class in order to run the tests
 * NOTE: SimpleTest is NOT provided with Swift.  You must download this from SouceForge yourself.
 * Paths given should be either relative to the "tests/units" directory or absolute.
 * @package Swift_Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
require_once(WP_BLOG_HEADER_PATH.'/wp-blog-header.php'); 
	 $stnl_testconfig = get_option('stnl_testconfig');
		define("CONNECTION_TYPE", $stnl_testconfig['conn']);
		define("FROM_ADDRESS", $stnl_testconfig['from']);
		define("FROM_NAME", $stnl_testconfig['fname']);
		define("TO_ADDRESS", $stnl_testconfig['to']);
		define("TO_NAME", $stnl_testconfig['tname']);
		define("SMTP_HOST", $stnl_testconfig['smtpserver']);
		define("SMTP_PORT", $stnl_testconfig['smtpport']);
		define("SMTP_ENCRYPTION", $stnl_testconfig['smtptls']);
		define("SMTP_USER", $stnl_testconfig['smtpuser']);
		define("SMTP_PASS", $stnl_testconfig['smtppass']);
		define("SENDMAIL_PATH", $stnl_testconfig['sendmail']);
	// print_r($stnl_testconfig);
class TestConfiguration
{	
  /**
   * Somewhere to write to when testing disk cache
   */
  const WRITABLE_PATH = DEFAULT_WRITABLE_PATH;
  /**
   * The location of SimpleTest (Unit Test Tool)
   */
  const SIMPLETEST_PATH = SIMPLE_PATH;
  /**
   * The location of the Swift library directory
   */
  const SWIFT_LIBRARY_PATH = DEFAULT_LIBRARY_PATH;
    /**
   * The location of some files used in testing.
   */
  const FILES_PATH = FILES_PATH;
  
  /*
   * EVERYTHING BELOW IS FOR SMOKE TESTING ONLY
   */
   
  /**
   * The connection tye to use in testing
   * "smtp", "sendmail" or "nativemail"
   */
  const CONNECTION_TYPE = CONNECTION_TYPE;
  /**
   * An address to send emails from
   */
  const FROM_ADDRESS = FROM_ADDRESS;
  /**
   * The name of the sender
   */
  const FROM_NAME = FROM_NAME;
  /**
   * An address to send emails to
   */
  const TO_ADDRESS = TO_ADDRESS;
  /**
   * The name of the recipient
   */
  const TO_NAME = TO_NAME;
  
  /*
   * SMTP SETTINGS - IF APPLICABLE
   */
   
  /**
   * The FQDN of the host
   */
  const SMTP_HOST = SMTP_HOST;
  /**
   * The remote port of the SMTP server
   */
  const SMTP_PORT = SMTP_PORT;
  /**
   * Encryption to use if any
   * "ssl", "tls" or false
   */
  const SMTP_ENCRYPTION = SMTP_ENCRYPTION;
  /**
   * A username for SMTP, if any
   */
  const SMTP_USER = SMTP_USER;
  /**
   * Password for SMTP, if any
   */
  const SMTP_PASS = SMTP_PASS;
  
  /*
   * SENDMAIL BINARY SETTINGS - IF APPLICABLE
   */
  
  /**
   * The path to sendmail, including the -bs options
   */
  const SENDMAIL_PATH = SENDMAIL_PATH;

}