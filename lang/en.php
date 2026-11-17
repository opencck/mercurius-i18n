<?php

declare(strict_types=1);

/*
 * Texts of the agent in English. Same keys and placeholders as ru.php; plural forms are "key.one" and "key.other".
 */
return [
    // Chat: answers without the model
    'chat.refusal' => 'This is a personal agent. You have no access.',
    'chat.not_text' => 'For now I understand only text messages.',
    'chat.new_conversation' => 'A new conversation has started. I no longer take the previous one into account.',
    'chat.greeting' => "Hello! I am Mercurius, your personal agent.\n\n/new — start a new conversation.\n/stop — stop the current task.\n\n"
        . 'For the owner: /permissions — saved permissions, /usage — spend, /runs — recent runs, /trace <number> — a run in detail, '
        . '/delegation — how the agent splits tasks, /memory — what I remember, /forget <number> — forget a fact, /consolidate — check the memory, '
        . '/projects and /project <name> — projects and the project of this chat, /secret <name> <value> — keep a secret, /servers — servers, '
        . '/audit — command log, /skills — skills, /mcp — MCP servers, /jobs — jobs, /hook — job webhooks, /digest — digest of tasks, '
        . '/doctor — installation check, /settings — settings, /set — change one, /restart — restart, /peers — agent network.',
    'chat.nothing_to_stop' => 'Nothing is running right now.',
    'chat.no_grants' => 'There are no saved permissions.',
    'chat.owner_only' => 'This command is for the owner only.',
    'chat.private_only' => 'I show reports only in a private chat.',
    'chat.memory_private' => 'I show the memory only in a private chat.',
    'chat.secret_private' => 'Secrets only in a private chat; I will delete the message with the secret.',

    // Run: number of model calls
    'run.model_calls.one' => '{count} model call',
    'run.model_calls.other' => '{count} model calls',
];
