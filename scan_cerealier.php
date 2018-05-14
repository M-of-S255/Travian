#!/usr/bin/php
<?php
    $px=0;
    $py=0;
/*
    function max($a,$b,$c)
    {
        if($a>$b)
        {
            if($a>$c)
                return $a;
            else
                return $c;
        }
        else
        {
            if($b>$c)
                return $b;
            else
                return $c;
        }
    }
*/
    function dist($x1,$y1,$x2,$y2)
    {
        return sqrt(($x1-$x2)*($x1-$x2)+($y1-$y2)*($y1-$y2));
    }

    function intersection($x1,$y1,$r1,$x2,$y2,$r2,$x3,$y3,$r3)
    {
        global $px,$py;

        $r=max($x1,max($x2,$x3));
        $l=-max(-$x1,max(-$x2,-$x3));
        $t=max($y1,max($y2,$y3));
        $b=-max(-$y1,-max($y2,-$y3));

//        echo"$l,$r $b,$t\n";

        $x=$l;
        $y=$b;

        while($x<=$r)
        {
//            echo $x."/".$y."-";

            $y=$b;

            while($y<=$t)
            {
                if ((round(dist($x,$y,$x1,$y1)*10)==round($r1*10)) &
                    (round(dist($x,$y,$x2,$y2)*10)==round($r2*10)) &
                    (round(dist($x,$y,$x3,$y3)*10)==round($r3*10)))
                {
                    $px=$x;
                    $py=$y;
                    return;
                }
                $y+=1;
            }
            $x+=1;
        }
    }

    $a=$b=$c=$d=$e=$f=$g=$h=$i='A';

    $string=file_get_contents("cerealiers.txt");
    foreach(explode("\n", $string) as $line) {
        if(is_numeric(substr($line,0,1)))
        {
            $line=utf8_decode($line);
            list($L_sDist, $L_sPos, $dummy, $L_sType, $L_sOasis, $L_sOcc, $L_sAlly) = explode("\t", $line);
 //           echo $L_sDist."**".$L_sPos."**".$L_sType."**".$L_sOasis."**".$L_sOcc."**".$L_sAlly."\n";
            $L_iDist=floatval($L_sDist);
            $L_iType=intval(substr($L_sType,0,2));
 //           echo substr(trim($L_sPos),1)."\n";
            list($L_sX,$L_sY)= explode("|",substr(str_replace("?","",$L_sPos),1,-1));
 //           echo $L_sX."/".$L_sY."\n";
            $L_iX=intval($L_sX);
            $L_iY=intval($L_sY);
            list($dummy,$L_sPercent)= explode("+",$L_sOasis);
            $L_iPercent=intval(substr($L_sPercent,0,-1));
            echo "(".$L_iX."/".$L_iY.")".$L_iType."CC+".$L_iPercent."% - ".$L_iDist."\n";

            if(!is_numeric($a))
            {
                $a=$d;
                $b=$e;
                $c=$f;
                $d=$g;
                $e=$h;
                $f=$i;

                $g=$L_iX;
                $h=$L_iY;
                $i=$L_iDist;

                if(is_numeric($a))
                {
                    intersection($a,$b,$c,$d,$e,$f,$g,$h,$i);
                    echo "Centre : (".$px."/".$py.")\n";
                }
            }
        }
    }
?>
