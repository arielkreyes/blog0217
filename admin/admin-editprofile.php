<?php 
session_start();
require('../db-config.php');
include_once('../functions.php');

//header contains the security check, doctype, and <header> element
include('admin-header.php');
include('admin-nav.php');

//begin parsing the image upload
if($_POST['did_upload']){
	//where is the uploads directory?
	$upload_path = '../uploads';

	//create a list of image sizes (max width in px)
	$sizes = array(
		'small' 	=> 150,
		'medium'	=> 300,
	);
	//extract the image that was uploaded
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	
	//validate = make sure it has pixels
	list($width, $height) = getimagesize($uploadedfile);
	if( $width > 0 AND $height > 0 ){
		//what MIME type of image is it?
		$filetype = $_FILES['uploadedfile']['type'];
		switch( $filetype ){
			case 'image/gif':
				$source = imagecreatefromgif($uploadedfile);
			break;

			case 'image/jpeg':
			case 'image/pjpeg':
			case 'image/jpg':
				$source = imagecreatefromjpeg($uploadedfile);
			break;

			case 'image/png':
				ini_set( 'memory_limit', '16M' );
				$source = imagecreatefrompng($uploadedfile);
				ini_restore( 'memory_limit' );
			break;
			default:
				$message  = 'Please upload an image that is a .gif, .png, or .jpeg';
		}//end switch

		//resize the image 
		$uniquestring = sha1(microtime());
		foreach ($sizes as $name => $pixels) {
			if( $width < $pixels ){
				//keep the original size if the image is too small
				$new_width = $width;
				$new_height = $height;
			}else{
				//calculations to preserve the original aspect ratio
				$new_width = $pixels;
				$new_height = ( $new_width * $height ) / $width;
			}
			//create a new blank file at the correct size
			$tmp_canvas = imagecreatetruecolor($new_width, $new_height);

			imagecopyresampled($tmp_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, 
				$width, $height);

			$filename = $upload_path . '/' . $uniquestring . '_' . $name . '.jpg';
			$did_save = imagejpeg($tmp_canvas, $filename, 75);
			
		}//end foreach

		//if it saved the image, add the unique string to the DB
		if( $did_save ){
			$user_id = USER_ID;
			$query = "UPDATE users
					SET userpic = '$uniquestring'
					WHERE user_id = $user_id";
			$result = $db->query($query);
			if( $db->affected_rows == 1 ){
				$message = 'Success! Your User Picture has been updated';
			}else{
				$message = 'Sorry, your user pic could not be saved in the DB';
			}
		}//end if did_save
		else{
			$message = 'Sorry, It did not save in the folder';
		}		
	}//end if it has width and height (validator)
	else{
		$message = 'Sorry, your image contains no pixels.';
	}
}//end of parser
?>
<main role="main">

  <section class="panel important">
  	<h2>Edit Profile Picture</h2>
  	<?php show_feedback( $message ); ?>
  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" 
  		enctype="multipart/form-data">
  		
  		<label>Upload photo:</label>
  		<input type="file" name="uploadedfile">

  		<input type="submit" name="Edit Profile Pic">

  		<input type="hidden" name="did_upload" value="1">

  	</form>
  </section>
</main>

<?php include('admin-footer.php'); ?>	