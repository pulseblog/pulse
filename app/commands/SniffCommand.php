<?php namespace Pulse\CodeSniffer;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SniffCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sniff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Array of possible shell colors
     * @var array
     */
    private $colors = array();

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Set up shell colors
        $this->colors['black']           = '0;30';
        $this->colors['dark_gray']       = '1;30';
        $this->colors['blue']            = '0;34';
        $this->colors['light_blue']      = '1;34';
        $this->colors['green']           = '0;32';
        $this->colors['light_green']     = '1;32';
        $this->colors['cyan']            = '0;36';
        $this->colors['light_cyan']      = '1;36';
        $this->colors['red']             = '0;31';
        $this->colors['light_red']       = '1;31';
        $this->colors['purple']          = '0;35';
        $this->colors['light_purple']    = '1;35';
        $this->colors['brown']           = '0;33';
        $this->colors['yellow']          = '1;33';
        $this->colors['light_gray']      = '0;37';
        $this->colors['white']           = '1;37';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        exec('./vendor/bin/phpcs --standard=PSR2 -p app/models app/controllers', $output);
        foreach ($output as $line) {
            echo $this->formatLine($line)."\n";
        }
    }

    /**
     * Adds color to a line before printing in the terminal.
     * @param  string $text Output line to be formated
     * @return string Formated line
     */
    protected function formatLine($text)
    {
        if (strstr($text, '---------')) {
            return $this->colorize('dark_gray', $text);
        } elseif (strstr($text, 'FILE: ')) {
            return $this->colorize('light_green', $text);
        } elseif (strstr($text, 'ERROR(S)')) {
            return $this->colorize('light_red', $text);
        } elseif (strstr($text, 'ERROR')) {
            return str_replace('ERROR', $this->colorize('light_red', 'ERROR'), $text);
        } elseif (strstr($text, 'WARNING')) {
            return str_replace('WARNING', $this->colorize('yellow', 'WARNING'), $text);
        } else {
            return $text;
        }
    }

    /**
     * Returns colored output
     * @param  string $color  Color name
     * @param  string $string Text
     * @return void
     */
    private function colorize($color, $string)
    {
        return
            "\033[" . $this->colors[$color] . "m".
            $string.
            "\033[0m";
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
