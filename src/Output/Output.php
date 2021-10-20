<?php
/**
 * Cli.php
 *
 * The main CLI class.
 *
 * PHP version ^8.0
 *
 * @category Output
 * @package  Redbox-Cli
 * @author   Johnny Mast <mastjohnny@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  1.5
 * @link     https://github.com/johnnymast/redbox-cli/blob/master/LICENSE.md
 * @since    1.0
 */

namespace Redbox\Cli\Output;

/**
 * Manage the output.
 */
class Output
{
    protected Buffer $buffer;
    public Style $style;
    protected bool $silentMode = false;

    public function __construct()
    {
        $this->buffer = new Buffer();
        $this->style = new Style();
    }

    public function addLine(mixed $line): Output
    {
        $line = new Line($line, $this->style->withStyle($this->style));

        $this->buffer[] = $line;

        return $this;
    }

    public function addLines(array $lines): Output
    {
        foreach ($lines as $line) {
            $this->addLine($line);
        }
        return $this;
    }

    public function addRawLine(string $line): Output
    {
        $line = new RawLine($line, new Style());
        $this->buffer[] = $line;

        return $this;
    }

    public function addNewLine(): Output
    {
        return $this->addRawLine("\n");
    }

    public function getStyle(): Style
    {
        return $this->style;
    }

    public function isSilent(): bool
    {
        return $this->silentMode;
    }

    public function setSilentMode(bool $enabled)
    {
        $this->silentMode = $enabled;
    }

    public function output()
    {
        if ($this->isSilent() === false) {

            foreach ($this->buffer as $line) {
                echo $line->render();
            }

            $this->style->reset();
            $this->buffer->exchangeArray([]);
        }
    }

    public function fetch(): string
    {
        $output = '';

        foreach ($this->buffer as $line) {
            $output .= $line->render();
        }

        $this->style->reset();
        $this->buffer->exchangeArray([]);

        return $output;
    }
}