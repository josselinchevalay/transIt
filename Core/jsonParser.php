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
 * classe qui permet de serializer & deserializer 
 * les objet php en Json
 * @package TransIt/Core
 * @author josselin chevalay <149351@supinfo.com>
 * @access public
 */
 class JsonParser{

     /**
     * fonction qui va retourner un objet std class a partir d'un string json
     * @access public 
     * @param $string : string le json 
     * @return std-class
     * @example $parser->deserialize("{'text':'titi'}");
     */
     public function deserialize($string){
         if(is_string($string)){
             return json_decode($string);
         }else{
             throw new Exception("serialize attend un string");
         }
     }

     /**
     * fonction qui va retourner une string  a partir d'un objet php
     * @access public 
     * @param $objet : objet php
     * @return string => json
     * @example $parser->serialize($monObjet);
     */
     public function serialize($object){
         if(is_object($object)){
             return json_encode($object);
         }else{
             throw new Exception("deserialize attend un objet");
         }
     }
 }
?>

