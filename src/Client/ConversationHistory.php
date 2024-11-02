<?php

namespace Nexus4812\GptCodeFlow\Client;

class ConversationHistory
{
    private array $messages = [];

    public function addMessage(array $message): void
    {
        $this->messages[] = $message;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function reset(): void
    {
        $this->messages = [];
    }
}
