<?php
session_start();
require 'vendor/autoload.php';
echo  $_POST['phone'];
$phone = $_POST['phone'];
$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
$result = $rds->describeDBInstances(['DBInstanceIdentifier' => 'jaysharma-rds']);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
$link = mysqli_connect($endpoint,"JaySharma","sharma1234","datadb") or die("Error " . mysqli_error($link));
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$sql1 = "SELECT topicArn,topicName FROM snstopic ";
$result = mysqli_query($link, $sql1);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
	if ($row["topicName"] == 'A20344475-SNS-SERVICE')
	{
	$sns= new Aws\Sns\SnsClient([
	    'version' => 'latest',
	    'region'  => 'us-east-1'
	]);
	$result = $sns->subscribe([
	    'Endpoint' => $phone,
	    'Protocol' => 'sms', // REQUIRED
	    'TopicArn' => $row["topicArn"], // REQUIRED
	]);
	}
	
    }
} 
$sArn= $result['SubscriptionArn'];
echo $subArn;
echo "Subscribe by replying Yes"
header( "refresh:5;url=index.php" );
?>

