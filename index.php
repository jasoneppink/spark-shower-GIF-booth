<?php

$email = $_POST['email'];
$gif = $_POST['gif'];

echo "<html><head><title>✨Spark Booth ⚡️ @ ⚠️ 🚧 Safety Fest 2018</title><meta charset='UTF-8'>";
//echo "<meta http-equiv='refresh' content='10'>";
echo "<head><body>";

$valid_ext = array("gif"); // valid extensions
$imagesDir = "gifs";

foreach (new DirectoryIterator($imagesDir) as $fileInfo) { // iterator
    if (in_array($fileInfo->getExtension(), $valid_ext) ) { // in $valid_ext
    	$filesArr[] =  $fileInfo->getFilename();
    }
 }

$revFilesArr = array_reverse($filesArr);

 foreach ($revFilesArr as $gifFile) {
	echo "<span style='float: left; padding: 5px;'>";
    echo "<img src='gifs/" . $gifFile . "' width='500px'/><br />\n";
    echo "<form action='' method='post'>
		<input type='text' value='your email address' name='email' onClick=select()>
		<input type='hidden' name='gif' value='gifs/" . $gifFile . "'>
		<input type='submit' name='submit' value='Send!'>
		</form>";
	echo "</span>";
}




# ------------
# for emailing
# ------------

if(isset($email) && isset($gif)) {

	//recipient
	$to = $email;

	//sender
	$from = ‘YOUR.EMAIL@ADDRESS.COM’;
	$fromName = ‘YOUR NAME’;

	//attachment file path
	$file = $gif;

	//email subject
	$subject = 'HOLY SHIT your Safety Fest wobble gif is here FUCK YES'; 

	//email body content
	$htmlContent = '<h1>CHECK OUT YOUR GIF</h1>
	    <p>Post it to Facebook and shit OMG</p>';

	//successful send alert
	$successful_email_msg = "Email successfully sent!";

	//header for sender info
	$headers = "From: $fromName"." <".$from.">";

	//boundary 
	$semi_rand = md5(time()); 
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

	//headers for attachment 
	$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

	//multipart boundary 
	$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
	"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

	//preparing attachment
	if(!empty($file) > 0){
	    if(is_file($file)){
	        $message .= "--{$mime_boundary}\n";
	        $fp =    @fopen($file,"rb");
	        $data =  @fread($fp,filesize($file));

	        @fclose($fp);
	        $data = chunk_split(base64_encode($data));
	        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
	        "Content-Description: ".basename($files[$i])."\n" .
	        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
	        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
	    }
	}
	$message .= "--{$mime_boundary}--";
	$returnpath = "-f" . $from;

	//send email
	$mail = @mail($to, $subject, $message, $headers, $returnpath); 

	//email sending status
	echo $mail?"<script type='text/javascript'>alert('" . $successful_email_msg . "')</script>":"<script type='text/javascript'>alert('Mail sending failed.')</script>";
}

echo "</html>";

?>
