<?php
class errorhandler
{
    private $errorConstants = array(
        1       => 'Error',
        2       => 'Warning',
        4       => 'Parse error',
        8       => 'Notice',
        16      => 'Core Error',
        32      => 'Core Warning',
        256     => 'User Error',
        512     => 'User Warning',
        1024    => 'User Notice',
        2048    => 'Strict',
        4096    => 'Recoverable Error',
        8192    => 'Deprecated',
        16384   => 'User Deprecated',
        32767   => 'All'
    );

    public function __construct()
    {
        set_error_handler(array($this, 'errorHandler'));
        set_exception_handler(array($this, 'exceptionHandler'));
    }

    public function exceptionHandler($exception)
    {
        $message = '<strong>'.$exception->getMessage().'</strong>'.' [code: '.$exception->getCode().']'.' [file: '.$exception->getFile().']'.' [line: '.$exception->getLine().']';
        echo '<h2>Application exception:</h2>'.$message;
    }
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $errString = (array_key_exists($errno, $this->errorConstants)) ? $this->errorConstants[$errno] : $errno;        
        if ($errno !== E_NOTICE && $errno !== E_STRICT) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        } else {
            echo '<strong>EL Error</strong>: '.$errString.': '.$errstr.', fisier: '.$errfile,', linie: '.$errline.' !!!<br />';
        }
        //error_log($errString.' ['.$errno.']: '.$errstr.' in '.$errfile.' on line '.$errline);
    }
}


?>