<?php

namespace craftcom\queue\controllers\v1;

use Craft;
use craftcom\queue\controllers\BaseApiController;
use craftcom\queue\jobs\TestJob;
use yii\web\Response;

/**
 * Class QController
 *
 * @package craftcom\queue\controllers\v1
 */
class QController extends BaseApiController
{
    /**
     * Handles /v1/create requests.
     *
     * @return Response
     */
    public function actionCreate(): Response
    {
        //$body = $this->getRequestBody('updates-request');
        $numJobs = Craft::$app->getRequest()->getParam('numJobs');

        for ($counter = 0; $counter < $numJobs; $counter++)
        {
            $job = new TestJob();
            Craft::$app->queue->push($job);
        }

        return $this->asRaw('Added '.$numJobs.' jobs.');
    }

    public function actionProcess(): Response
    {
        $this->requirePostRequest();

        $test = Craft::$app->getRequest()->getBodyParams();
        ob_start();
        var_dump($test);
        $contents = ob_get_contents();
        ob_end_clean();
        Craft::info($contents);
    }
}