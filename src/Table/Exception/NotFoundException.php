<?php
namespace App\Table\Exception;

class NotFoundException extends \Exception {

    public function __construct( string $table, $id)
    {
        $this->message = "no record match with following id: #$id in following table:  $table";
    }
}