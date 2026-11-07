<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Response;
use Config\App;

class VideoStreamResponse extends Response
{
    public function __construct(
        App $config,
        private readonly string $filePath,
        private readonly int $start,
        private readonly int $length,
        private readonly bool $headRequest
    ) {
        parent::__construct($config);
    }

    public function sendBody()
    {
        if ($this->headRequest || $this->length === 0) {
            return $this;
        }

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $file = fopen($this->filePath, 'rb');
        if ($file === false) {
            log_message('error', 'Unable to open shared video for streaming: {file}', ['file' => $this->filePath]);
            return $this;
        }

        if (fseek($file, $this->start) !== 0) {
            fclose($file);
            log_message('error', 'Unable to seek shared video for streaming: {file}', ['file' => $this->filePath]);
            return $this;
        }

        $remaining = $this->length;
        while ($remaining > 0 && ! feof($file) && connection_status() === CONNECTION_NORMAL) {
            $chunk = fread($file, min(1024 * 1024, $remaining));
            if ($chunk === false || $chunk === '') {
                break;
            }

            echo $chunk;
            $remaining -= strlen($chunk);
            flush();
        }

        fclose($file);
        return $this;
    }
}
