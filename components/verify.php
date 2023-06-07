<?php
// Import site config
require_once($_SERVER["DOCUMENT_ROOT"]."/hospital/site_config.php");
?>
<?php
class Verify{
    // Verification rules
    private $notEmpty;
    private $minLength;
    private $maxLength;
    private $isPassVerification = true;
    private $sanitizedInput;

    public function __construct($notEmpty, $minLength, $maxLength){
        $this->notEmpty = $notEmpty;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }
    
    public function verify($inputToVerify){
        // Sanitize user input
        // $this->sanitizedInput = $this->sanitize($inputToVerify);
        $this->sanitizedInput = $inputToVerify;

        // Run through all of the available filters
        $this->isNotEmpty()->isMinLength()->isMaxLength();

        // Return whether user input pass all verification parameters
        return $this->isPassVerification;
    }

    private function isNotEmpty(){
        // Check whether check for empty is active
        if($this->notEmpty != null){
            // Check whether user input is empty
            if(empty($inputToVerify)||$this->sanitizedInput == null){
                $this->isPassVerification = false;
            }
        }
        d($this->isPassVerification);

        return $this;
    }

    private function isMinLength(){
        // Check whether check for empty is active
        if($this->minLength != null){
            // Check whether user input is empty - Iz,caninacanteen@gmail.com: PS: THIS CHECK IS REDUNDANT, FIND A WAY TO ALLOW METHOD CHAINING WHILE STILL ALLOWING NON CONFORMING USER INPUT TO EXIT PROPERLY
            if(empty($this->sanitizedInput)||$this->sanitizedInput == null){
                // Check whether user input is over the minimum length
                if(strlen($this->sanitizedInput)<$this->minLength){
                    $this->isPassVerification = false;
                }
            }
        }
        d($this->isPassVerification);
        
        return $this;
    }

    private function isMaxLength(){
        // Check whether check for empty is active
        if($this->maxLength != null){
            // Check whether user input is empty - Iz,caninacanteen@gmail.com: PS: THIS CHECK IS REDUNDANT, FIND A WAY TO ALLOW METHOD CHAINING WHILE STILL ALLOWING NON CONFORMING USER INPUT TO EXIT PROPERLY
            if(empty($this->sanitizedInput)||$this->sanitizedInput == null){
                // Check whether user input is under the maximum length
                if(strlen($this->sanitizedInput)>$this->minLength){
                    $this->isPassVerification = false;
                }
            }
        }
        d($this->isPassVerification);
        
        return $this;
    }


    private function sanitize($inputToVerify){
        // String sanitization here

        $this->sanitizedInput = $inputToVerify;
    }
}

class VerificationRulesBuilder{
    private $notEmpty;
    private $minLength;
    private $maxLength;

    // Public constructor
    public function __construct($notEmpty, $minLength, $maxLength){
        $this->notEmpty = $notEmpty;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }
    
    // Private static constructor for cloning
    private static function createClone($notEmpty, $minLength, $maxLength){
        return new self($notEmpty, $minLength, $maxLength);
    }

    // Public constructor for public instansiation
    public static function createNew(){
        return new self(null, null, null);
    }

    public function setIsNotEmpty(){
        $this->notEmpty = true;
        return $this;
    }

    public function setMinLength($minLength){
        $this->minLength = $minLength;
        return $this;
    }

    public function setMaxLength($maxLength){
        $this->maxLength = $maxLength;
        return $this;
    }

    public function build(){
        return new Verify($this->notEmpty, $this->minLength, $this->maxLength);
    }

    public function clone(){
        return VerificationRulesBuilder::createClone($this->notEmpty, $this->minLength, $this->maxLength);
    }
}
?>