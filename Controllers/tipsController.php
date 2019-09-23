<?php

class tipsController extends Controller
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
                $response = $this->getTips();
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

    /**
     * @return mixed
     */
    private function getTips()
    {
        require(ROOT.'Services/tipsService.php');
        $service = new tipsService();
        $mesclar = $service->getTips();

        $response['body'] = json_encode($mesclar ? $mesclar : null);

        return $response;
    }
}
