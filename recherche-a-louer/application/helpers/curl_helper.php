<?php 
    
    function my_curl_parse_headers($pHeaders) 
    { 
        $r = array(); 
        if ($pHeaders) 
        { 
            $lines = explode("\r\n", $pHeaders); 
            $header_idx = 0; 
            foreach ($lines as $line) 
            { 
                if (preg_match('`^(?:(HTTP/[^\s]+)|([^:\s]+):) (.*)$`i', $line, $matches)) 
                $r[$header_idx][] = array( 
                 'k' => $matches[1] ? $matches[1] : $matches[2], 
                 'v' => $matches[3] 
                ); 
               else 
               $header_idx++; 
            } 
        } 
        return $r; 
    } 
?>