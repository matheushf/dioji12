<?php
require_once 'Zend/Cache.php';

$frontendOptions = array(
    'lifetime' => 300, // 5 minutes
    'automatic_serialization' => true
);

$backendOptions = array(//'cache_dir' => 'c:\\Tmp\\' // Directory where to put the cache files
);

// getting a Zend_Cache_Core object
$cache = Zend_Cache::factory(
    'Core',
    'File',
    $frontendOptions,
    $backendOptions
);

abstract class PUserControl
{
    protected $Id;

    public function getId()
    {
        return $this->Id;
    }

    public function setId($Id)
    {
        $this->Id = $Id;
    }

}

class UserControl extends PUserControl
{

}

?>