<?php namespace Octobro\Logable\Traits;

use Storage;

trait Logable {

    /**
     * Get Log Records Based on Date
     * 
     * @param String $date
     * @return mixed
     */
    protected function getRecords($date = null)
    {
        $date = $date?:now()->toDateString();

        $path = $this->logPath?:'logs';
        $logPath = $path.'/'.$this->logPrefix.'-'.$date.'.log';

        if (Storage::disk(env('FILESYSTEM_DRIVER', 'local'))->exists($logPath)) {
            $path = (env('FILESYSTEM_DRIVER', 'local') == 'local' ? storage_path() : env('S3_URL')).'/'.$logPath;
            $logFile = file($path);
            $log = collect($logFile)->map(function ($item, $key) {
                $item = json_decode($item);
                $item->id = $key;
                // $item->date = Carbon::parse($item->date);
                return $item;
            })->sortByDesc('date');
            return $log;
        } else {
            return [];
        }
    }

    /**
     * Get Find Record Based on Date
     * 
     * @param Int $id
     * @param String $date
     * @return object
     */
    protected function find($id, $date=null)
    {
        $date = $date?:now()->toDateString();

        $path = $this->logPath?:'logs';
        $logPath = $path.'/'.$this->logPrefix.'-'.$date.'.log';
        
        if (Storage::disk(env('FILESYSTEM_DRIVER', 'local'))->exists($logPath)) {
            $path = (env('FILESYSTEM_DRIVER', 'local') == 'local' ? storage_path() : env('S3_URL')).'/'.$logPath;
            $logFile = file($path);

            $log = collect($logFile)->first(function ($value, $key) use ($id) {
                return $key == $id;
            });

            if (!$log) {
                return null;
            }
            
            $log = json_decode($log);
            $log->id = $id;
            
            return $log;
        } else {
            return null;
        }
    }

    protected function emergency($message, $data = null)
    {
        $this->createLog($message, $data, 'Emergency');
    }

    protected function alert($message, $data = null)
    {
        $this->createLog($message, $data, 'Alert');
    }

    protected function critical($message, $data = null)
    {
        $this->createLog($message, $data, 'Critical');
    }

    protected function error($message, $data = null)
    {
        $this->createLog($message, $data, 'Error');
    }

    protected function warning($message, $data = null)
    {
        $this->createLog($message, $data, 'Warning');
    }

    protected function notice($message, $data = null)
    {
        $this->createLog($message, $data, 'Notice');
    }

    protected function info($message, $data = null)
    {
        $this->createLog($message, $data, 'Info');
    }

    protected function debug($message, $data = null)
    {
        $this->createLog($message, $data, 'Debug');
    }

    protected function createLog($message, $data, $level)
    {
        $path = $this->logPath?:'logs';
        $logPath = $path.'/'.$this->logPrefix.'-'.now()->toDateString().'.log';

        $log = [
            'date' => now()->toDateTimeString(),
            'level' => $level,
            'message' => $message,
            'data' => json_encode($data)
        ];

        Storage::disk('s3')->append($logPath, json_encode($log));
    }
}