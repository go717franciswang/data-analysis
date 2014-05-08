<?

class HoltWinters
{
    function __construct($alpha, $beta, $gamma, $k)
    {
        $this->alpha = $alpha;
        $this->beta = $beta;
        $this->gamma = $gamma;
        $this->k = $k;
    }

    public function forecast($series, $output_len)
    {
        $s = array($series[0]);
        $t = array($series[1]-$series[0]);
        $p = array(1);

        $cap = min(count($series), $output_len);
        for ($i = 1; $i < $cap; $i++) {
            $x = $series[$i];
            $pik = 1;
            if (isset($p[$i-$this->k])) {
                $pik = $p[$i-$this->k];
            }

            $s[$i] = $this->alpha * $x / $pik + 
                (1 - $this->alpha) * ($s[$i-1] + $t[$i-1]);
            $t[$i] = $this->beta * ($s[$i] - $s[$i-1]) + 
                (1 - $this->beta) * $t[$i-1];
            $p[$i] = $this->gamma * $x / $s[$i] + 
                (1 - $this->gamma) * $pik;

            echo "x: $x, s: $s[$i], t: $t[$i], p: $p[$i]\n";
        }

        $i = count($s)-1;
        for ($h = 0; $h < $output_len-count($series); $h++) {
            $pik = $i-$this->k+$h;
            $s[$i+$h] = ($s[$i] + $h*$t[$i]) * $p[$pik];
        }

        return $s;
    }
}
