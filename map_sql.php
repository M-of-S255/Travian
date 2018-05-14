#!/usr/bin/php

<?php

function update_sql_map($mysqlhost, $mysqldb, $mysqluser, $mysqlpass, $s = 'ts3', $lang = 'fr', $gz = '')
{
    $datemaj = date('d-m-Y H:i:s');
    $connection = mysqli_connect($mysqlhost,$mysqluser, $mysqlpass);
    unset($mysqlpass);
    mysqli_select_db($connection,$mysqldb) or die(mysqli_error($connection));
    mysqli_query($connection,"SET NAMES UTF8") or die(mysql_error($connection) );
    mysqli_query($connection,"DROP TABLE IF EXISTS `x_world`") or die(mysql_error($connection) );
    $result=mysqli_query($connection,"CREATE TABLE `x_world` (`id` int(9) unsigned NOT NULL default '0',
`x` smallint(3) NOT NULL default '0',
`y` smallint(3) NOT NULL default '0',
`tid` tinyint(1) unsigned NOT NULL default '0',
`vid` int(9) unsigned NOT NULL default '0',
`village` varchar(64) NOT NULL default '',
`uid` int(9) NOT NULL default '0',
`player` varchar(64) NOT NULL default '',
`aid` int(9) unsigned NOT NULL default '0',
`alliance` varchar(64) NOT NULL default '',
`population` smallint(5) unsigned NOT NULL default '0',
UNIQUE KEY `id` (`id`))") or die(mysql_error($connection) );

    $mapurl = "http://$s.travian.$lang/map.sql$gz";// le fichier
//    $lignes = file($mapurl, FILE_TEXT && FILE_SKIP_EMPTY_LINES); // directement en tableau
//    echo("Nb de lignes : ".count($lignes)."\n");
//    $L_iCpt=count($lignes);
//    for ($i=0; $i<$L_iCpt;$i++)
//        mysqli_query($connection,$lignes[$i]) or die(mysql_error($connection) );

        $data=file_get_contents($mapurl);

        $handle=fopen("/home/cski/Travail/bot travian/".$s."-".date("Ymd").".sql","w");
        fwrite ($handle , $data);

        mysqli_multi_query($connection,$data) or die(mysql_error($connection) );

        $L_iCpt=0;

        while (mysqli_next_result($connection))
        {
            $L_iCpt=($L_iCpt+1)&1023;
            if($L_iCpt==0) echo ("*");
        }
        echo("\n");
//    $j = mysql_result(mysql_query("SELECT COUNT(*) FROM `x_world`"),0);
    // @mysql_query("DROP TABLE IF EXISTS `$x_world`", $connection) ;
    // @mysql_query("ALTER TABLE `x_world` RENAME TO `$x_world`");

    mysqli_query($connection, "call Update_Data()") or die(mysql_error($connection) );

    mysqli_close($connection);
}

update_sql_map("localhost","ts1","travian","travian","ts1","fr");

?>
