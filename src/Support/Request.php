<?php

namespace Dyumna\Minify\Support;

class Request
{

    /**
     * The instance curl
     *
     * @var object
     */
    private $ch;


    /**
     * Handle init curl
     */
    public function init()
    {
        $this->ch = curl_init();
    }

    public function send($url, $data)
    {
        $this->init();

        curl_setopt_array($this->ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);

        $response = $this->execute();

        return $this->done($response);
    }


    /**
     * Execute the curl
     */
    public function execute()
    {
        return curl_exec($this->ch);
    }


    public function done($response)
    {
        $status = [
            'status' => true,
            'body' => $response
        ];

        if (curl_errno($this->ch)) {
            $status = array_merge($status, [
                'status' => false
            ]);
        }

        // finally, close the request
        $this->close();

        // output the $status
        return $status;
    }


    /**
     * Handle close curl
     */
    public function close()
    {
        curl_close($this->ch);
    }
}
