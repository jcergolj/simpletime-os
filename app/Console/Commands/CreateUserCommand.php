<?php

namespace App\Console\Commands;

use App\Enums\Currency;
use App\Models\User;
use App\ValueObjects\Money;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    protected $signature = 'app:create-user {--force : Force create user even if one already exists}';

    protected $description = 'Create a new user for the time tracking application';

    public function handle(): int
    {
        if (User::exists() && ! $this->option('force')) {
            $this->error('A user already exists in the system.');
            $this->info('Only one user is allowed per application.');
            $this->info('Use --force flag if you want to create another user anyway.');

            return self::FAILURE;
        }

        if (User::exists() && $this->option('force')) {
            $this->warn('Warning: A user already exists, but creating another due to --force flag.');
        }

        $this->components->info('Creating a new user for the time tracking application...');
        $this->components->info('This will be your login account for accessing the dashboard.');
        $this->newLine();

        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email address?');

        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        if ($validator->fails()) {
            $this->error('Invalid email or email already exists: '.implode(', ', $validator->errors()->all()));

            return self::FAILURE;
        }

        $password = $this->secret('Enter your password');
        $passwordConfirmation = $this->secret('Confirm your password');

        if ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match.');

            return self::FAILURE;
        }

        if (strlen((string) $password) < 8) {
            $this->error('Password must be at least 8 characters long.');

            return self::FAILURE;
        }

        $hourlyRateInput = $this->ask('What is your default hourly rate? (Optional, press Enter to skip)');

        $hourlyRateInput = $this->ask('What is your default hourly rate? (Optional, press Enter to skip)');

        /** @var Money|null $hourlyRate */
        $hourlyRate = null;

        if (! empty($hourlyRateInput)) {
            $hourlyRateAmount = (float) $hourlyRateInput;
            if ($hourlyRateAmount > 0) {
                $currency = $this->choice('Select currency', Currency::options(), 'USD');

                $hourlyRate = Money::fromDecimal($hourlyRateAmount, $currency);
            }
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'hourly_rate' => $hourlyRate,
            ]);

            $user->load('hourlyRate');

            $this->info('User created successfully!');

            $tableData = [
                'ID' => $user->id,
                'Name' => $user->name,
                'Email' => $user->email,
                'Hourly Rate' => $user->hourlyRate ? $user->hourlyRate->formatted().'/hr' : 'Not set',
                'Created' => $user->created_at->format('Y-m-d H:i:s'),
            ];

            $this->table(
                array_keys($tableData),
                [array_values($tableData)]
            );

            $this->newLine();
            $this->info('🎉 Your account is ready!');
            $this->info('You can now login to the application with your email and password.');
            $this->newLine();
            $this->comment('To start the development server: php artisan serve');
            $this->comment('Then visit: http://localhost:8000');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to create user: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
