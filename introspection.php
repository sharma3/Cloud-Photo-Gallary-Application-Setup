<?php
require 'vendor/autoload.php';

#http://www.tutorialspoint.com/php/perform_mysql_backup_php.htm
$rds = new Aws\Rds\RdsClient([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
$result = $rds->describeDBInstances([
    'DBInstanceIdentifier' => 'jaysharma-rds',
]);
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
 
$link = mysqli_connect($endpoint,"JaySharma","sharma1234","datadb") or die("Error " . mysqli_error($link));

$dbname = 'datadb';
$dbuser = 'JaySharma';
$dbpass = 'sharma1234';
mkdir("/tmp/DTBC");
$Bkpspath = '/tmp/DTBC/';
$bname = uniqid("DBB", false);
$append = $bname . '.' . sql;
$Path = $Bkpspath . $append;
$sql="mysqldump --user=$dbuser --password=$dbpass --host=$endpoint $dbname > $Path";
exec($sql);

$bucket = uniqid("back-jay-",false);
$s3 = new Aws\S3\S3Client([
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
   'Key' => $append,
'SourceFile' => $Path,
]);

$objectrule = $s3->putBucketLifecycleConfiguration([
    'Bucket' => $bucket,
    'LifecycleConfiguration' => [
        'Rules' => [ 
            [
                'Expiration' => [
                    'Days' => 1,
                ],
                'NoncurrentVersionExpiration' => [
                    'NoncurrentDays' => 1,
                ],              
                'Prefix' => ' ',
                'Status' => 'Enabled',
                
            ],
            
        ],
    ],
]);

mysql_close($link);
echo "Congratulations backup your database done!";
header( "refresh:3;url=index.php" );
?>
