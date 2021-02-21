<?php
/**
 * recipe-finder.php
 *
 * Given a list of elements in a fridge and recipes, determine
 * the best recipe for the fridge elements.
 *
 * PHP version 8.0+
 *
*/

require_once('model/Ingredient.php');
require_once('model/Recipe.php');

/**
 * RecipeFinderException 
 * 
 * @author    Vivek 
 */
class RecipeFinderException extends \Exception {}

/**
 * RecipeFinderInputException 
 * 
 * @author    Vivek 
 */
class RecipeFinderInputException extends \Exception {}

/**
 * RecipeFinder 
 * 
 * @author    Vivek 
 */
class RecipeFinder {
    /**
     * Response to privde when nothing is found
     */
    const EMPTY_RESPONSE = 'Order Takeout';

    /**
     * fridgeIngredients 
     * 
     * @var array
     * @access private
     */
    private $fridgeIngredients = array();

    /**
     * recipes 
     * 
     * @var array
     * @access private
     */
    private $recipes = array();

    /**
     * Finds suitable recipes from the fridge
     * 
     * @access public
     * @return string
     */
    public function find() {
        $recipeMatches = array();
        
        foreach ($this->recipes as $recipe) {

            $matchedIngredient = $recipe->checkIngredients($this->fridgeIngredients);
            
            if ($matchedIngredient !== false) { 
                $recipeName = $recipe->getName();
                $recipeMatches[$recipeName] = $matchedIngredient;
            }
            
        }

        // no matches?
        if (count($recipeMatches) == 0)
            return self::EMPTY_RESPONSE;

        // sort by timestamp increasing and return first result
        asort($recipeMatches);
    
        return key($recipeMatches);
    }

    /**
     * Inputs a list of items in a fridge in a csv format 
     * 
     * @param string $file 
     * @access public
     * @return void
     */
    public function forFridge($file = 'fridge.csv') {
        if (!is_readable($file))
            throw new RecipeFinderInputException("Unreadable fridge csv file");

        $fp = file($file);

        /* open and read through lines */
        foreach ($fp as $lineNumber => $line) {

            $fields = str_getcsv($line);

            /* catch any line errors so the script can continue */
            try {

                /* add to fridge ingredients */
                $ingredient = new Ingredient($fields[0],
                                             $fields[1],
                                             $fields[2],
                                             $fields[3]);
                
                $this->fridgeIngredients[] = $ingredient;

            } catch (IngredientValidationException $e) {
                echo "Error! Fridge csv line number " . ++$lineNumber . "\n";
            }

            unset($fields, $ingredient);
        }

        return $this;
    }

    public function forRecipes($file = 'recipes.json') {
        if (!is_readable($file)) 
            throw new RecipeFinderInputException("Unreadable recipes json file");

        $fp   = file_get_contents($file);
        $data = json_decode($fp, true);

        if ($data === null) 
            throw new RecipeFinderInputException("Could not parse recipes json file");

        foreach ($data as $dataRecipe) {
            try {
                $recipe = new Recipe($dataRecipe['name']);

                foreach ($dataRecipe['ingredients'] as $dataIngredient) {
                    
                    try {
                        $ingredient = new Ingredient($dataIngredient['item'],
                                                     $dataIngredient['amount'],
                                                     $dataIngredient['unit']);
                        
                        $recipe->addIngredient($ingredient);
                    } catch (IngredientValidationException $e) {
                        echo "Error! Invalid ingredient on receipe\n";
                    }
                }

                $this->recipes[] = $recipe;
            } catch (RecipeValidationException $e) {
                echo "Error! Invalid recipe name\n";
            }
            unset($recipe, $dataIngredient, $ingredient);
        }

        return $this;
    }
}

/* main */
try {
    // set timezone
    date_default_timezone_set('Asia/Kolkata');

    if (!isset($argv[1]) || !isset($argv[2])) 
        throw new RecipeFinderInputException("Insufficient arguments");

    $recipeFinder = new RecipeFinder();
    echo $recipeFinder->forFridge($argv[1])
                      ->forRecipes($argv[2])
                      ->find();
    echo "\n\n";

} catch (RecipeFinderException $e) {

    echo $e->getMessage() . "\n";

} catch (RecipeFinderInputException $e) {

    /* Input error, display message */
    echo "Valid input required.\n\n";
    echo "Usage:\n";
    echo "php " . __FILE__ . " <fridge csv> <recipes json>\n\n";
    echo "Fridge.csv must be in the following format:\n";
    echo "item, amount, unit, use-by\n\n";

}
