<?php
/**
 * CSV Form Pull plugin for Craft CMS 3.x
 *
 * Plugin to pull csv reports from form DB
 *
 * @link      https://github.com/mschlosser22
 * @copyright Copyright (c) 2019 Mike Schlosser
 */

namespace mschlosser22\csvformpull\services;

use mschlosser22\csvformpull\CsvFormPull;
use mschlosser22\csvformpull\records\CsvFormPullRecord;

use Yii;
use Craft;
use craft\base\Component;

/**
 * CsvFormPullService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Mike Schlosser
 * @package   CsvFormPull
 * @since     1.0.0
 */
class CsvFormPullService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     CsvFormPull::$plugin->csvFormPullService->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something service';

        return $result;
    }

    public function getForms($formId, $begin, $end)
    {
        $forms = CsvFormPullRecord::find()
            ->where(['between', 'dateCreated', $begin, $end ])
            ->andWhere(['formId' => $formId])
            ->all();

        return $forms;
    }

    public function resultsToCSV($entriesArray, $email, $filename)
    {
        $tmpfname = tempnam("/tmp", $filename);
        $fp = fopen($tmpfname, "w");

        $fieldsToList = array ('id', 'dateCreated', 'field_1', 'field_2', 'field_3', 'field_26');
        $list = array ();
        foreach ($entriesArray as $object) {
            $tempString = "";
            foreach ($object as $key => $value) {
                if (in_array($key, $fieldsToList)) {
                    $tempString = $tempString . $value . ",";
                }
            }
            array_push($list, $tempString);
        }

        foreach ($list as $line)
        {
            $line = rtrim($line,',');
            fputcsv($fp,explode(',',$line));
        }

        if (count($entriesArray)) {
            $this->sendCsvEmail($tmpfname, $email, $filename);
        } else {
            $filename = $filename . "-No_Entries";
            $this->sendCsvEmail($tmpfname, $email, $filename);
        }


        fclose($fp);
        unlink($tmpfname);

        return false;
    }

    public function sendCsvEmail($file, $email, $filename)
    {
        Yii::$app->mailer->compose()
            ->setFrom('no-reply@oakstreethealth.com')
            ->setTo($email)
            ->setSubject($filename)
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>')
            ->attach($file)
            ->send();
    }
}
