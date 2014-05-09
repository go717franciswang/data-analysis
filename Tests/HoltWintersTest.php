<?

require_once dirname(__FILE__) . "/../holt-winters.php";

class SstTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $alpha = 0.2;
        $beta = 0.1;
        $gamma = 0.05;
        $k = 4;
        $this->h = new HoltWinters($alpha, $beta, $gamma, $k);
    }

    public function testForecast()
    {
        $series = array(146, 96, 59, 133, 192, 
            127, 79, 186, 272, 155, 98, 219);
        $est = $this->h->forecast($series, count($series) + 4);
        $last4 = array_slice($est, count($series));
        $this->assertEquals($last4,
            array(310.8, 196.3, 117.7, 263.4), 
            'incorrect forecast',
            0.1);
    }
}
