# Messenger POC

## Setup
- `composer install`
- setup local DB
- create `.env.local` file with `DATABASE_URL` variable
- `bin/console doctrine:migrations:migrate`
- `symfony serve -d` (if you're using SF server)

## Endpoints

For a testing purpose I created several endpoints which run `messenger:consume` console command. But feel free to run `bin/console messenger:consume <transport_name> --limit=<limit>` in cmd.

- `/dispatchMessage` - dispatches a valid message, returns `MessengerMessageLog.messengerMessageId`.

- `/consume/{limit}` - runs a worker which consumes messages from `async` transport. `limit` - number of messages to consume.

- `/dispatchFailedMessage` - dispatches a message message which throws an exception, returns `MessengerMessageLog.messengerMessageId`.

- `/consumeFailed/{limit}` - runs a worker which consumes messages from `failed` transport. `limit` - number of messages to consume.

- `/checkStatus/{messageId}` - returns a status of logged message `MessengerMessageLog.messengerMessageId`.
