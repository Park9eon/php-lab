<?php

require_once 'vendor/autoload.php';

class Test
{
    private $connector = null;

    public function __construct()
    {
        $this->connector = Connector::init();
    }

    function execute()
    {
        return $this->connector->execute("SELECT 1 as idx, 'foo' as name, 2 as number_1, 3 as number_2, 4 as number_3, 5 as number_4", []);
    }

    function testFetchObject()
    {
        $result = $this->execute()->fetch_object();
    }

    function testFetchArray()
    {
        $result = $this->execute()->fetch_array();
    }

    function testFetchArrayAssoc()
    {
        $result = (object)$this->execute()->fetch_array(MYSQLI_ASSOC);
    }

    function testFetchAssoc()
    {
        $result = $this->execute()->fetch_assoc();
    }
}
function timer($context, $function, $count)
{
    $start_time = microtime(true);
    for ($i = 0 ; $i < $count ; $i++) {
        $context->$function();
    }
    $end_time = microtime(true);
    $second = ($end_time - $start_time);
    echo sprintf("%s / %d회 / %.2f초 ", str_pad($function, 20), $count, $second) . PHP_EOL;
}

$test = new Test();
$function_list = [
    "testFetchObject",
    "testFetchArray",
    "testFetchArrayAssoc",
    "testFetchAssoc",
];

$count_list = [
    1,
    100,
    10000,
    1000000,
];

foreach ($count_list as $count) {
    foreach ($function_list as $function) {
        timer($test, $function, $count);
    }
}

