<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class UploadComponent extends Component
{
    public function uploadFile($folder, $uniqName, $data)
    {
        $dir = WWW_ROOT . 'files' . DS . $folder;

        foreach ($data as $file) {
            $file_tmp_name = $file['tmp_name'];

            if (is_uploaded_file($file_tmp_name)) {
                move_uploaded_file($file_tmp_name, $dir . DS . $uniqName);
            }
        }
    }
}
