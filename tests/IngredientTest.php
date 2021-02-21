<?php

/**
 * IngredientTest.php
 *
 * PHP version 8.0+
 * PHPUnit 8.0+
 *
 * @author    Vivek
*/

require_once('model/Ingredient.php');

/**
 * IngredientTest 
 * 
 * @uses      PHPUnit_Framework_TestCase
 * @author    Vivek 
 */
class IngredientTest extends PHPUnit_Framework_TestCase {
   /**
    * Checks ingredient validation 
    * 
    * @access public
    * @return void
    */
   public function testValidation1() {
        $this->setExpectedException('IngredientValidationException');

        $ingredient = new Ingredient(); 
   }

   /**
    * Checks ingredient validation 
    * 
    * @access public
    * @return void
    */
   public function testValidation2() {
        $this->setExpectedException('IngredientValidationException');

        $ingredient = new Ingredient('Foo',
                                     'a10',
                                     'of',
                                     '03/09/13'); 
   }

   /**
    * Checks ingredient validation 
    * 
    * @access public
    * @return void
    */
   public function testValidation3() {
        $this->setExpectedException('IngredientValidationException');

        $ingredient = new Ingredient('Foo',
                                     10,
                                     'bar',
                                     '03/09/13'); 
   }


   /**
    * Checks ingredient validation 
    * 
    * @access public
    * @return void
    */
   public function testValidation4() {
        $this->setExpectedException('IngredientValidationException');

        $ingredient = new Ingredient('Foo',
                                     10,
                                     'slices',
                                     'bar'); 
   }

   /**
    * Tests valid input 
    * 
    * @access public
    * @return void
    */
   public function testInput() {
        $expectedOutput = array(
            'item'   => 'Test',
            'amount' => 5,
            'unit'   => 'slices',
            'useBy'  => 1381363200
        );

        date_default_timezone_set('Asia/Kolkata');
        $ingredient = new Ingredient('Test',
                                     5,
                                     'slices',
                                     '10/10/20');

        $this->assertEquals($expectedOutput, array(
            'item'   => $ingredient->getItem(),
            'amount' => $ingredient->getAmount(),
            'unit'   => $ingredient->getUnit(),
            'useBy'  => $ingredient->getUseBy()
        ));
   }
    

}
