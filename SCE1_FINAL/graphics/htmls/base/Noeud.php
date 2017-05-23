<?php

abstract class Noeud{

	function __construct()
	{
		//
	}
	public abstract function toHTML();
        
        function tostring()
        {
            return get_class($this);
        }
	
}