#!/usr/bin/php
<?php
require_once("voca_fr.php");

$L_iState=0;
$L_iCptEmptyLines=0;
$L_iCpt=0;
$L_bHeroAlive=1;
$L_iDebrayage=false;

$string=file_get_contents("dorf1.txt");
foreach(explode("\n", $string) as $line)
{
    $L_iStateOld=$L_iState;
//    $line=utf8_decode($line);
    if((strlen(trim($line))!=0)||($L_iDebrayage==true))
    {
        echo"[$L_iState]";
        echo"$line\n";

        switch($L_iState)
        {
            case 0: // ============================================================ Pièces d'or
//            echo substr($line,0,strlen($voca["GOLD"]))."\n";
                if(substr($line,0,strlen($voca["GOLD"]))==$voca["GOLD"])
                {
                    $L_iGold=intval(substr($line,strlen($voca["GOLD"])));
                    $L_iState=1;
                    echo "Gold = ".$L_iGold."\n";
                }
                break;
            case 1: // ============================================================ Pièces d'argent
                if(substr($line,0,strlen($voca["SILVER"]))==$voca["SILVER"])
                {
                    $L_iSilver=intval(substr($line,strlen($voca["SILVER"])));
                    $L_iState=2;
                    echo "Silver = ".$L_iSilver."\n";
                }
                break;

            case 2: // ============================================================ Tribu + pseudo
                if(substr($line,0,strlen($voca["GERMAINS"]))==$voca["GERMAINS"])
                {
                    $L_iTribe=2;
                    $L_sLogin=substr($line,strlen($voca["GERMAINS"]));
                    $L_iState=3;
                    echo "Tribe = ".$L_iTribe."\n";
                    echo "Login = ".$L_sLogin."\n";
                }
                if(substr($line,0,strlen($voca["ROMAINS"]))==$voca["ROMAINS"])
                {
                    $L_iTribe=1;
                    $L_sLogin=substr($line,strlen($voca["ROMAINS"]));
                    $L_iState=3;
                    echo "Tribe = ".$L_iTribe."\n";
                    echo "Login = ".$L_sLogin."\n";
                }
                if(substr($line,0,strlen($voca["GAULOIS"]))==$voca["GAULOIS"])
                {
                    $L_iTribe=3;
                    $L_sLogin=substr($line,strlen($voca["GAULOIS"]));
                    $L_iState=3;
                    echo "Tribe = ".$L_iTribe."\n";
                    echo "Login = ".$L_sLogin."\n";
                }
                break;
            case 3: // ============================================================ Ally
                if((substr($line,0,strlen($voca["HERODEAD"]))==$voca["HERODEAD"]))
                {
                    $L_bHeroAlive=0;
                    echo "Héros mort\n";
                }
                else if(
                    (substr($line,0,strlen($voca["VILLAGEDERATTACH"]))!=$voca["VILLAGEDERATTACH"])&&
                    (substr($line,0,strlen($voca["ENDEPLACEMENT"]))!=$voca["ENDEPLACEMENT"])&&
                    (substr($line,0,strlen($voca["SANTE"]))!=$voca["SANTE"])&&
                    (substr($line,0,strlen($voca["EXPERIENCE"]))!=$voca["EXPERIENCE"])
                )
                {
                    $L_sAlly=$line;
                    $L_iState=4;
                    echo "Ally = ".$L_sAlly."\n";
                }
                break;
            case 4: // ============================================================ News Ally ?
                if(
                    (substr($line,0,strlen($voca["INFOBOX"]))!=$voca["INFOBOX"])&&
                    (substr($line,0,strlen($voca["LISTEDESLIENS"]))!=$voca["LISTEDESLIENS"])
                )
                {
//                    list($a, $b, $c, $d, $e, $f, $g) = explode("\t", $line);
//                    echo "News : $a/$b/$c/$d/$e/$f/$g\n";
                    echo "News : ".trim($line)."\n";
                }
                else
                    $L_iState=5;
                break;
             case 5: // ============================================================ Liste de liens
                if(substr($line,0,strlen($voca["LISTEDESLIENS"]))==$voca["LISTEDESLIENS"])
                {
                    $L_iState=6;
                    $L_iCptEmptyLines=0;
                }
                break;
             case 6: // ============================================================ Dépôt
                if(
//                    ($L_iCptEmptyLines>=2)&&
                    (substr(trim($line),0,strlen($voca["DEPOTDERESSOURCES"]))==$voca["DEPOTDERESSOURCES"])
                )
                {
                    $L_iCapaciteDepot=intval(str_replace(" ","",substr(trim($line),strlen($voca["DEPOTDERESSOURCES"]))));
                    $L_iState=7;
                    echo "Capacité dépot = ".$L_iCapaciteDepot."\n";
                }
                break;
             case 7: // ============================================================ Bois
                $line=trim($line);
                if(substr($line,0,strlen($voca["BOIS"]))==$voca["BOIS"])
                {
                    $L_sTmp=trim(substr($line,strlen($voca["BOIS"])));
                    if(substr($L_sTmp,0,strlen($voca["BOIS25"]))==$voca["BOIS25"])
                    {
                        $L_iBonusBoisGold=25;
                        $L_sTmp=trim(substr($L_sTmp,strlen($voca["BOIS25"])));
                    }
                    else
                    {
                        $L_iBonusBoisGold=0;
                    }
                    $L_iProdBois=intval(str_replace(" ","",$L_sTmp));
                    $L_iState=8;
                    echo "Prod bois = ".$L_iProdBois." dont +".$L_iBonusBoisGold."% gold\n";
                }
                break;
             case 8: // ============================================================ Argile
                $line=trim($line);
                if(substr($line,0,strlen($voca["ARGILE"]))==$voca["ARGILE"])
                {
                    $L_sTmp=trim(substr($line,strlen($voca["ARGILE"])));
                    if(substr($L_sTmp,0,strlen($voca["ARGILE25"]))==$voca["ARGILE25"])
                    {
                        $L_iBonusArgileGold=25;
                        $L_sTmp=trim(substr($L_sTmp,strlen($voca["ARGILE25"])));
                    }
                    else
                    {
                        $L_iBonusArgileGold=0;
                    }
                    $L_iProdArgile=intval(str_replace(" ","",$L_sTmp));
                    $L_iState=9;
                    echo "Prod argile = ".$L_iProdArgile." dont +".$L_iBonusArgileGold."% gold\n";
                }
                break;
             case 9: // ============================================================ Fer
                $line=trim($line);
                if(substr($line,0,strlen($voca["FER"]))==$voca["FER"])
                {
                    $L_sTmp=trim(substr($line,strlen($voca["FER"])));
                    if(substr($L_sTmp,0,strlen($voca["FER25"]))==$voca["FER25"])
                    {
                        $L_iBonusFerGold=25;
                        $L_sTmp=trim(substr($L_sTmp,strlen($voca["FER25"])));
                    }
                    else
                    {
                        $L_iBonusFerGold=0;
                    }
                    $L_iProdFer=intval(str_replace(" ","",$L_sTmp));
                    $L_iState=10;
                    echo "Prod fer = ".$L_iProdFer." dont +".$L_iBonusFerGold."% gold\n";
                }
                break;
             case 10: // ============================================================ Silo
                if (substr(trim($line),0,strlen($voca["SILO"]))==$voca["SILO"])
                {
                    $L_iCapaciteSilo=intval(str_replace(" ","",substr(trim($line),strlen($voca["SILO"]))));
                    $L_iState=11;
                    echo "Capacité silo = ".$L_iCapaciteSilo."\n";
                }
                break;
             case 11: // ============================================================ Céréales
                $line=trim($line);
                if(substr($line,0,strlen($voca["CEREALES"]))==$voca["CEREALES"])
                {
                    $L_sTmp=trim(substr($line,strlen($voca["CEREALES"])));
                    if(substr($L_sTmp,0,strlen($voca["CEREALES25"]))==$voca["CEREALES25"])
                    {
                        $L_iBonusCCGold=25;
                        $L_sTmp=trim(substr($L_sTmp,strlen($voca["CEREALES25"])));
                    }
                    else
                    {
                        $L_iBonusCCGold=0;
                    }
                    $L_iProdCC=intval(str_replace(" ","",$L_sTmp));
                    $L_iState=12;
                    echo "Prod céréales = ".$L_iProdCC." dont +".$L_iBonusCCGold."% gold\n";
                }
                break;
             case 12: // ============================================================ Céréales disponibles
                if(substr(trim($line),0,strlen($voca["CCDISPO"]))==$voca["CCDISPO"])
                {
                    $L_iCCDispo=intval(str_replace(" ","",substr(trim($line),strlen($voca["CCDISPO"]))));
                    $L_iState=13;
                    echo "Céréales disponibles = ".$L_iCCDispo."\n";
                }
                break;
             case 13: //============================================================= Détection page
                if(substr(trim($line),0,strlen($voca["STATSTITLE"]))==$voca["STATSTITLE"]) // Page statistiques
                {
                    $L_iState=100;
                }
                else if(intval(trim($line))==trim($line)) // Page des champs
                {
                    $L_iCptChamps=1;
                    $L_iChamp[$L_iCptChamps]=intval(trim($line));
                    $L_iState=1000;
                }
                break;

//*********************************************************************************************************************************************** Bloc Statistiques (gold)
             case 100://============================================================= Page Statistiques - On passe l'onglet "Vue globale"
                if(substr(trim($line),0,strlen($voca["STATSGLOB"]))==$voca["STATSGLOB"])
                {
                    $L_iState=101;
                }
                break;
             case 101://============================================================= Page Statistiques - On passe l'onglet "Ressources"
                if(substr(trim($line),0,strlen($voca["STATSRESS"]))==$voca["STATSRESS"])
                {
                    $L_iState=102;
                }
                break;
             case 102://============================================================= Page Statistiques - On passe l'onglet "Dépôts"
                if(substr(trim($line),0,strlen($voca["STATSDEPOTS"]))==$voca["STATSDEPOTS"])
                {
                    $L_iState=103;
                }
                break;
             case 103://============================================================= Page Statistiques - On passe l'onglet "Points de culture"
                if(substr(trim($line),0,strlen($voca["STATSCULT"]))==$voca["STATSCULT"])
                {
                    $L_iState=110;
                }
                break;
             case 110://============================================================= Page Statistiques - Onglet "Troupes"
                if(substr(trim($line),0,strlen($voca["STATSTROOPSVILLAGES"]))==$voca["STATSTROOPSVILLAGES"])
                {
                    $L_iState=111;
                }
                break;
             case 111://============================================================= Page Statistiques - Onglet "Troupes"
                if(substr(trim($line),0,strlen($voca["STATSTROOPSTITLE"]))==$voca["STATSTROOPSTITLE"])
                {
                    $L_iState=112;
                }
                break;
             case 112://=========================== ================================== Page Statistiques - Tableau des troupes
                if(strpos($line,"\t")===false)
                {
                    $L_iState=5000;
                    unset($L_tTroupes[$L_iCpt-1]);
                    var_dump($L_tTroupes);
                }
                else
                {
                    list($L_tTroupes[$L_iCpt][0],$L_tTroupes[$L_iCpt][1],$L_tTroupes[$L_iCpt][2],
                         $L_tTroupes[$L_iCpt][3],$L_tTroupes[$L_iCpt][4],$L_tTroupes[$L_iCpt][5],
                         $L_tTroupes[$L_iCpt][6],$L_tTroupes[$L_iCpt][7],$L_tTroupes[$L_iCpt][8],
                         $L_tTroupes[$L_iCpt][9],$L_tTroupes[$L_iCpt][10],$L_tTroupes[$L_iCpt][11]) = explode("\t", $line);
                    $L_iCpt+=1;
                }
                break;

             case 1000://============================================================= Page Champs
                if(intval(trim($line))==trim($line))
                {
                    $L_iCptChamps+=1;
                    $L_iChamp[$L_iCptChamps]=intval(trim($line));
                }
                break;

                       //============================================================= BLOC DROIT
            case 5000://============================================================= Loyauté du village en cours
                if(substr($line,0,strlen($voca["LOYALTY"]))==$voca["LOYALTY"])
                {
                    $line=utf8_decode($line);
                    $line=str_replace("?","",$line);
                    $L_iLoyalty=intval(substr($line,strlen($voca["LOYALTY"]),strlen($line)-strlen($voca["LOYALTY"])-1));
                    $L_iState=5001;
                    echo "Loyauté = ".$L_iLoyalty."%\n";
                }
                break;
            case 5001://============================================================= Nombre de villages/Nb de villages constructibles
                    $line=utf8_decode($line);
                    $line=str_replace("?","",$line);
                    list($L_iVillagesNb,$L_iVillagesPotentiels) = explode("/", $line);
                    $L_iState=5002;
                    echo "Nb Villages = ".$L_iVillagesNb."\nAssez de PC pour : ".$L_iVillagesPotentiels."\n";
                    break;
            case 5002://============================================================= Villages :
                if(substr(trim($line),0,strlen($voca["VILLAGES"]))==$voca["VILLAGES"])
                {
                    $L_iState=5003;
                    $L_iCptVillages=$L_iVillagesNb;
                }
                break;
            case 5003://============================================================= Nom village
                $L_sVillage[$L_iCptVillages]=trim($line);
                echo $L_sVillage[$L_iCptVillages]." ";
                $L_iState=5004;
                break;
            case 5004://============================================================= Coords village
                list($L_sX,$L_sY)= explode("|",substr(str_replace("?","",utf8_decode($line)),1,-1));
                $L_iX[$L_iCptVillages]=intval($L_sX);
                $L_iY[$L_iCptVillages]=intval($L_sY);
                echo "(".$L_iX[$L_iCptVillages]."/".$L_iY[$L_iCptVillages].")\n";
                $L_iCptVillages=$L_iCptVillages-1;
                if($L_iCptVillages<=0)
                    $L_iState=9000;
                else
                    $L_iState=5003;
                break;


                       //============================================================= FOOTER
            case 9000://============================================================= Heure du serveur
                $line=trim($line);
                if(substr($line,0,strlen($voca["TIME"]))==$voca["TIME"])
                {
                    $L_sTmp=trim(substr($line,strlen($voca["TIME"])));
                    list($L_iHH,$L_iMM,$L_iSS)=explode(":",$L_sTmp);
                    echo "Heure serveur : ".$L_iHH.":".$L_iMM.":".$L_iSS."\n";
                    $L_iState=10000;
                }
                break;

            default:
            case 10000://============================================================= FIN
                echo $line."\n";
                break;
        }
//        if($L_iStateOld==$L_iState) // On n'a pas changé d'état - Problème de détection éventuel
//        {
//            die("Problème de détection à l''état #".$L_iState.". Chaine [".trim($line)."]\n");
//        }
    }
    else
    {
        $L_iCptEmptyLines+=1;
    }


}


?>
