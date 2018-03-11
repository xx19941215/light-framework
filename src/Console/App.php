<?php
namespace Light\Console;

class App extends \Light\Foundation\App
{
    public function cmd($argv)
    {
        $cmdMap = $this->buildCmdMap();

        if (!isset($argv[1])) {
            $this->printHelp($cmdMap);
            return;
        }

        $commandName = $argv[1];
        $commandClass = prop($cmdMap, $commandName);

        if (!$commandClass) {
            echo "cannot find command [$commandName];\n";
            return;
        }

        if (! method_exists($instance = $this->make($commandClass, ['argv' => $argv]), 'run')) {
            //todo
            throw new \Exception('not found');
        }

        return $this->call([$instance, 'run']);
    }

    protected function printHelp($cmdMap)
    {
        $help = "Useage: \n"
            . "  light COMMAND [options]\n"
            . "  COMMAND:\n";

        foreach ($cmdMap as $key => $val) {
            $help .= "    $key => $val \n";
        }

        echo $help;
    }

    protected function buildCmdMap()
    {
        return require $this->basePath . '/config/cmd.php';
    }
}