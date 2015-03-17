<?php
$titre = 'Ajout d\'une nouvelle maladie';
include('entete.php');

if( (isset($_POST['nomA']) && !empty($_POST['nomA'])) && (isset($_POST['nomM']) && !empty($_POST['nomM'])))
{
  // construction de la requete
  $requete = "insert into lesMaladies values ('{$_POST['nomA']}', '{$_POST['nomM']}') ";

  // analyse de la requete et association au curseur
  $curseur = oci_parse ($lien, $requete) ;

  // execution de la requete
  $res = oci_execute ($curseur,OCI_NO_AUTO_COMMIT) ;

  if ($res) {
    echo LeMessage ("majOK") ;
    // terminaison de la transaction : validation
    oci_commit ($lien) ;
  }
  else {
    echo LeMessage ("majRejetee") ;
    // terminaison de la transaction : annulation
    oci_rollback ($lien) ;
  }


}
else
{
$requete = " select nomA from LesAnimaux order by nomA";
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
	    echo "Maladie : <input type=\"text\" name=\"nomM\" />";
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