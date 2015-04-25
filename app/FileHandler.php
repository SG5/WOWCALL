<?php

class FileHandler
{
    const WOWCALL_BUCKET = "wowcall_records";

    public function receiveWowcall($files)
    {
        if (empty($files) || $files["record"]["error"] !== UPLOAD_ERR_OK) {
            throw new RuntimeException($files["record"]["error"]);
        }

        move_uploaded_file($files["record"]["tmp_name"], 'gs://'.self::WOWCALL_BUCKET.'/record.wav');
    }
}