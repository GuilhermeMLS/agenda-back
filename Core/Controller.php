<?php


class Controller
{
    /**
     * @return mixed
     */
    public function notFound()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => 'not_found',
            'message' => 'Route not found',
        ]);

        return $response;
    }

    /**
     * @return mixed
     */
    public function getRequestBody(){
        $requestBody = file_get_contents('php://input');

        return json_decode($requestBody);
    }
}
