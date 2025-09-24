<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Ticket;

class CleanupCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:categories {--delete-empty : Delete categories without tickets} {--list-only : Only list categories}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List and cleanup categories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Kategóriák listája:');
        $this->line('');

        $categories = Category::all();
        
        $headers = ['ID', 'Név', 'Jegyek száma', 'Státusz'];
        $rows = [];

        foreach ($categories as $category) {
            $ticketCount = $category->tickets()->count();
            $status = $ticketCount > 0 ? 'Jegyekkel' : 'Üres';
            $rows[] = [
                $category->id,
                $category->name,
                $ticketCount,
                $status
            ];
        }

        $this->table($headers, $rows);

        // Find problematic categories (test categories)
        $testCategories = $categories->filter(function($cat) {
            return in_array(strtolower($cat->name), ['asd', 'dsa', 'pis', 'test', 'teszt']);
        });

        if ($testCategories->count() > 0) {
            $this->line('');
            $this->warn('Talált teszt kategóriák:');
            foreach ($testCategories as $cat) {
                $ticketCount = $cat->tickets()->count();
                $this->line("- {$cat->name} (ID: {$cat->id}) - {$ticketCount} jegy");
            }

            if ($this->option('delete-empty')) {
                $emptyTestCategories = $testCategories->filter(function($cat) {
                    return $cat->tickets()->count() == 0;
                });

                if ($emptyTestCategories->count() > 0) {
                    $this->line('');
                    $this->info('Üres teszt kategóriák törlése...');
                    
                    foreach ($emptyTestCategories as $cat) {
                        // Delete form field associations first
                        $cat->formFields()->detach();
                        
                        // Delete the category
                        $cat->delete();
                        $this->line("✓ Törölve: {$cat->name}");
                    }
                } else {
                    $this->warn('Minden teszt kategóriához tartoznak jegyek, nem lehet törölni őket.');
                    $this->line('');
                    $this->comment('Ha mégis törölni szeretnéd őket, először töröld a hozzájuk tartozó jegyeket.');
                }
            } else {
                $this->line('');
                $this->comment('Az üres kategóriák törléséhez használd a --delete-empty opciót');
            }
        } else {
            $this->info('Nem találhatók teszt kategóriák.');
        }
    }
}
