<?php

declare(strict_types=1);

namespace App;

final class Merchant
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}