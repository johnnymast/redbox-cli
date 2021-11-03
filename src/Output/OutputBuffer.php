<?php
/*
 * This file is part of Redbox-Cli
 *
 * (c) Johnny Mast <mastjohnny@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Redbox\Cli\Output;

/**
 * @internal
 */
class OutputBuffer
{

    /**
     * Is silent mode enabled.
     *
     * @var bool
     */
    protected bool $silentMode = false;

    /**
     * The buffer container.
     *
     * @var \Redbox\Cli\Output\Buffer
     */
    protected Buffer $container;

    /**
     * The current style.
     *
     * @var \Redbox\Cli\Output\Style
     */
    public Style $style;

    /**
     * The constructor of the OutputBuffer.
     */
    public function __construct()
    {
        $this->container = new Buffer();
        $this->style = new Style();
    }

    /**
     * Add a single line.
     *
     * @param mixed $line The line to add to the output buffer.
     *
     * @return $this
     */
    public function addLine(mixed $line): OutputBuffer
    {
        $line = new Line($line, $this->style->withStyle($this->style));

        $this->container[] = $line;

        return $this;
    }

    /**
     * Add an array of lines.
     *
     * @param array<Line> $lines The array of line objects to add to the output buffer.
     *
     * @return $this
     */
    public function addLines(array $lines): OutputBuffer
    {
        foreach ($lines as $line) {
            $this->addLine($line);
        }
        return $this;
    }

    /**
     * Add a new line to the output buffer.
     *
     * @param string $line The line to add.
     *
     * @return $this
     */
    public function addRawLine(string $line): OutputBuffer
    {
        $line = new RawLine($line, new Style());
        $this->container[] = $line;

        return $this;
    }

    /**
     * Add a newline to the buffer.
     *
     * @return $this
     */
    public function addNewLine(): OutputBuffer
    {
        return $this->addRawLine("\n");
    }

    /**
     * Return the style object.
     *
     * @return \Redbox\Cli\Output\Style
     */
    public function getStyle(): Style
    {
        return $this->style;
    }

    /**
     * Check if silent mode is enabled.
     *
     * @return bool
     */
    public function isSilent(): bool
    {
        return $this->silentMode;
    }

    /**
     * Enable or Disable silent mode. During silent mode
     * output is not shown on the screen. You can fetch the
     * output with the fetch function.
     *
     * @param bool $enabled
     *
     * @return void
     * @see \Redbox\Cli\Output\OutputBuffer::fetch()
     */
    public function setSilentMode(bool $enabled): void
    {
        $this->silentMode = $enabled;
    }

    /**
     * Render the output.
     *
     * @return void
     */
    public function show(): void
    {
        if ($this->isSilent() === false) {

            foreach ($this->container as $line) {
                echo $line->render();
            }

            $this->style->reset();
            $this->container->exchangeArray([]);
        }
    }

    /**
     * Return the output as a string.
     *
     * @return string
     */
    public function fetch(): string
    {
        $output = '';

        foreach ($this->container as $line) {
            $output .= $line->render();
        }

        $this->style->reset();
        $this->container->exchangeArray([]);

        return $output;
    }
}