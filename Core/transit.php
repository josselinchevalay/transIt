<?php
       /*
        *   Copyright (c) <2013> <Josselin Chevalay josselin54.chevalay@gmail.com>
        *
        * Permission is hereby granted, free of charge, to any person obtaining a copy
        * of this software and associated documentation files (the "Software"), to deal
        * in the Software without restriction, including without limitation the rights
        * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
        * copies of the Software, and to permit persons to whom the Software is
        * furnished to do so, subject to the following conditions:
        *
        * The above copyright notice and this permission notice shall be included in
        * all copies or substantial portions of the Software.
        *
        * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
        * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
        * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
        * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
        * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
        * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
        * THE SOFTWARE.
        */


    require 'fileReader.php';
    require 'jsonParser.php';
    require 'Univers.php';

    /**
    * Classe principale du package c'est celle que vous devez utiliser
    * @package TransIt/Core
    * @access public
    * @author josselin chevalay <149351@supinfo.com>
    * @version 0.0.1
    */
    class TransIt{

        private static $univers;
        
        private static $lang;


        private static $tabLang;


        /**
        * tableaux des univers 
        * @access private
        */
        private static  $_tabUnivers;

        /**
        * nom du repertoires ou ce trouve les données organiser en 
        * fichiers json.
        * @access private 
        */
        private $_dirName;


        /**
        * mis en place d'un singleton
        */ 
        private static $_instance;


        /**
        * function qui premet de réecrire des données dans une chaine
        * Attention vos tableaux doivent être des tableaux associatif
        * @access private
        * @param $format : string => chaine à afficher plus les données avec des |var1
        * @param $arr : array Associatif comme cela array("nom"=>"toto")
        * @return string la chaînes plus les données
        * @example return print_array("bonjour |nom", array("nom"=>"toto");
        */
        private function print_array($format, $arr){
            foreach($arr as $key => $value){
               $format = str_replace("|".$key, $value, $format);
            }
            return $format;
        }


        /**
        * fonction qui va récuperer l'ensemble des fichiers du repertoire "dépot" de
        * vos univers
        * @access private
        * @return array de nom de fichiers
        * @example return getFiles();
        */
        private function getFiles(){
            $tabFiles = array();
            $dir = opendir($this->_dirName); 

            while($file = readdir($dir)) {
	            if($file != '.' && $file != '..' && !is_dir($this->_dirName.$file))
	            {
		           $tabFiles[] = $file;
	            }
            }

            closedir($dir);
            return $tabFiles;
        }

        /**
        * fonction qui va loader tout ce qui doit être loader sur transIt comme les 
        * univers.
        * @access private 
        * 
        */
        private function load(){
            $tabFiles = $this->getFiles();
            $jsonParser = new JsonParser();
            foreach($tabFiles as $key => $value){
                $fr = new FileReader();
                $nameOfUnivers = substr($value, 0, -5);
                $stream = $fr->getStreamFile($this->_dirName.$value);
                TransIt::$_tabUnivers[$nameOfUnivers] = Univers::convertToUnivers($jsonParser->deserialize($stream));                
            }            
        }

        /**
        * fonction constructeur dans le cadre d'un design pattern 
        * singleton le constructeur est mis en private
        * @access private
        */
        private function __construct(){
            $this->_dirName = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME'])."Univers/"; // changer la fin 
            $this->load();
        }


        /**
        * fonction qui va retourner un instance de transIt
        * @access public
        * @return TransIt
        */
        public static function getInstance(){
            if(is_null(TransIt::$_instance)){
                $instance = new TransIt();
            }else{
                $instance = TransIt::$_instance;
            }
            return $instance;
        }


        /**
        * fonction qui retourne une traduction
        * @access public
        * @param $id : string clès qui permet de savoir quelle mot expression que l'on veux
        * @param $lang : string Code pays FR, EN, ES, PL
        * @param $univers : string nom de l'univers que l'on veux 
        * @return sentence string mais peut être un array
        * @example $translate->getSentences("bonjour", "FR", "Default");
        */
        public function getSentences($id, $lang, $univers=null){
            if(is_null($univers)){$univers = "Default";}
            $tabLang = array();

            if(TransIt::$lang == $lang && TransIt::$univers == $univers){
                $tabLang = TransIt::$tabLang;
            }


            if(empty($tabLang)){
               if(isset(TransIt::$_tabUnivers[$univers])){
                   if(isset(TransIt::$_tabUnivers[$univers][$lang])){                 
                        $tabLang = TransIt::$_tabUnivers[$univers][$lang];
                       foreach($tabLang as $key => $value){
                           if($value->id == $id)
                                return $value->text;
                       }
                   }else{
                       throw new Exception("La langue n'existe pas");
                   }
                }else{
                    throw new Exception ("L'univers n'existe pas");
                }
                throw new Exception("L'id n'existe pas");
            }else{
                $tabLang = TransIt::$tabLang;
                foreach($tabLang as $key => $value){
                    if($value->id == $id)
                        return $value->text;
                }
                throw new Exception("L'id n'existe pas");
            }
            
        }


        /**
        * fonction qui permet de retourner la traduction masculin ou féminin de votre expression
        * @access public
        * @param $id : string clès qui permet de savoir quelle mot expression que l'on veux
        * @param $lang : string Code pays FR, EN, ES, PL
        * @param $univers : string nom de l'univers que l'on veux 
        * @masculin : boolean true masc false fem
        * @return retourne un string
        * @example $translate->getSenctencesMasculin("ami", "FR", true, "Default");
        */
        public function getSenctencesMasculin($id, $lang,$maculin ,$univers=null){
            $sentences = $this->getSentences($id, $lang, $univers);
            if(is_array($sentences)){
                if($maculin){
                    return $sentences[0];
                }else{
                    return $sentences[1];
                }
            }else{
                return $sentences;
            }
        }


        /**
        * fonction qui retourne une traduction dans laquelles on veux des données
        * @access public
        * @param $id : string clès qui permet de savoir quelle mot expression que l'on veux
        * @param $lang : string Code pays FR, EN, ES, PL
        * @param $univers : string nom de l'univers que l'on veux 
        * @params : array Attention il dois être associatif
        * @return retourne un string
        * @example $translate->getSentencesParametrable("salutation", "FR", array("nom"=>"toto", "prenom"=>"laBlague"), "Default");
        */
        public function getSentencesParametrable($id, $lang, $params ,$univers=null){
             $sentences = $this->getSentences($id, $lang, $univers);            
             return $this->print_array($sentences, $params);
        }



        /**
        * fonction qui va retourne la traduction d'un pluriel
        * @access public
        * @param $id : string clès qui permet de savoir quelle mot expression que l'on veux
        * @param $lang : string Code pays FR, EN, ES, PL
        * @param $univers : string nom de l'univers que l'on veux 
        * @params : array Attention il dois être associatif
        * @return retourne un string
        * @example $translate->getSentencesPluriel("commentaire", "FR", array("count"=> 200), "Default");
        */
        public function getSentencesPluriel($id, $lang, $params ,$univers=null){
            $sentences = $this->getSentences($id, $lang, $univers);
            
            if(is_array($sentences)){
                foreach($params as $key => $value){
                    if($value > 1){                        
                        return $this->print_array($sentences[1], $params);
                    }else{
                        return $this->print_array($sentences[0], $params);
                    }
                }
            }else{
                return $sentences;
            }
        }

    }
?>

