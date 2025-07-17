<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public ?string $header;
    public ?string $body;

    public function __construct(string $header = null, string $body = null)
    {
        $this->header = $header;
        $this->body = $body;
    }

    public function render()
    {
        return view('components.card');
    }
}
