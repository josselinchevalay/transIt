<?php
 class TransIt{
     public static $_instance;

     public static $_tabLang;

     public static $_univers;

     public static $_lang;


     private function getStreamFile($path){
         $handle = @fopen($path, "r");
         $stream = "";
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $stream .= $buffer;
            }
            if (!feof($handle)) {
                echo "Erreur: fgets() a échoué\n";
            }
            fclose($handle);
        }
        return $stream;
     }

     private function __construct($lang, $univers=null){
         if(is_null($univers)){$univers = "Default";}
         $path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME'])."Univers/".$univers."/".$lang.".json";        
         if(file_exists($path)){
             TransIt::$_lang = $lang;
             TransIt::$_univers = $univers;
             $object = json_decode($this->getStreamFile($path));
             $temp = array();             
             foreach($object as $key => $value){                 
                 $id = $value->id;                 
                 TransIt::$_tabLang[$id] = $value->text;
             }
         }else{
             throw new Exception("Le fichier n'existe pas");
         }        
     }


     private function print_array($format, $arr){
         foreach($arr as $key => $value){
             $format = str_replace("|".$key, $value, $format);
         }
         return $format;
     }


     public static function getInstance($lang, $univers= null){
         if(is_null(TransIt::$_instance)){
             TransIt::$_instance = new TransIt($lang, $univers);
             $instance = TransIt::$_instance;
         }else{
             $instance = TransIt::$_instance;
         }
         return $instance;
     }


     public function getSentences($id){
         if(isset(TransIt::$_tabLang[$id]))
            return TransIt::$_tabLang[$id];
     }


     public function getSentencesMasculin($id, $masc){
         $sentence = $this->getSentences($id);
         if(is_array($sentence)){
             if($masc){
                 return $sentence[0];
             }else{
                 return $sentence[1];
             }
         }else{
             return $sentence;
         }
     }

     public function getSentencesParametrable($id, $params){
         $sentence = $this->getSentences($id);
         if(!is_array($params))
            throw new Exception("Arguments invalides");

         return $this->print_array($sentence, $params);
     }

     public function getSentencesPluriel($id, $params){
           $sentence = $this->getSentences($id);
         if(!is_array($params))
         {
             throw new Exception("Arguments invalides");
         }else{
             if(is_array($sentence)){
                  foreach($params as $key => $value){
                      if($value > 1){
                          return $this->getSentencesParametrable($sentence[1], $params);
                      }else{
                          return $this->getSentencesParametrable($sentence[0], $params);
                      }
                  }
             }else{
                 return $sentence;
             }
         }
            
     }
 }
?>