<?php
class Gallery extends Controller {
  public function index() {
    $this->albums();
  }
  
  public function albums() {
    $title='Les Albums disponibles';
    $this->loader->load('albums',['title'=>$title,'albums'=>$this->gallery->albums()]);
    // printf == //var_dump($this->gallery->albums());
  }

  public function albums_new() {
    $title='Créateur d\'un nouvel Album';
    $this->loader->load('albums_new',['title'=>$title]);
  }
  
  public function albums_create() {
	try {
	    $album_name = filter_input(INPUT_POST, 'album_name');
	    $this->gallery->create_album($album_name);
	    /* Créer l'album avec le modèle. */
	    /* Si on ne redirige pas alors le this->loader->load va simplement mettre a jour la page sans changer l'url */
            /* En cas de raffraichissement, le programme va bugger solution ---> faire le changement de l'url */
	    header('Location: /index.php/gallery/albums'); /* redirection du client vers la liste des albums. */
	} 
	catch (Exception $e) 
	{
    		$this->loader->load('albums_new', ['title'=>'Création d\'un album', 'error_message' => $e->getMessage()]);
  	}
  }
  
  public function albums_delete($album_name) {
    try {
    $album_name = filter_var($album_name);
    $this->gallery->delete_album($album_name);
  	} 
	catch (Exception $e) {
		header('Location: /index.php/gallery/albums');
	}
	header('Location: /index.php/gallery/albums');
  }

  public function albums_show($album_name) {
    $album_name = filter_var($album_name);
    $title='Affichage des photos d\'un album';
    $this->loader->load('albums_show',['title'=>$title,'photos'=>$this->gallery->photos($album_name)]);
  }
  
  public function photos_new($album_name) {
    // TODO
  }

  public function photos_add($album_name) {
    // TODO
  }
  
  public function photos_delete($album_name, $photo_name) {
    // TODO
  }
  
  public function photos_show($album_name, $photo_name) {
    // TODO
  }
}
