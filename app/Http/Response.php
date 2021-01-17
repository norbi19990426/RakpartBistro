<?php

namespace App\Http;

class Response{

    private $status;
    private $data;

    function __construct($status = "success", $data = null){
       $this->status = $status;
       $this->data = $data;
    }
}
