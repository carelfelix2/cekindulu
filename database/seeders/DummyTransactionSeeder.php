<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\UserMembership;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DummyTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users (excluding admin)
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please seed users first.');
            return;
        }

        // Get membership plans
        $plans = MembershipPlan::where('slug', '!=', 'free')->get();

        if ($plans->isEmpty()) {
            $this->command->warn('No membership plans found. Please seed membership plans first.');
            return;
        }

        $statuses = ['paid', 'pending', 'failed', 'cancelled'];
        $transactionCount = 0;

        // Create 15-20 dummy transactions
        foreach ($users->take(5) as $user) {
            $numTransactions = rand(2, 4);

            for ($i = 0; $i < $numTransactions; $i++) {
                $plan = $plans->random();
                $status = $statuses[array_rand($statuses)];
                $createdAt = Carbon::now()->subDays(rand(1, 60));

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'membership_plan_id' => $plan->id,
                    'invoice_number' => $this->generateInvoiceNumber($createdAt),
                    'amount' => $plan->price,
                    'payment_method' => 'Simulation',
                    'payment_gateway' => 'simulation',
                    'payment_reference' => $status === 'paid' ? 'SIM-' . strtoupper(substr(uniqid(), -8)) : null,
                    'status' => $status,
                    'paid_at' => $status === 'paid' ? $createdAt->addMinutes(rand(5, 120)) : null,
                    'expires_at' => $status === 'pending' ? $createdAt->addDays(2) : null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // If paid, create user membership
                if ($status === 'paid') {
                    $existingMembership = UserMembership::where('user_id', $user->id)->first();

                    if ($existingMembership) {
                        $existingMembership->update([
                            'membership_plan_id' => $plan->id,
                            'transaction_id' => $transaction->id,
                            'started_at' => $createdAt,
                            'ends_at' => $createdAt->copy()->addDays($plan->duration_days),
                            'is_active' => true,
                        ]);
                    } else {
                        UserMembership::create([
                            'user_id' => $user->id,
                            'membership_plan_id' => $plan->id,
                            'transaction_id' => $transaction->id,
                            'started_at' => $createdAt,
                            'ends_at' => $createdAt->copy()->addDays($plan->duration_days),
                            'is_active' => true,
                        ]);
                    }
                }

                $transactionCount++;
            }
        }

        $this->command->info("✓ Created {$transactionCount} dummy transactions successfully!");
    }

    /**
     * Generate invoice number with date.
     */
    private function generateInvoiceNumber(Carbon $date): string
    {
        $prefix = 'INV-CDL-';
        $dateStr = $date->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));

        return $prefix . $dateStr . '-' . $random;
    }
}
