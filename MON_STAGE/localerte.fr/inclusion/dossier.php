<?php
	if(!function_exists('scandir'))
	{
		function scandir($dir,$sortorder=0)
		{
			if(is_dir($dir))
			{
				$dirlist=opendir($dir);
				$files=array();
				while(($file=readdir($dirlist))!==false)
					$files[]=$file;
				($sortorder==0)?asort($files):rsort($files);
				return $files;
			}
			else
			{
				trigger_error('Le r&eacute;pertoire '.$dir.' n\'existe pas.', E_USER_WARNING);
				return false;
			}
		}
	}
		
	function scandir_recursive($directory)
	{
		if(is_dir($directory))
		{
			$folderContents=array();
			$directory=realpath($directory);
			
			if($directory===false)
			{
				trigger_error('Oups!!!.', E_USER_WARNING);
				return false;
			}
			
			$directory.=DIRECTORY_SEPARATOR;
			
			foreach(scandir($directory) as $folderItem)
			{
				if($folderItem!='.' && $folderItem!='..')
				{
					if(is_dir($directory.$folderItem.DIRECTORY_SEPARATOR))
						$folderContents[$folderItem]=scandir_recursive($directory.$folderItem.DIRECTORY_SEPARATOR);
					else
						$folderContents[]=$folderItem;
				}
			}
			
			return $folderContents;
		}
		else
		{
			trigger_error('Le r&eacute;pertoire '.$directory.' n\'existe pas.', E_USER_WARNING);
			return false;
		}
	}
	
	function rmdir_recursive($directory)
	{
		if(is_dir($directory))
		{
			$directory=realpath($directory);
			
			if($directory===false)
			{
				trigger_error('Oups!!!.', E_USER_WARNING);
				return false;
			}
			
			$directory.=DIRECTORY_SEPARATOR;
			
			foreach(scandir($directory) as $folderItem)
			{
				if($folderItem!='.' && $folderItem!='..')
				{
					if(is_dir($directory.$folderItem.DIRECTORY_SEPARATOR))
						rmdir_recursive($directory.$folderItem.DIRECTORY_SEPARATOR);
					else
						unlink($directory.$folderItem);
				}
			}
			
			rmdir($directory);
		}
		else
		{
			trigger_error('Le r&eacute;pertoire '.$directory.' n\'existe pas.', E_USER_WARNING);
			return false;
		}
	}
?>