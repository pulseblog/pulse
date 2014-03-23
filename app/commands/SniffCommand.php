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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
    	return $text;
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
