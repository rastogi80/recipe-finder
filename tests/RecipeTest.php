<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * RecipeTest.php
 *
 * Recipe Tests
 *
 * PHP version 8.0+
 * PHPUnit 8.0+
 *
 * @author    Vivek
*/

require_once('model/Recipe.php');

/**
 * RecipeTest 
 * 
 * @uses      PHPUnit_Framework_TestCase
 * @author    Vivek 
 */
class RecipeTest extends PHPUnit_Framework_TestCase {
   /**
    * testValidation 
    * 
    * @access public
    * @return void
    */
   public function testValidation() {
        $this->setExpectedException('RecipeValidationException');

        $recipe = new Recipe();
        var_dump($recipe);
   }
}
