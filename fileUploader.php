<?php
class FileUploader
{
    // Member variables
    private $target_directory = "uploads/";
    public $target_file;
    private $size_limit = 50000; // Size give in bytes
    private $uploadOk = false;
    private $file_original_name;
    private $file_type;
    private $file_size;
    private $final_file_name;

// getters and setters
