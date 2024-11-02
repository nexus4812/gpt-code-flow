<?php

namespace Nexus4812\GptCodeFlow\Verification;

interface VerificationInterface
{
    public function verification(string $pathToGenerated): string|bool;
}
