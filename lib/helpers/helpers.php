<?php
/**
 * Debug a variable and kill the application if necessary
 *
 * @param $var
 * @param $kill | optional
 */
function debug($var, $kill = false){
    if(is_array($var)){
        echo "<pre>";
        print_r($var);
        echo "</pre><br>";
        echo "<p>Quantidade: ". count($var) ."</p><br>";
    }else{
        var_dump($var);
    }

    if($kill){
        die("<br>Process closed in debug");
    }
}

/**
 * Replaces special characters in one or more strings
 *
 * @param $s Mixed
 * @param $includeKeys Boolean
 * @return String
 */
function replaceSpecialChars($s, $includeKeys = false){
	if(!is_array($s)){

		$s = str_replace(['á', 'â', 'ã', 'à'], 'a', $s);
        $s = str_replace(['Á', 'Â', 'Ã', 'À'], 'A', $s);

		$s = str_replace(['é', 'ê'], 'e', $s);
        $s = str_replace(['É', 'Ê'], 'E', $s);

		$s = str_replace(['í', 'î'], 'i', $s);
        $s = str_replace(['Í', 'Î'], 'I', $s);

		$s = str_replace(['ó', 'ô', 'õ'], 'o', $s);
        $s = str_replace(['Ó', 'Ô', 'Õ'], 'O', $s);

		$s = str_replace(['ú', 'û'], 'u', $s);
        $s = str_replace(['Ú', 'Û'], 'U', $s);

        $s = str_replace('ç', 'c', $s);
        $s = str_replace('Ç', 'C', $s);

	}else{
		if($includeKeys){
			$result = [];
			foreach($s as $key => $item){
                $result[replaceSpecialChars($key)] = replaceSpecialChars($item);
            }
			$s = $result;
		}else{
			foreach($s as $key => $item){
                $s[$key] = replaceSpecialChars($item);
            }
		}
	}
	return $s;
}
