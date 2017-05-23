<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
	private $CI;
	private $var = array();
        private $theme = 'front';
	
        public function __construct()
        {
            $this->CI =& get_instance();

            $this->var['output'] = '';

            //	Nous initialisons la variable $charset avec la même valeur que
            //	la clé de configuration initialisée dans le fichier config.php
            $this->var['charset'] = $this->CI->config->item('charset');
        }
	
/*
|===============================================================================
| Méthodes pour charger les vues
|	. view
|	. views
|===============================================================================
*/
	/**
         * Affiche a l'ecran la vue passe en parametre en fonction des donnees recquises 
         * @param type $name (path vers la vue)
         * @param type $data (tableau de donnees)
         */
	public function view($name, $data = array())
	{
            $this->var['output'] .= $this->CI->load->view($name, $data, true);
            $this->CI->load->view('../themes/'.$this->theme, $this->var);
	}
	
	public function views($name, $data = array())
	{
            $this->var['output'] .= $this->CI->load->view($name, $data, true);
            return $this;
	}
        
        public function set_theme($theme)
        {
            if(is_string($theme) AND !empty($theme) AND file_exists('./application/themes/' . $theme . '.php'))
            {
                $this->theme = $theme;
                return true;
            }
            return false;
        }
        
        public function setTitre($titre){
            if(is_string($titre) AND !empty($titre)){
                $this->var['titre'] = $titre;
            }          
        }
        
        public function setMeta($meta){
            if(is_string($meta) AND !empty($meta)){
                $this->var['meta'] = $meta;
            } 
        }
}