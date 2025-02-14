<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class CyberbullyingDetectionService
{
    protected $pythonScript;
    protected $pythonInterpreter;

    public function __construct()
    {
        // store both the script path and Python interpreter path from .env
        $this->pythonScript = base_path('app/python/app.py');
        $this->pythonInterpreter = env('PYTHON_PATH');  
    }

    /**
     * analyze text for cyberbullying
     */
    public function analyze($text)
    {
        try {
            // input validation
            if (empty($text)) {
                throw new Exception('Empty input text provided');
            }

            // verify Python script exists
            if (!file_exists($this->pythonScript)) {
                throw new Exception("Python script not found at: {$this->pythonScript}");
            }

            // verify Python interpreter exists
            if (empty($this->pythonInterpreter) || !file_exists($this->pythonInterpreter)) {
                throw new Exception("Python interpreter not found at: {$this->pythonInterpreter}");
            }

            // build the command with proper escaping and input from file
            $command = sprintf(
                '%s %s %s 2>&1',
                escapeshellarg($this->pythonInterpreter),
                escapeshellarg($this->pythonScript),
                escapeshellarg($text)
            );

            // execute Python script with increased memory limit and timeout
            $output = null;
            $returnVar = null;
            
            // set resource limits
            $descriptorSpec = [
                0 => ['pipe', 'r'],  // stdin
                1 => ['pipe', 'w'],  // stdout
                2 => ['pipe', 'w']   // stderr
            ];
            
            // execute the command
            $process = proc_open($command, $descriptorSpec, $pipes);
            
            if (is_resource($process)) {
                // read output
                $output = stream_get_contents($pipes[1]);
                $errors = stream_get_contents($pipes[2]);
                
                // close pipes
                foreach ($pipes as $pipe) {
                    fclose($pipe);
                }
                
                // close process
                $returnVar = proc_close($process);
            }

            if ($returnVar !== 0) {
                throw new Exception("Python script execution failed with code $returnVar: " . ($errors ?? 'Unknown error'));
            }

            // handle empty output
            if (empty($output)) {
                throw new Exception('No output from Python script');
            }

            // parse JSON response
            $result = json_decode($output, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response: ' . json_last_error_msg());
            }

            return [
                'error' => $result['error'] ?? null,
                'analysisResult' => $result['result'] ?? 'Analysis Failed',
                'analysisProbability' => $result['probability'] ?? 0
            ];

        } catch (Exception $e) {
            Log::error('Cyberbullying Analysis Error', [
                'error' => $e->getMessage(),
                'input_text' => $text,
                'script_path' => $this->pythonScript,
                'python_interpreter' => $this->pythonInterpreter
            ]);
            
            return [
                'error' => 'Analysis failed: ' . $e->getMessage(),
                'analysisResult' => 'Analysis Failed',
                'analysisProbability' => 0
            ];
        }
    }
}
