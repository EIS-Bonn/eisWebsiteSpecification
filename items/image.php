<?php
/**
 * This file holds an example of how to use the Email2Image class
 *
 * PHP Version 5
 *
 * @category  Email2Image
 * @package   JesseForrest
 * @author    Jesse Forrest <jesseforrest@gmail.com>
 * @copyright 2012 Jesse Forrest
 * @license   MIT License (MIT)
 * @link      https://github.com/jesseforrest/Email2Image
 * @filesource
 */

require_once '/srv/www/vhosts/eis.iai.uni-bonn.de/extensions/site/sites/local/libs/Email2Image/Email2Image.php';

// The email address to be displayed
$email = '';

// Instantiate Email2Image
$email2Image = new Email2Image();
$email2Image->setSalt('example-salt-string');
$email2Image->setFontSize(12);
$email2Image->setBackgroundColor('ffffff');
$email2Image->setForegroundColor('000');
$email2Image->setHorizontalAlignment(Email2Image::LEFT);
$email2Image->setVerticalAlignment(Email2Image::MIDDLE);

// Decrypt parameters passed via encryption
if (isset($_GET['encrypted_data'], $_GET['public_key']))
{
   $encryptedData = $_GET['encrypted_data'];
   $publicKey = $_GET['public_key'];
   
   $response = $email2Image->decrypt($encryptedData, $publicKey);
   
   if (isset($response['email']))
   {
      $email2Image->setEmail($response['email']);
   }
   if (isset($response['width']))
   {
      $email2Image->setWidth($response['width']);
   }
   if (isset($response['height']))
   {
      $email2Image->setHeight($response['height']);
   }
}

// Output image
$email2Image->outputImage();
