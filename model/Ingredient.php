<?php
/**
 * Ingredient.php
 *
 * Represents a single ingredient
 *
 * PHP version 8.0+
 *
 * @author    Vivek
*/

/**
 * IngredientValidationException 
 * 
 * @author    Vivek 
 */
class IngredientValidationException extends \Exception {}

/**
 * Ingredient 
 * 
 * @author    Vivek 
 */
class Ingredient {
    /**
     * item 
     * 
     * @var string
     * @access private
     */
    private $item = '';

    /**
     * amount 
     * 
     * @var float
     * @access private
     */
    private $amount = 0;

    /**
     * unit 
     * 
     * @var string
     * @access private
     */
    private $unit = '';

    /**
     * useBy 
     * 
     * @var int
     * @access private
     */
    private $useBy = 0;

    /**
     * isExpired 
     * 
     * @var bool
     * @access private
     */
    private $isExpired = false;

    /**
     * validationRules 
     * 
     * @var array
     * @access private
     */
    private $validationRules = array(
        'item'   => '/^(.*)$/', 
        'amount' => '/^(\d+)$/',
        'unit'   => '/^(of|grams|ml|slices)$/i',
        'useBy'  => '/^(\d{1,2})\/(\d{1,2})\/(\d{1,2})/'
    );

    /**
     * Constructor
     *
     * @param string $item
     * @param int $amount
     * @param string $unit
     * @param string $useBy
     * @access public
     * @return void
     */
    public function __construct($item   = '',
                                $amount = 0,
                                $unit   = '',
                                $useBy  = null) {
        $this->validateInput('item', $item);
        $this->validateInput('amount', $amount);
        $this->validateInput('unit', $unit);

        // use by is optional
        if ($useBy !== null) {
            $this->validateInput('useBy', $useBy);
            
            // convert the useBy to a timetamp and check if the item is expired
            $this->useBy = strtotime(str_replace('/', '-', $this->useBy));
            if ($this->useBy < time())
                $this->isExpired = true;
        }
    }

    /**
     * getItem 
     * 
     * @access public
     * @return string
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * getAmount 
     * 
     * @access public
     * @return float
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * getUnit 
     * 
     * @access public
     * @return string
     */
    public function getUnit() {
        return $this->unit;
    }

    /**
     * getUseBy 
     * 
     * @access public
     * @return int
     */
    public function getUseBy() {
        return $this->useBy;
    }

    /**
     * getIsExpired 
     * 
     * @access public
     * @return boolean
    */
    public function getIsExpired() {
        return $this->isExpired;
    }

    /**
     * Validates ingredient for input 
     * 
     * @param string $field 
     * @param mixed $input 
     * @access private
     * @return void
     */
    private function validateInput($field = '', $input) {
        if (!preg_match($this->validationRules[$field],
                        $input))
            throw new IngredientValidationException("Invalid input on $field");
        $this->$field = $input;
    }
}
