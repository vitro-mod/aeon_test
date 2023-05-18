<?php

function salt() {

   $salt = substr(md5(uniqid()), -8);
   return $salt;
}

function sha256($string) {
   
   return hash('sha256', $string);
}
