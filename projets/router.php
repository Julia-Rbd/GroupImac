<?php
	require_once('controllerProjet.php');
	
	$page = explode('/',$_SERVER['REQUEST_URI']);
	// to handle the query as an array, each element containing a part of the global URL
	$method = $_SERVER['REQUEST_METHOD'];
	
	/* NOTE : Mes url ressemblent à 
		localhost/cours_web/groupimac/router.php/projets 
		et à localhost/cours_web/groupimac/router.php/projet/id 
		donc $page[4] correspond à "projets" et "projet" 
		et $page[5] à "id" 
		pensez à faire le décalage chez vous ! 
		
		[Il faudra aussi penser à le faire avant de mettre en ligne btw]
	*/

	// si $page[4] existe   
	if (isset($page[4])) {
		switch($page[4]) {
			case 'projets' : 
				switch($method) {
					case 'GET' : 
						// affiche tous les projets (en tant que table pour le moment)
						echo getProjetsAsTable();
						break;

					case 'POST' :
						// ajoute un projet 
						$json = file_get_contents('php://input');
						echo addAProjet($json);
						break;

					default:
						http_response_code('404');
						echo 'OOPS';
				}
				break;

			case 'projet' :
				if (isset($page[5])) {
					switch($method) {
						case 'GET' : 
							// récupérer un seul projet 
							echo getAProjetByID($page[5]);
							break;

						case 'DELETE' :
							// supprimer un projet 
							echo deleteAProjet($page[5]);
							break;

						case 'UPDATE' :
							// modifier un projet (grâce à un json généré + son id) 
							$json = file_get_contents('php://input');
							echo updateAProjet($json, $page[5]);
							break;					

						default:
							http_response_code('404');
							echo 'OOPS';
					}
				}
				
				break;
			
			default: 
				http_response_code('500');
				echo 'unknown endpoint';
				break;
		}
	}

	

?>