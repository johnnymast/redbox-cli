<?php

namespace Redbox\Cli\Output;

class Line
{
    private const ESCAPE_CHARACTER = "\u{001b}";

    protected string $message;
    protected Style $style;

    protected array $foreground_colors = [
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'white' => 37,
        'reset' => 0,
    ];

    protected array $background_colors = [
        'black' => 40,
        'red' => 41,
        'green' => 42,
        'yellow' => 43,
        'blue' => 44,
        'magenta' => 45,
        'cyan' => 46,
        'white' => 47,
        'reset' => 0,
    ];


    protected array $font_styles = [
        'reset' => 0,
        'bold' => 1,
        'underline' => 4,
        'reversed' => 7,
    ];


    /**
     * @param string                   $message
     * @param \Redbox\Cli\Output\Style $style
     */
    public function __construct(string $message, Style $style)
    {
        $this->message = $message;
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function render(): string
    {

        $fontStyle = $this->font_styles[$this->style->getFontStyle()];
        $backgroundColor = $this->background_colors[$this->style->getBackgroundColor()] ?? 0;
        $foregroundColor = $this->foreground_colors[$this->style->getForegroundColor()] ?? 0;

        $reset = sprintf("%s[%dm ", self::ESCAPE_CHARACTER, 0);

        $style = match (true) {
            ($backgroundColor > 0 && $foregroundColor > 0) => sprintf("%s[%d;%dm", self::ESCAPE_CHARACTER, $foregroundColor, $backgroundColor),
            ($backgroundColor == 0 && $foregroundColor > 0) => sprintf("%s[%dm", self::ESCAPE_CHARACTER, $foregroundColor),
            default => '',
        };

        $output = "{$style}{$this->message}";

        if (strlen($style) > 0) {
            $output .= $reset;
        }

        return $output;
    }

    /**
     * @return \Redbox\Cli\Output\Style
     */
    public function getStyle(): Style
    {
        return $this->style;
    }
}