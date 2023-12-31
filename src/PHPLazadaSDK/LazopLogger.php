<?php

namespace ThanhEXT\PHPLazadaSDK;

class LazopLogger
{
    /**
     * LazopLogger constructor.
     */
    public function __construct()
    {
        if (!defined("LAZOP_SDK_WORK_DIR")) {
            define("LAZOP_SDK_WORK_DIR", dirname(dirname(dirname(dirname(__DIR__)))));
        }

        if (!defined("LAZOP_AUTOLOADER_PATH")) {
            define("LAZOP_AUTOLOADER_PATH", dirname(__FILE__));
        }
    }

    /**
     * @var string[]
     */
    public $conf = array(
            "separator" => "\t",
            "log_file"  => ""
        );
    /**
     * @var
     */
    private $fileHandle;

    /**
     * @return false|resource
     */
    protected function getFileHandle()
    {
        if (null === $this->fileHandle) {
            if (empty($this->conf["log_file"])) {
                trigger_error("no log file spcified.");
            }
            $logDir = dirname($this->conf["log_file"]);
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }
            $this->fileHandle = fopen($this->conf["log_file"], "a");
        }
        return $this->fileHandle;
    }

    /**
     * @param $logData
     *
     * @return false
     */
    public function log($logData)
    {
        if ("" == $logData || array() == $logData) {
            return false;
        }
        if (is_array($logData)) {
            $logData = implode($this->conf["separator"], $logData);
        }
        $logData = $logData . "\n";
        fwrite($this->getFileHandle(), $logData);
    }
}
?>
