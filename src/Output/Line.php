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
class Line
{
    /**
     * The reset style character.
     */
    public const ESCAPE_CHARACTER = "\u{001b}";

    /**
     * The content for the line.
     *
     * @var string
     */
    protected string $contents;

    /**
     * The style for this line.
     *
     * @var \Redbox\Cli\Output\Style
     */
    protected Style $style;

    /**
     * Map foreground color names to
     * their int values.
     *
     * @var array|int[]
     */
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

    /**
     * Map background color names to
     * their int values.
     *
     * @var array|int[]
     */
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

    /**
     * Map font styles names to
     * their int values.
     *
     * @var array|int[]
     */
    protected array $font_styles = [
        'reset' => 0,
        'bold' => 1,
        'underline' => 4,
        'reversed' => 7,
    ];

    /**
     * The Line constructor.
     *
     * @param string                   $contents The contents of the line.
     * @param \Redbox\Cli\Output\Style $style    The style for this line.
     */
    public function __construct(string $contents, Style $style)
    {
        $this->contents = $contents;
        $this->style = $style;
    }

    /**
     * Render the output.
     *
     * @return string
     */
    public function render(): string
    {

        $fontStyle = $this->font_styles[$this->style->getFontStyle()];
        $backgroundColor = $this->background_colors[$this->style->getBackgroundColor()] ?? 0;
        $foregroundColor = $this->foreground_colors[$this->style->getForegroundColor()] ?? 0;

        $reset = sprintf("%s[%dm ", self::ESCAPE_CHARACTER, 0);


        $style = match (true) {
            ($backgroundColor > 0) => sprintf("%s[%d;%dm", self::ESCAPE_CHARACTER, $foregroundColor, $backgroundColor),
            ($backgroundColor === 0 && $foregroundColor > 0) => sprintf("%s[%dm", self::ESCAPE_CHARACTER, $foregroundColor),
            default => '',
        };

        $output = "{$style}{$this->contents}";

        if ($style !== '') {
            $output .= $reset;
        }

        return trim($output);
    }

    /**
     * Return the line contents.
     *
     * @return string
     */
    public function getContents(): string {
        return $this->contents;
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
}