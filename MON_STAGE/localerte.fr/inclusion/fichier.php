<?php
	if(!function_exists('file_put_contents'))
	{
		function file_put_contents($chemin,$contenu)
		{
			$fichier=fopen($chemin,'w');
			fwrite($fichier,$contenu,strlen($contenu));
			fclose($fichier);
			return true;
		}
	}
	
	if (!function_exists('fputcsv'))
	{
		function fputcsv(&$handle, $fields = array(), $delimiter = ',', $enclosure = '"')
		{
			$str = '';
			$escape_char = '\\';
			foreach ($fields as $value)
			{
				if (strpos($value, $delimiter) !== false || strpos($value, $enclosure) !== false || strpos($value, "\n") !== false || strpos($value, "\r") !== false || strpos($value, "\t") !== false || strpos($value, ' ') !== false)
				{
					$str2 = $enclosure;
					$escaped = 0;
					$len = strlen($value);
					for ($i=0;$i<$len;$i++)
					{
						if ($value[$i] == $escape_char)
						{
							$escaped = 1;
						}
						else if	(!$escaped && $value[$i] == $enclosure)
						{
							$str2 .= $enclosure;
						}
						else
						{
							$escaped = 0;
						}
						$str2 .= $value[$i];
					}
					$str2 .= $enclosure;
					$str .= $str2.$delimiter;
					}
					else
					{
						$str .= $value.$delimiter;
					}
				}
				$str = substr($str,0,-1);
				$str .= "\n";
			return fwrite($handle, $str);
		}
	}
?>
