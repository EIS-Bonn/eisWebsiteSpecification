<?php
/**
 * This file holds the Email2Image class
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

/**
 * This class provides functionality to convert an email address into an image
 * so that it can be displayed on websites to prevent unwanted scrapers from 
 * gathering email addresses from your website.
 * 
 * This class requires that mcrypt module is installed with PHP.
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
class Email2Image
{
   /**
    * Used to align top
    * 
    * @var integer
    */
   const TOP = 0;
   
   /**
    * Used to align left
    *
    * @var integer
    */
   const LEFT = 1;
   
   /**
    * Used to align right
    *
    * @var integer
    */
   const RIGHT = 2;
   
   /**
    * Used to align bottom
    *
    * @var integer
    */
   const BOTTOM = 3;
   
   /**
    * Used to align middle
    *
    * @var integer
    */
   const MIDDLE = 4;
   
   /**
    * The path to the font
    * 
    * @var string
    */
   protected $fontPath = './fonts/';
   
   /**
    * The filename of the font to be used to create the image
    * 
    * @var string
    */
   protected $fontFile = 'tahoma.ttf';
   
   /**
    * The font size to be used
    * 
    * @var integer
    */
   protected $fontSize = 10;
   
   /**
    * The width of the image
    * 
    * @var integer|null
    */
   protected $width = null;

   /**
    * The height of the image
    *
    * @var integer|null
    */
   protected $height = null;
   
   /**
    * Holds the 6-digit hex color to be used for the background color. If 
    * <var>null</var> is passed in, no background color will be used.
    * 
    * @var string|null
    */
   protected $backgroundColor = null;

   /**
    * Holds the 6-digit hex color to be used for the foreground color.
    *
    * @var string
    */
   protected $foregroundColor = '000000';
   
   /**
    * Holds the email address that will be displayed
    * 
    * @var string|null
    */
   protected $email = null;
   
   /**
    * Holds an optional salt to additionally add security for encryption and
    * decryption
    * 
    * @var string
    */
   protected $salt = '';
   
   /**
    * How to align the email address vertically in the image.  Valid values are:
    *  - Email2Image::TOP
    *  - Email2Image::MIDDLE
    *  - Email2Image::BOTTOM
    *  
    * @var integer
    */
   protected $verticalAlignment = self::MIDDLE;

   /**
    * How to align the email address horizontally in the image.  Valid values 
    * are:
    *  - Email2Image::LEFT
    *  - Email2Image::MIDDLE
    *  - Email2Image::RIGHT
    *
    * @var integer
    */
   protected $horizontalAlignment = self::LEFT;
   
   /**
    * Sets the path to where the font is located
    * 
    * @param string $fontPath The path to the font.  You must include the 
    *                         end slash "/".
    *                         
    * @return void
    */
   public function setFontPath($fontPath)
   {
      $this->fontPath = $fontPath;
   }
   
   /**
    * Sets the file name of the .ttf font.
    *
    * @param string $fontFile The filename of the font, with the extension 
    *                         included.
    *
    * @return void
    */
   public function setFontFile($fontFile)
   {
      $this->fontFile = $fontFile;
   }
   
   /**
    * Sets the font size to be used
    *
    * @param integer $fontSize The font size to be used
    *
    * @return void
    */
   public function setFontSize($fontSize)
   {
      $this->fontSize = $fontSize;
   }
   
   /**
    * Holds the width, in pixels, of the image.  If width is <var>null</var>, 
    * then the width will automatically be determined by the font size and the
    * email address string length.
    * 
    * @param integer|null $width The width, in pixels, of the image
    * 
    * @return void
    */
   public function setWidth($width)
   {
      $this->width = $width;
   }

   /**
    * Holds the height, in pixels, of the image.  If height is <var>null</var>,
    * then the height will automatically be determined by the font size.
    *
    * @param integer|null $height The height, in pixels, of the image
    *
    * @return void
    */
   public function setHeight($height)
   {
      $this->height = $height;
   }
   
   /**
    * Sets the 6-digit hex color to be used for the foreground color.
    * 
    * @param string $foregroundColor The 6-digit hex color to be used for the
    *                                foreground color.
    * 
    * @return void
    */
   public function setForegroundColor($foregroundColor)
   {
      $this->foregroundColor = $foregroundColor;
   }
   
   /**
    * Holds the 6-digit hex color to be used for the background color. If 
    * <var>null</var> is passed in, no background color will be used.
    * 
    * @param string $backgroundColor The 6-digit hex color to be used for the
    *                                background color. If <var>null</var> is 
    *                                passed in, no background color will be 
    *                                used.
    *                                
    * @return void
    */
   public function setBackgroundColor($backgroundColor)
   {
      $this->backgroundColor = $backgroundColor;
   }
   
   /**
    * Sets the email address that will be displayed. 
    * 
    * @param string $email The decrypted email that should be displayed
    * 
    * @return void
    */
   public function setEmail($email)
   {
      $this->email = $email;
   }
   
   /**
    * Sets the salt to be used for extra security for encryption and 
    * decryption
    *
    * @param string $salt The salt string to be used
    *
    * @return void
    */
   public function setSalt($salt)
   {
      $this->salt = $salt;
   }
   
   /**
    * Set the horizontal alignment for where the email address should 
    * appear in the image.  
    * 
    * @param integer $verticalAlignment Set the vertical alignment with 
    * one of these values:
    *  - Email2Image::TOP
    *  - Email2Image::MIDDLE
    *  - Email2Image::BOTTOM
    *
    * @return void
    */
   public function setVerticalAlignment($verticalAlignment)
   {
      $this->verticalAlignment = $verticalAlignment;
   }
   
   /**
    * Set the horizontal alignment for where the email address should 
    * appear in the image.  
    * 
    * @param integer $horizontalAlignment Set the horizontal alignment with 
    * one of these values:
    *  - Email2Image::LEFT
    *  - Email2Image::MIDDLE
    *  - Email2Image::RIGHT
    *
    * @return void
    */
   public function setHorizontalAlignment($horizontalAlignment)
   {
      $this->horizontalAlignment = $horizontalAlignment;
   }
   
   /**
    * Encrypts an associative array and returns a response array with the 
    * encrypted information 
    *
    * @param array $parameters The associative array you want encrypted.
    *
    * @return array Returns an array in the following format:
    * <code>
    * return array(
    *    // The encrypted data
    *    'encrypted_data' => '...',
    *    // The public key used to decrypt the data
    *    'public_key' => '...'
    * );
    * </code>
    */
   public function encrypt($parameters)
   {
      $publicKey = $this->getPublicKey();
      $string = http_build_query($parameters);
      
      // For sake of MCRYPT_RAND
      srand((double) microtime() * 1000000);
   
      // To improve variance
      $key = md5($publicKey . $this->salt);
   
      // Open module, and create IV
      $descriptor = mcrypt_module_open('des', '', 'cfb', '');
      $key = substr($key, 0, mcrypt_enc_get_key_size($descriptor));
      $ivSize = mcrypt_enc_get_iv_size($descriptor);
      $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
   
      // Initialize encryption handle
      if (mcrypt_generic_init($descriptor, $key, $iv) != -1)
      {
         // Encrypt data
         $cT = mcrypt_generic($descriptor, $string);
         mcrypt_generic_deinit($descriptor);
         mcrypt_module_close($descriptor);
         $cT = $iv . $cT;
   
         return array(
            'encrypted_data' => urlencode(base64_encode($cT)),
            'public_key' => $publicKey
         );
      }
   }

   /**
    * This function will take an encrypted email and key and decrypt it to the
    * original email.
    *
    * @param string $encryptedData The key/value parameters after being passed
    *                              To the <code>encrypt</code> function.  
    * @param string $publicKey     The public key used to decode the string
    *
    * @return array|null Returns the decoded string as a PHP associative array
    * on success or null on failure.
    */
   public function decrypt($encryptedData, $publicKey)
   {
      $encryptedData = base64_decode(urldecode($encryptedData));
      
      // To improve variance
      $key = md5($publicKey . $this->salt);
      
      // Open module, and create IV
      $descriptor = mcrypt_module_open('des', '', 'cfb', '');
      $key = substr($key, 0, mcrypt_enc_get_key_size($descriptor));
      $ivSize = mcrypt_enc_get_iv_size($descriptor);
      $iv = substr($encryptedData, 0, $ivSize);
      
      // If encrypted data is not not the necessary length
      if (strlen($iv) != $ivSize)
      {
         return null;
      }
      
      $encryptedData = substr($encryptedData, $ivSize);
      
      // Initialize encryption handle
      $init = mcrypt_generic_init($descriptor, $key, $iv);
      
      // If failed to initialize the buffers used for encryption
      if (($init < 0) || ($init === false))
      {
         return null;
      }

      // Decrypt data
      $decryptedData = mdecrypt_generic($descriptor, $encryptedData);
      mcrypt_generic_deinit($descriptor);
      mcrypt_module_close($descriptor);

      // Convert decoded data into associative array
      $parameters = explode('&', $decryptedData);
      $response = array();
      foreach ($parameters as $keyAndValue)
      {
         $keyValueParts = explode('=', $keyAndValue);
         if (count($keyValueParts) == 2)
         {
            $response[$keyValueParts[0]] = urldecode($keyValueParts[1]);
         }
      }

      return $response;
   }
   
   /**
    * This will output the image in PNG format
    * 
    * @return void
    */
   public function outputImage()
   {
      header('Content-type: image/png');
      
      // Calculate the real path
      $realPath = realpath($this->fontPath . $this->fontFile);
      
      // Get bounding box array
      $bbox = imageftbbox(
         $this->fontSize, 
         0, 
         $realPath, 
         $this->email);
      
      // Determine width of image
      $width = $this->width;
      if ($width == null)
      {
         $width = abs($bbox[4] - $bbox[0]);
      }
      $width = (int) $width;
      
      // Determine height of image
      $height = $this->height;
      if ($height == null)
      {
         $height = abs($bbox[1] - $bbox[5]);
      } 
      $height = (int) $height;
      
      // Return if could not determine width or height
      if ((!$width) || (!$height))
      {
         return;
      }
      
      // Create image resource
      $image = imagecreate($width, $height);
      
      // Return if could not create image resource
      if ($image === false)
      {
         return;
      }
      
      // Set background color if necessary
      if ($this->backgroundColor != null)
      {
         $r = hexdec('0x' . substr($this->backgroundColor, 0, 2));
         $g = hexdec('0x' . substr($this->backgroundColor, 2, 2));
         $b = hexdec('0x' . substr($this->backgroundColor, 4, 2));
         
         // The first call to imagecolorallocate() fills the background color 
         // in palette-based images
         $backgroundColor = imagecolorallocate($image, $r, $g, $b);
      }
      
      // Determine horizontal position for text
      $x = null;
      // If align left
      if ($this->horizontalAlignment == self::LEFT)
      {
         $x = 0;
      }
      // If align middle
      else if ($this->horizontalAlignment == self::MIDDLE)
      {
         $textWidth = abs($bbox[4] - $bbox[0]);
         $x = intval(($width - $textWidth) / 2);
      }
      // If align right
      else
      {
         $textWidth = abs($bbox[4] - $bbox[0]);
         $x = intval($width - $textWidth);
      }
      
      // Determine vertical position for text 
      $y = null;
      // If align top
      if ($this->verticalAlignment == self::TOP)
      {
         $y = $this->fontSize;
      }
      // If align middle
      else if ($this->verticalAlignment == self::MIDDLE)
      {
         $y = intval($height - (($height - $this->fontSize) / 2));
      }
      // If align bottom
      else
      {
         $y = $height;
      }
      
      // Set foreground color 
      if ($this->foregroundColor != null)
      {
         $r = hexdec('0x' . substr($this->foregroundColor, 0, 2));
         $g = hexdec('0x' . substr($this->foregroundColor, 2, 2));
         $b = hexdec('0x' . substr($this->foregroundColor, 4, 2));
         $foregroundColor = imagecolorallocate($image, $r, $g, $b);
         
         // Write the email string to the image
         imagefttext(
            $image,
            $this->fontSize,
            0,
            $x,
            $y,
            $foregroundColor,
            $realPath,
            $this->email);
      }
      
      // Output the image
      imagepng($image);
      
      // Destroy the image
      imagedestroy($image);
   }
   
   /**
    * Returns a random alphanumeric string to be used as the key
    *
    * @param integer $length The length of the key to create.
    *
    * @return string
    */
   protected function getPublicKey($length = 8)
   {
      $chars = 'abcdefghjkmnpqrstuvwxyz0123456789';
      $i = 0;
      $key = '';
      while ($i < $length)
      {
         $num = mt_rand() % 33;
         $tmp = substr($chars, $num, 1);
         $key = $key . $tmp;
         $i++;
      }
      return $key;
   }
}
