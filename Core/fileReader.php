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



    /**
    * Classe qui va recuperer le buffer d'un fichier
    * @package TransIt/Core
    * @access public
    * @version 0.0.1
    * @author Josselin Chevalay <149351@supinfo.com>
    */
    class fileReader{

        /**
        * Propriété qui va nous permettre de retourne le fichier en bit
        * @access private 
        */
        private $_stream;


        /**
        * fonction constructeur de fileReader
        * @access public
        */
        public function __construct(){
            $this->_stream ="";
        }

        /**
        * fonction qui retourne le stream du fichier
        * @access public
        * @param $path : string chemin du fichier
        * @return stream du fichier
        * @example $fr->getStreamFile("../Univers/Default.json");
        */
        public function getStreamFile($path){
            $handle = @fopen($path, "r");
            if ($handle) {
                while (($buffer = fgets($handle, 4096)) !== false) {
                   $this->_stream .= $buffer;
                }
                if (!feof($handle)) {
                    echo "Erreur: fgets() a échoué\n";
                }
                fclose($handle);
            }
            return $this->_stream;
        }


    }
?>