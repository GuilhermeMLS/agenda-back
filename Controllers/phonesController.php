<?php

class phonesController extends Controller
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

    /**
     * @param null $id
     */
    public function processRequest($id = NULL)
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->create();
                break;
            case 'PUT':
                $response = $this->edit($id);
                break;
            case 'DELETE':
                $response = $this->delete($id);
                break;
            case 'GET':
                if ($id) {
                    $response = $this->find($id);
                } else {
                    $response = $this->index();
                }
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
    private function create()
    {
        require(ROOT.'Models/Phone.php');
        $jsonBody = $this->getRequestBody();
        $phone = new Phone();
        $phone->create(
            $jsonBody->user_id,
            $jsonBody->phone
        );

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] =  NULL;

        return $response;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function edit($id)
    {
        require(ROOT . 'Models/Phone.php');
        $jsonBody = $this->getRequestBody();

        $phone= new Phone();
        if (isset($jsonBody)) {
            $phone->edit(
                $id,
                $jsonBody->phone
            );
        }

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] =  NULL;

        return $response;
    }

    /**
     * @param $id
     * @return mixed
     */
    function delete($id)
    {
        require(ROOT . 'Models/Phone.php');
        $phone = new Phone();
        $phone->delete($id);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = NULL;

        return $response;
    }
}
