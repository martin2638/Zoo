<?php
$titre = 'Gardiens et responsable d\'un animal';
include('entete.php');

if( isset($_POST['nomA']) && !empty($_POST['nomA'])
)
{
 $nomA = $_POST['nomA'];
   $requete1 = "select nomE from zoo.lesResponsables natural join zoo.lesCages natural join zoo.lesAnimaux "
	    ." where lower(nomA) = lower(:n) ";
   $requete2 = "select nomE from zoo.lesGardiens natural join zoo.lesAnimaux where lower(nomA) = lower(:n)";
   $curseur = oci_parse ($lien, $requete1) ;
	  //liaison entre la var PHP et le parametre SQL
	  oci_bind_by_name ($curseur, ":n", $nomA) ;
    
	  oci_execute ($curseur) ;
	  $res = oci_fetch ($curseur) ;
	  if (!$res) {
	    // no row selected
	    echo "<p class=\"erreur\"><b> pas de responsable !!!! </b></p>" ;
	  }
	  else {
		$nomR=oci_result($curseur,1);
		echo"le responsable est $nomR <br />";
		}
	  $curseur = oci_parse($lien,$requete2);
	  oci_bind_by_name ($curseur, ":n", $nomA) ;
	  oci_execute ($curseur) ;
	  $res = oci_fetch ($curseur) ;
	  if (!$res) {
	    // no row selected
	    echo "<p class=\"erreur\"><b> pas de gardien !!!! </b></p>" ;
	  }
	  else {
		do{
		    $nomG=oci_result($curseur,1);
		    echo"le gardien est $nomG <br />";
		}while(oci_fetch($curseur));
		}
	oci_free_statement ($curseur);
	echo "<form method=\"post\" action=\"#\">";
	    //liste des pays
	echo "<br /><br /> Choisir un autre animal:";
	
	echo "<p> <input type=\"submit\" value=\"OK\"/> ";
	echo "</p>";
	echo "</form>";

}
else
{
  $requete = " select nomA from zoo.LesAnimaux order by nomA";
	  $curseur = oci_parse ($lien, $requete) ;
	  oci_execute ($curseur) ;
	  $res = oci_fetch($curseur);

	  if ($res) {
	    echo "<form method=\"post\" action=\"#\">";
	    //liste des pays
	    echo "Choisir un animal (un seul): <p><select size=\"3\" name=\"nomA\"> ";
	    do {
		$unAnimal = oci_result ($curseur,1);
		echo "<option value=\"$unAnimal\">$unAnimal</option> ";
	    } while (oci_fetch ($curseur)); 
	    oci_free_statement ($curseur);
	    echo "</select> </p>";
	    echo "<p> <input type=\"submit\" value=\"OK\"/> 
	              <input type=\"reset\" value=\"Remise à zéro\"/> </p>";
	    echo "</form>";
	  }
	  else {
	    echo LeMessage ("animalinconnu") ;
	  }
}
include('pied.php');
?>