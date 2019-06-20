<?php
/**
 * CSV Form Pull plugin for Craft CMS 3.x
 *
 * Plugin to pull csv reports from form DB
 *
 * @link      https://github.com/mschlosser22
 * @copyright Copyright (c) 2019 Mike Schlosser
 */

namespace mschlosser22\csvformpull\console\controllers;

use mschlosser22\csvformpull\CsvFormPull;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Default Command
 *
 * The first line of this class docblock is displayed as the description
 * of the Console Command in ./craft help
 *
 * Craft can be invoked via commandline console by using the `./craft` command
 * from the project root.
 *
 * Console Commands are just controllers that are invoked to handle console
 * actions. The segment routing is plugin-name/controller-name/action-name
 *
 * The actionIndex() method is what is executed if no sub-commands are supplied, e.g.:
 *
 * ./craft csv-form-pull/default
 *
 * Actions must be in 'kebab-case' so actionDoSomething() maps to 'do-something',
 * and would be invoked via:
 *
 * ./craft csv-form-pull/default/do-something
 *
 * @author    Mike Schlosser
 * @package   CsvFormPull
 * @since     1.0.0
 */
class DefaultController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Handle csv-form-pull/default console commands
     *
     * The first line of this method docblock is displayed as the description
     * of the Console Command in ./craft help
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $end = gmdate('Y-m-d h:i:s');
        $begin = gmdate('Y-m-d h:i:s', strtotime('- 1 hours'));

        $results = CsvFormPull::$plugin->csvFormPullService->getForms(1, $begin, $end);
        CsvFormPull::$plugin->csvFormPullService->resultsToCSV($results, 'ms122r@gmail.com', 'Become_A_Patient' . date('Y-m-d H:i:s'));

        $resultsRefer = CsvFormPull::$plugin->csvFormPullService->getForms(2, $begin, $end);
        CsvFormPull::$plugin->csvFormPullService->resultsToCSV($resultsRefer, 'ms122r@gmail.com', 'Refer_A_Client' . date('Y-m-d H:i:s'));

        $resultsGoogle = CsvFormPull::$plugin->csvFormPullService->getForms(16, $begin, $end);
        CsvFormPull::$plugin->csvFormPullService->resultsToCSV($resultsGoogle, 'ms122r@gmail.com', 'Google_Maps_Leads' . date('Y-m-d H:i:s'));

        return $results;
    }

}
