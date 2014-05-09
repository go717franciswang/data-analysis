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
        $t = $this->initial_trend($series);
        $p = $this->initial_seansonal_indices($series);
        $F = $s;

        $cap = min(count($series), $output_len);
        for ($i = 1; $i < $cap; $i++) {
            $x = $series[$i];
            $ik = $i >= $this->k ? $i-$this->k : $i;
            $pik = $p[$ik];

            $s[$i] = $this->alpha * $x / $pik + 
                (1 - $this->alpha) * ($s[$i-1] + $t[$i-1]);
            $t[$i] = $this->beta * ($s[$i] - $s[$i-1]) + 
                (1 - $this->beta) * $t[$i-1];
            $p[$i] = $this->gamma * $x / $s[$i] + 
                (1 - $this->gamma) * $pik;

            $ik = $i-1 >= $this->k ? $i-$this->k-1 : $i-1;
            $F[$i] = ($s[$i-1] + $t[$i-1]) * $p[$ik];
        }

        $i = count($s)-1;
        for ($h = 1; $h <= $output_len-count($series); $h++) {
            $pik = $i-$this->k+($h % $this->k);
            $F[$i+$h] = ($s[$i] + $h*$t[$i]) * $p[$pik];
        }

        return $F;
    }

    private function initial_trend($series)
    {
        $sum = 0;
        for ($i = 0; $i < $this->k; $i++) {
            $sum += ($series[$this->k+$i] - $series[$i]) / 
                $this->k;
        }

        return array($sum / $this->k);
    }

    private function initial_seansonal_indices($series)
    {
        $cycles = floor(count($series) / $this->k);
        $p = array_fill(0, $this->k, 0);

        for ($i = 0; $i < $cycles; $i++) {
            $cycle_avg = 0;
            for ($j = 0; $j < $this->k; $j++) {
                $cycle_avg += $series[$i*$this->k + $j];
            }
            $cycle_avg /= $this->k;

            for ($j = 0; $j < $this->k; $j++) {
                $p[$j] += $series[$i*$this->k + $j] / $cycle_avg;
            }
        }

        for ($i = 0; $i < $this->k; $i++) {
            $p[$i] /= $cycles;
        }

        return $p;
    }
}
