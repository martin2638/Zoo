<?php
$titre = 'Charge d’un employé';
include('entete.php');

	  $requete = " select distinct nomE from zoo.LesGardiens order by nomE";
	  $curseur = oci_parse ($lien, $requete) ;
	  oci_execute ($curseur) ;
	  $res = oci_fetch($curseur);

	  if ($res) {
	    echo "<form method=\"post\" action=\"ChargeEmploye-action.php\">";
	    //liste des pays
	    echo "Choisir un Gardien (un seul): <p><select size=\"3\" name=\"nomE\"> ";
	    do {
		$unGardien = oci_result ($curseur,1);
		echo "<option value=\"$unGardien\">$unGardien</option> ";
	    } while (oci_fetch ($curseur)); 
	    oci_free_statement ($curseur);
	    echo "</select> </p>";
	    echo "<p> <input type=\"submit\" value=\"OK\"/>   </p>";
	    echo "<input type=\"hidden\" name=\"role\" value=\"gardien\" />";
	    echo "</form>";
	  }
	  else {
	    echo LeMessage ("Gardieninconnu") ;
	  }

 $requete = " select distinct nomE from zoo.LesResponsables order by nomE";
	  $curseur = oci_parse ($lien, $requete) ;
	  oci_execute ($curseur) ;
	  $res = oci_fetch($curseur);

	  if ($res) {
	    echo "<form method=\"post\" action=\"ChargeEmploye-action.php\">";
	    //liste des pays
	    echo "Choisir un Responsable (un seul): <p><select size=\"3\" name=\"nomE\"> ";
	    do {
		$unResponsable = oci_result ($curseur,1);
		echo "<option value=\"$unResponsable\">$unResponsable</option> ";
	    } while (oci_fetch ($curseur)); 
	    oci_free_statement ($curseur);
	    echo "</select> </p>";
	    echo "<p> <input type=\"submit\" value=\"OK\"/> </p>";
	    echo "<input type=\"hidden\" name=\"role\" value=\"responsable\" />";
	    echo "</form>";
	  }
	  else {
	    echo LeMessage ("Responsableinconnu") ;
	  }


include('pied.php'); ?>
