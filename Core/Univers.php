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
 * classe Univers et représente un fichier json et surtout l'architecture logique de 
 * ces fichiers
 * @access public
 * @packages TransIt/Core
 * @author Josselin Chevalay <149351@supinfo.com>
 */
 class Univers{

     /**
     * Propriétès des Traduction 
     * @access private
     */
     private $_tabSentences;


     /**
     * Constructeur de l'objet univers
     * @access public
     */
     public function __construct(){
         $this->_tabSentences = array();
     }

     /**
     * fonction qui retourne le tableau des trad
     * c'est un getter
     * @access public
     * @return $tabSentences
     */
     public function getSentences(){
         return $this->_tabSentences;
     }

     /**
     * fonction qui permet de overrider le tableau de trad
     * Attention le tableau sera écrasé
     * @access public
     * @param $tab : array => les trad
     * @example $univers->setSentences($tabTrad);
     */
     public function setSentences($tab){
         $this->_tabSentences = $tab;
     }

     /**
     * fonction utilitaire qui permet de convertir un std-class
     * en objet univers. 
     * @access public
     * @param $objet : std-class
     * @return objet univers
     * @example Univers::convertToUnivers($jsonParser->serialize($monJson));
     */
     public static function convertToUnivers($objet){         
         $temp = array();
         $univers = new Univers();
         foreach($objet as $key => $value){             
             foreach($value as $row => $sentence){
                 $idSentence = $sentence->id;
                 unset($sentence->id);
                 $temp[$idSentence] = $sentence;                 
             }
         }
         return $temp;
     }
 }
?>

