<?php
namespace Redbox\Cli\Arguments;
use Redbox\Cli\Object\Object as ArgumentObject;

class Argument extends ArgumentObject {
    public $prefix;
    public $defaultValue;
    public $longPrefix;
    public $description;
    public $required;
    public $noValue;
    public $name;


    public function usageInfo() {
        $arg = array();
        if ($this->prefix) {
            $arg[] = '-'.$this->prefix.' '.$this->name;
        }
        if ($this->longPrefix) {
            $arg[] = '--'.$this->longPrefix.' '.$this->name;
        }
        if ($this->defaultValue) {
            $arg[] = '(default: '.$this->defaultValue . ')';
        }
        if (!$this->prefix && !$this->longPrefix) {
            $arg[] = $this->name;
        }
        $arg = implode(', ', $arg);

        return $arg;
    }
    public function usageLine()
    {
        $arg = $this->usageInfo();
        return sprintf("\t%s\n\t\t%s\n", $arg, $this->description);
    }
}
