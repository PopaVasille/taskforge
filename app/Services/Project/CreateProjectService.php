<?php

namespace App\Services\Project;

use Illuminate\Support\Facades\DB;

class CreateProjectService
{
    public function __construct()
    {
    }

    public function projectKeyGenerator(string $name): string
    {
        $matches = [];
        preg_match_all('/[A-Z]/', $name, $matches);
        $uppercaseLetters = $matches[0];

        $words = explode(' ', $name);
        $key = strtoupper($words[0][0]);

        foreach ($uppercaseLetters as $uppercaseLetter) {
            if (strtoupper($uppercaseLetter) !== $key) {
                $key .= strtoupper($uppercaseLetter);
            }
        }


        if (strlen($key) < 2) {
            $key .= isset($words[0][1]) ? strtoupper($words[0][1]) : 'X';
        }

        $originalKey = $key;
        $counter = 1;
        while (DB::table('projects')->where('key', $key)->exists()) {
            $key = $originalKey . $counter;
            $counter++;
        }

        return $key;
    }
}
