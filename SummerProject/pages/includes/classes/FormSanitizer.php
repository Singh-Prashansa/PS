<!-- htmlspecialchars -->
<?php
    class FormSanitizer{
        
        public static function sanitizeFormName($inputText){  
            $sanitizedInput = strip_tags(trim($inputText)); 
            $sanitizedInput=strtolower($sanitizedInput);
            $sanitizedInput=ucfirst($sanitizedInput);
            return  $sanitizedInput; 
        }

        public static function sanitizeFormPassword($inputText){  
            $sanitizedInput = strip_tags($inputText); 
            return  $sanitizedInput; 
        }

        public static function sanitizeFormEmail($inputText){  
            $sanitizedInput = strip_tags($inputText); 
            $sanitizedInput = str_replace(" ","",$inputText); 
            return  $sanitizedInput; 
        }

        public static function sanitizeFormDescription($inputText){  
            $sanitizedInput = strip_tags(trim($inputText)); 
            $sanitizedInput=strtolower($sanitizedInput);
            $sanitizedInput=ucwords($sanitizedInput);
            return  $sanitizedInput; 
        }
       
        public static function sanitizeFormForTags($inputText){  
            $sanitizedInput = strip_tags($inputText); 
            // Additional sanitization steps if needed
            return $sanitizedInput; 
        }
    }
?>