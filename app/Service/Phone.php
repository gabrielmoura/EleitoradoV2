<?php

namespace App\Service;

class Phone
{
    protected ?string $ddd;

    protected ?string $ddi;

    protected string $phone;

    public function __construct(string $phone)
    {
        $length = strlen($phone);

        if ($length === 13 || $length === 12) {
            $this->ddi = substr($phone, 0, 2);
            $this->ddd = substr($phone, 2, 2);
            $this->phone = substr($phone, 4);
        } elseif ($length === 11 || $length === 10) {
            $this->ddd = substr($phone, 0, 2);
            $this->phone = substr($phone, 2);
        } elseif ($length === 9 || $length === 8) {
            $this->phone = $phone;
        }
    }

    public function __toString(): string
    {
        $to = '';
        if (isset($this->ddi)) {
            $to .= $this->ddi;
        }
        if (isset($this->ddd)) {
            $to .= $this->ddd;
        }

        return $to.$this->phone;
    }

    public function toE164(): string
    {
        if (empty($this->ddi)) {
            $this->ddi = '55';
        }
        if (empty($this->ddd)) {
            $this->ddd = '21';
        }

        return '+'.$this->ddi.$this->ddd.$this->phone;
    }

    public static function from(string $phone): self
    {
        return new self($phone);
    }

    public function format(): string
    {
        return '('.$this->ddd.') '.substr($this->phone, 0, -4).'-'.substr($this->phone, -4);
    }
}
