<?php
/*
 
  ----------------------------------------------------------------------
GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2004 by the INDEPNET Development Team.
 
 http://indepnet.net/   http://glpi.indepnet.org
 ----------------------------------------------------------------------
 LICENSE

This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
 
// ----------------------------------------------------------------------
// Original Author of file:
// Purpose of file:
// ----------------------------------------------------------------------

include ("_relpos.php");
include ($phproot . "/glpi/includes.php");

checkAuthentication("normal");
commonHeader("Reports",$_SERVER["PHP_SELF"]);


$item_db_name[0] = "glpi_computers";
$item_db_name[1] = "glpi_printers";
$item_db_name[2] = "glpi_monitors";
$item_db_name[3] = "glpi_networking";
$item_db_name[4] = "glpi_peripherals";

$db = new DB;


# Titre

echo "";
echo "<big><b><strong>Liste du materiel</strong></b></big><br><br>";

# Construction  la requete, et appel de la fonction affichant les valeurs.
if(isset($_POST["item_type"][0])&&$_POST["item_type"][0] != 'tous')
{
		
		foreach($_POST["item_type"] as $key => $val){
		$query = "select * from ".$val;
		
		if(isset($_POST["annee"][0])&&$_POST["annee"][0] != 'toutes')
		{
			$query.= " where ( '1'='0' ";
				foreach ($_POST["annee"] as $key2 => $val2)
				$query.= " OR YEAR(".$_POST["date_type"].") = '".$val2."'";
				$query.=" ) ";
		}

		$query.= " order by ".$_POST["tri_par"]." asc";
		report_perso($val,$query);
		}
}
else
{
	$query=array();
		for($i=0;$i<count($item_db_name);$i++)
		{
			$query[$i] = "select * from ".$item_db_name[$i]." ";


		if(isset($_POST["annee"][0])&&$_POST["annee"][0] != 'toutes')
		{
			$query[$i].= " where ( '1'='0' ";
				foreach ($_POST["annee"] as $key2 => $val2)
				$query[$i].= " OR YEAR(".$_POST["date_type"].") = '".$val2."'";
				$query[$i].=" ) ";
		}
		
			$query[$i].=" order by ".$_POST["tri_par"]." asc";
			report_perso($item_db_name[$i],$query[$i]);
		 }		
}
commonFooter();
?>
