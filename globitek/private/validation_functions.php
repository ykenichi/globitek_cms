<?php

  // is_blank('abcd')
  function is_blank($value='') {
    // TODO
    if(empty($value)){
      return true;
    }
    else {
      return false;
    }
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    // TODO
    $min = $options[0];
    $max = $options[1];
    $length = strlen($value);
    
    if($length < $min || $length > $max){
      return false;
    }
    else {
      return true;
    }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // TODO
    if(strpos($value, '@') !== false){
      return true;
    }
    else {
      return false;
    }
  }
  
  function has_valid_characters($value, $option) {
    if(preg_match($option, $value)){
      return true;
    }
    else{
      return false;
    }
  }

?>
