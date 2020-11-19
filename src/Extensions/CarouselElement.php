<?php

namespace TheArdent\Drivers\Viber\Extensions;

use Illuminate\Contracts\Support\Arrayable;

class CarouselElement implements Arrayable
{
    const COLUMNS = 6;
    const ROWS = 3;
    const BG_COLOR = '#675AAA';
    const ACTION_TYPE = 'reply';
    const ACTION_BODY = '#';
    const TEXT_OPTIONS = [
        'size' => 'small',
        'vertical' => 'middle',
        'horizontal' => 'middle'
    ];
    const IMAGE_URL = '';

    public $columns;
    public $rows;
    protected $text;
    protected $type;
    protected $bgColor;
    protected $actionBody;
    protected $textOptions;
    /**
     * @var string
     */
    protected $imageUrl;

    public static function create(string $text, int $columns = self::COLUMNS, int $rows = self::ROWS)
    {
        return new self($text, $columns, $rows);
    }

    public function __construct($text, $columns, $rows)
    {
        $this->text = $text;
        $this->columns = $columns;
        $this->rows = $rows;
        $this->type = self::ACTION_TYPE;
        $this->bgColor = self::BG_COLOR;
        $this->actionBody = self::ACTION_BODY;
        $this->textOptions = self::TEXT_OPTIONS;
        $this->imageUrl = self::IMAGE_URL;
    }

    public function type(string $type)
    {
        $this->type = $type;
    }

    public function bgColor(string $bgColor)
    {
        $this->bgColor = $bgColor;
    }

    public function textOptions(array $textOptions)
    {
        $this->textOptions = $textOptions;
    }

    public function image(string $url)
    {
        $this->imageUrl = $url;
    }

    public function toArray()
    {
        $element = [
            'Columns' => $this->columns,
            'Rows' => $this->rows,
            'Text' => $this->text,
            'ActionType' => $this->type,
            'TextSize' => $this->textOptions['size'],
            'TextVAlign' => $this->textOptions['vertical'],
            'TextHAlign' => $this->textOptions['horizontal'],
            'ActionBody' => $this->actionBody,
            'BgColor' => $this->bgColor
        ];

        if ($this->imageUrl != '') {
            $element['Image'] = $this->imageUrl;
        }

        return $element;
    }
}