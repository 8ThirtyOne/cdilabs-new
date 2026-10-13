<?php
$options = [
    'credentials' => [
        'key'    => DO_ACCESS_KEY_ID,
        'secret' => DO_SECRET_ACCESS_KEY,
    ],
    'region' => DO_DEFAULT_REGION,
    'endpoint' => DO_ENDPOINT,
];
$awsClient = new Aws\S3\S3Client($options);
$adapter = new League\Flysystem\AwsS3V3\AwsS3V3Adapter(
    $awsClient,
    DO_SPACES
);
$filesystem = new League\Flysystem\Filesystem($adapter);