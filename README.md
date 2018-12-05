## Code Sample
The goal here was to create a system to benchmark php functions and provide different methods to output that data to the user.

Example artisan command to make this work: `php artisan run:benchmark --func=bubbleSort --func=quickSort 50`

Follow the prompts after the command is run to change how the data is sorted and/or output

### Unit testing
This includes unit testing to cover most of the written code as a way of showing how I would typically approach unit testing.

Run: `phpunit`
