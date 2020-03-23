<?php

namespace sbwms\Controller;

class BaseController {
    protected function render_view(string $viewPath, array $data=[]) :string {
        extract($data, EXTR_SKIP);
        ob_start();
        include_once $viewPath;
        $html = ob_get_clean();
        return $html;
    }

    protected function render_result($result) {
        /*
            statuses - messages
            0 = success
            1 = validation error
            2 = result error (db)
        */
        if (!(\is_array($result) || \is_numeric($result))) {
            var_dump($result);
            exit('dev error - unknown code format');
        }

        $error_list = [
            '23000' => 'Possible Concurrency Error'
        ];

        $status = '';
        $message = '';
        $output = [];

        // if validation error the result contains the key 'validationError
        //  it also contains whatever messages the handlers send
        // these are put into key 'error'
        if (isset($result['validationError'])) { // validation error
            $status = 1;
            $message = 'Validation Error';
            unset($result['validationError']); // remove key
            $output['errors'] = $result;
        }

        if (is_array($result) && isset($result['result'])) {
            if ($result['result'] === true) {
                $status = 0;
                $message = 'success';
            } elseif ($result['result'] === false) {
                $status = 2;
                $message = 'result error';
            }

            $data = $result['data'] ?? [];
            if (!empty($data)) {
                $output['data'] = $result['data'];
            }
        }

        if (\is_numeric($result)) {
            $status = 2;
            $message = 'Database Error';
        }

        $output['status'] = $status;
        $output['message'] = $message;

        return \json_encode($output);
    }
}