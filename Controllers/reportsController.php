<?php

class reportsController extends Controller
{
    private $requestMethod;

    /**
     * tasksController constructor.
     * @param $requestMethod
     */
    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getReport();
                break;
            default:
                $response = $this->notFound();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getReport()
    {
        require(ROOT.'Services/reportService.php');
        $service = new reportService();
        $report = $service->getReport();
        $response['body'] = json_encode($report);

        return $response;
    }
}
