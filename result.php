<?php
// Start the session
session_start();
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.
echo  $_POST['phoneNo'];
$phone = $_POST['phoneNo'];
echo $_POST['useremail'];
$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}
echo 'Here is some more debugging info:';
print_r($_FILES);
print "</pre>";
require 'vendor/autoload.php';
#use Aws\S3\S3Client;
#$client = S3Client::factory();
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
$bucket = uniqid("php-jay-",false);
	  $sns= new Aws\Sns\SnsClient([
	  'version' => 'latest',
	  'region'  => 'us-east-1'
]);
$result = $s3->createBucket([
    'ACL' => 'public-read',
    'Bucket' => $bucket
]);
$result = $s3->putObject([
    'ACL' => 'public-read',
    'Bucket' => $bucket,
   'Key' => $uploadfile,
   'SourceFile' => $uploadfile 
]);  
$url = $result['ObjectURL'];
echo $url;
$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'jaysharma-rds',
]);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
    echo "============\n". $endpoint . "================";
$link = mysqli_connect($endpoint,"JaySharma","sharma1234","datadb") or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* Prepared statement, stage 1: prepare */
if (!($stmt = $link->prepare("INSERT INTO data (id, email,phone,filename,s3rawurl,s3finishedurl,status,issubscribed) VALUES (NULL,?,?,?,?,?,?,?)"))) {
    echo "Prepare failed: (" . $link->errno . ") " . $link->error;
}
$email = $_POST['useremail'];
$phone = $_POST['phone'];
$s3rawurl = $url; //  $result['ObjectURL']; from above
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "none";
$status =0;
$issubscribed=0;
$stmt->bind_param("sssssii",$email,$phone,$filename,$s3rawurl,$s3finishedurl,$status,$issubscribed);
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
printf("%d Row inserted.\n", $stmt->affected_rows);
/* explicit close recommended */
$stmt->close();
$link->real_query("SELECT * FROM data");
$res = $link->use_result();
echo "Result set order...\n";
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . " " . $row['email']. " " . $row['phone'];
}
$sqlsns = "SELECT * FROM snstopic";
$result = mysqli_query($link, $sqlsns);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
	$result = $sns->publish([
	    'Message' => 'Congratulations your Image uploaded successfully', // REQUIRED
	    'Subject' => 'UPLOAD',
	    'TopicArn' => $row["topicArn"],
	]);
    }
} 
else {
    echo "SNS Result";
}
$link->close();
header( "refresh:3;url=gallary1.php" );
?>
