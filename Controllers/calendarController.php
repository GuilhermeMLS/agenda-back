<?php

class calendarController extends Controller
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
                $response = $this->getBirthdays();
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
    private function getBirthdays()
    {
        require(ROOT.'Services/calendarService.php');
        $jsonBody = $this->getRequestBody();
        $service = new CalendarService();
        $result = $service->getBirthdays(
            $jsonBody->day,
            $jsonBody->month
        );
        $response['body'] = json_encode($result);

        return $response;
    }

}
