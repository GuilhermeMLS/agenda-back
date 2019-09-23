<?php

class mixController extends Controller
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
            case 'POST':
                $response = $this->mixByName();
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

    public function mixByName()
    {
        require(ROOT.'Services/mixService.php');
        $jsonBody = $this->getRequestBody();
        $service = new mixService();
        $service->mixByName($jsonBody);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
    }
}
