<?php 
$titre = 'Détails d’un animal';
include('entete.php');
if( isset($_POST['nomA']) && !empty($_POST['nomA'])
)
{
   $nomA = $_POST['nomA'];
   $requete = "select nomA, type, pays, sexe, anNais from zoo.LesAnimaux  "
	    ." where lower(nomA) = lower(:n) ";	
   $curseur = oci_parse ($lien, $requete) ;
	  //liaison entre la var PHP et le parametre SQL
	  oci_bind_by_name ($curseur, ":n", $nomA) ;
   
}
elseif(isset($_POST['pays']) && !empty($_POST['pays']))
{
   $pays = $_POST['pays'];
   $requete = "select nomA, type, pays, sexe, anNais from zoo.LesAnimaux  "
	    ." where lower(pays) = lower(:n) ";
   $curseur = oci_parse ($lien, $requete) ;
	  //liaison entre la var PHP et le parametre SQL
	  oci_bind_by_name ($curseur, ":n", $pays) ;
}
else
{
   $ne_pas_connecter = true; // alors on ne se connecte pas à la base
}



if(isset($ne_pas_connecter)) {
  echo '<p class="erreur"> Vous devez donner un nom d’animal. Vous pouvez utiliser <a href="DetailsAnimal.php">cette page</a>. </p>';
} else {
	  // evaluation
	  oci_execute ($curseur) ;
	  $res = oci_fetch ($curseur) ;
	  if (!$res) {
	    // no row selected
	    echo "<p class=\"erreur\"><b> Animal inconnu </b></p>" ;
	  }
	  else {
	    // Affichage des colonnes
	    do {
	      $nom = oci_result($curseur,1);   
	      $type = oci_result ($curseur, 2) ;
	      $lepays = oci_result ($curseur, 3) ;
	      $sexe = oci_result ($curseur, 4) ;
	      $anNais = oci_result ($curseur, 5) ;	


	      echo "<p>$nom est un $sexe $type; il est né(e) le $anNais en/au $lepays</p>";
	    } while (oci_fetch ($curseur));
	  }
	    oci_free_statement ($curseur) ;
}
include('pied.php');
?>
