<?php

namespace Nexus4812\GptCodeFlow\Client;

use OpenAI\Client;

class ChatGptTalk
{
    private ConversationHistory $conversationHistory;

    public function __construct(
        private Client $client
    )
    {
        $this->conversationHistory = new ConversationHistory();
    }

    /**
     * @param string $modelName
     * @param array{role: string, message: string} $message
     * @return string
     */
    public function sendMessage(string $modelName, array $message): string
    {
        // ChatGPTへ送信
        $response = $this->client->chat()->create([
            'model' => $modelName,
            'messages' => $this->conversationHistory->getMessages(),
        ]);

        $responseContent = $response['choices'][0]['message']['content'];

        // 履歴を保存
        $this->conversationHistory->addMessage([
            'role' => 'user',
            'content' => $message,
        ]);
        $this->conversationHistory->addMessage([
            'role' => 'assistant',
            'content' => $responseContent,
        ]);

        return $responseContent;
    }

    public function resetTalk(): void
    {
        $this->conversationHistory->reset();
    }
}

