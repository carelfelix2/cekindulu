<?php

$models = ['Product', 'ProductImage', 'ProductPrice', 'AffiliateLink', 'Article'];

foreach ($models as $model) {
    $file = __DIR__ . '/app/Models/' . $model . '.php';
    $content = file_get_contents($file);

    if (strpos($content, 'HasFactory') === false) {
        // Add the use statement
        $content = str_replace(
            'use Illuminate\Database\Eloquent\Model;',
            "use Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Database\Eloquent\Model;",
            $content
        );

        // Add the trait
        $content = preg_replace(
            '/(class\s+\w+\s+extends\s+Model\s*\{)/',
            "$1\n    use HasFactory;\n",
            $content
        );

        file_put_contents($file, $content);
        echo "$model updated\n";
    } else {
        echo "$model already has HasFactory\n";
    }
}

echo "Done!\n";
