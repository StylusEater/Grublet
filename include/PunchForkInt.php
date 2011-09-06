<?php

/**
 *  This file is part of Grublet.
 *
 *  Grublet is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Foobar is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * This particular file contains the PunchFork interface.
 * 
 * @author Adam M. Dutko <adam@runbymany.com>
 * @link http://www.runbymany.com
 * @copyright Copyright &copy; 2011 RunByMany, LLC
 * @license GPLv3 or Later
 */

interface PunchForkInt 
{

    /**
     * This is a Free API feature but some options are for the paid API. 
     * All results return an image. Recipes without images are not 
     * included in the results.
     * All results are 1 month old unless you pay for access to the API.
     * Ingredient information is not available unless you pay for access. 
     * Ingredient data extends the JSON array and looks different than 
     * the example given below.
     *  
     * Return a list of recipes matching options specified in the query. 
     *
     * The returned list is in JSON format:
     *     {
     *         "count": 2,
     *         "recipes": [
     *             {
     *                 "rating": 99.562,
     *                 "source_name": "Skinny Taste",
     *                 "thumb": "http://www.skinnytaste.com/somephoto.jpg",
     *                 "title": "Healthy Baked Chicken Nuggets",
     *                 "source_url": "http://www.skinnytaste.com/hbcn",
     *                 "pf_url": "http://www.punchfork.com/recipe/hbcn",
     *                 "published": "2011-04-12T13:00:00",
     *                 "source_img": "http://someimagesomehwere",
     *                 "shortcode": "upk7zQ"
     *             },
     *             {
     *                 ...
     *             },
     *             ...
     *         ],
     *         "next_cursor": "80.8557733148"
     *     }
     *
     * @param string $query FREE OPTIONAL
     * @param bool $ingred PAID OPTIONAL
     * @param string $publisher FREE OPTIONAL
     * @param int $count FREE OPTIONAL 
     * @param int $cursor FREE OPTIONAL 
     * @param string $sort FREE OPTIONAL
     * @param date $startdate FREE OPTIONAL
     * @param date $enddate FREE OPTIONAL
     * @return json
     * @version Free/Paid
     */ 
    public function getRecipeByQuery(
                                     $query="",$ingred=0,$publisher="",
                                     $count=1,$cursor="",$sort="r",
                                     $startdate="",$enddate=""
                                    );

    /**
     * This is a Free API feature. 
     *
     * Return a random recipe using a similar format to that returned by 
     * getRecipeByQuery().
     *
     * The returned list is in JSON format:
     *     {
     *         "recipe":
     *             {
     *                 "rating": 99.562,
     *                 "source_name": "Skinny Taste",
     *                 "thumb": "http://www.skinnytaste.com/somephoto.jpg",
     *                 "title": "Healthy Baked Chicken Nuggets",
     *                 "source_url": "http://www.skinnytaste.com/hbcn",
     *                 "pf_url": "http://www.punchfork.com/recipe/hbcn",
     *                 "published": "2011-04-12T13:00:00",
     *                 "source_img": "http://someimagesomehwere",
     *                 "shortcode": "upk7zQ"
     *             }
     *     }
     *
     * @return json
     * @version Free
     */ 
    public function getRandomRecipe(); 

    /**
     * This is a Free API feature. 
     *
     * Return a random recipe using a similar format to that returned by 
     * getRecipeByQuery().
     *
     * The returned list is in JSON format:
     *     {
     *         "publishers": [
     *             {
     *                 "name": "Allrecipes",
     *                 "twitter": "Allrecipes",
     *                 "site": "http://allrecipes.com",
     *                 "num_recipes": 6763,
     *                 "avatar": "http://somepicturesomewhere",
     *                 "avg_rating": "28.4673",
     *             },
     *             ...
     *         ]
     *     }
     *
     * @return json
     * @version Free
     */ 
    public function getPublisherList();

    /**
     * This is an Ultra API feature. 
     *
     * Returns a list of search terms given a recipe title and newline-separated
     * list of ingredients.  
     *
     * The returned list is in JSON format:
     *     {
     *         "terms": [
     *             "bird",
     *             "bread crumb",
     *             "egg",
     *             "meat"
     *         ]
     *     }
     *
     * @return json
     * @version Ultra 
     */ 
    public function getSearchIndex($title,$ingred);

    /**
     * This is a Free API feature. 
     *
     * Return the number of API calls the key has left for the day. The day 
     * resets at 12AM (midnight) PST.
     *
     * The returned list is in JSON format:
     *     {
     *         "remaining_calls": 423 
     *     }
     *
     * @return json
     * @version Free
     */ 
    public function getRateLimitStatus();

}

?>
