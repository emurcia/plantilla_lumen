<?php
namespace App\Logging;

// use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Request;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class MySQLLoggingHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        $this->table = 'adt_log';
        parent::__construct($level, $bubble);
    }
    protected function write(array $record):void
    {
        // dd($record);

        $request = Request::instance();
        $content = $request->getContent();

        try {
            $fingerprint = $request->fingerprint();
        } catch (\Exception $e) {
            $fingerprint = '';
        }

        if (isset($record['context'])) {
            $record['context']['URI'] = $_SERVER['REQUEST_URI'] ?? 'CLI?';
        }

        $data = array(
            'contexto'      => json_encode($record['context'], JSON_PRETTY_PRINT),
            'nivel'         => $record['level'],
            'nivel_nombre'  => $record['level_name'],
            'mensaje'       => $record['message'],
            'referencia'    => json_encode($record['extra'], JSON_PRETTY_PRINT),
            'remote_ip'     => $_SERVER['REMOTE_ADDR'] ?? '0',
            'agente'        => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI?',
            'created_at'    => date("Y-m-d H:i:s"),
            'datos'         => $content,
            'huella'        => sha1(APP_START_TIME.$fingerprint),
       );
        FacadesDB::connection()->table($this->table)->insert($data);
    }
}
