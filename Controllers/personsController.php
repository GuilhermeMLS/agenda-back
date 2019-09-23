<?php

class personsController extends Controller
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
     * @param $id
     * @return mixed
     */
    private function find($id)
    {
        require(ROOT.'Models/Person.php');
        $person = new Person();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';

        $result = $person->find($id);

        $output['id'] = $result[0]['id'];
        $output['name'] = $result[0]['name'];
        $output['company'] = $result[0]['company'];
        $output['birthday'] = $result[0]['birthday'];
        $output['email'] = $result[0]['email'];

        $i = 0;
        foreach ($result as $r) {
            if ($r['phone'] != NULL) {
                $output['phones'][$i++] = array('id' => $r['phone_id'], 'phone' => $r['phone']);
            }
        }

        $response['body'] = json_encode($output);

        if ($result == []) {
            $response['body'] = json_encode([
                'error' => 'no_query_results',
                'message' => 'No query results for id = '.$id
            ]);
        }

        return $response;
    }

    /**
     * @return mixed
     */
    private function index()
    {
        require(ROOT.'Models/Person.php');
        $persons = new Person();

        $response['status_code_header'] = 'HTTP/1.1 200 OK';

        $result = $persons->all();
        $i = 0;
        foreach ($result as $r) {
            if ($r['phones'] != null) {
                $array = explode(',', $r['phones']);
                $result[$i]['phones'] = array();
                $result[$i]['phones'] = $array;
            }
            $i++;
        }

        $response['body'] = json_encode($result);

        return $response;
    }

    /**
     * @return mixed
     */
    private function create()
    {
        require(ROOT.'Models/Person.php');
        $jsonBody = $this->getRequestBody();
        $person = new Person();
        $person->create(
            $jsonBody->name,
            $jsonBody->company,
            $jsonBody->birthday,
            $jsonBody->email
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
        require(ROOT . 'Models/Person.php');
        $jsonBody = $this->getRequestBody();
        $person= new Person();
        if (isset($jsonBody)) {
            $person->edit(
                $id,
                $jsonBody->name,
                $jsonBody->company,
                $jsonBody->birthday,
                $jsonBody->email
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
        require(ROOT . 'Models/Person.php');
        $person = new Person();
        $person->delete($id);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = NULL;

        return $response;
    }
}
