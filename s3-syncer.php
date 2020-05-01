<?php
/*
Plugin Name: S3-Syncer
Description: Sync files to Amazon S3
Version: 0.0.1
Author: Matthew Watson
*/

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

class S3Syncer {

  public function __construct() {
    add_action( 'local_to_s3_sync', array($this, 'local_to_s3_sync') );
    add_action( 's3_to_local_sync', array($this, 's3_to_local_sync') );
  }

 /**
  * Sync Local Media to S3 Bucket
  */
  function local_to_s3_sync() {
    $media = wp_get_upload_dir();

    // Create an S3 client
    $client = new \Aws\S3\S3Client([
        'region'  => 'eu-central-1',
        'version' => '2006-03-01',
    ]);

    // Where the files will be source from
    $source = $media->basedir;

    // Where the files will be transferred to
    $dest = 's3://persistent.theauditionsociety.com';

    // Create a transfer object
    $manager = new \Aws\S3\Transfer($client, $source, $dest);

    // Perform the transfer synchronously
    $manager->transfer();
  }

  /**
   * Sync S3 Bucket Media to Local Folder
   */
   function s3_to_local_sync() {}

}
