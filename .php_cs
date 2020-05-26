<?php
$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests/src']);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => true,
        'blank_line_before_return' => true,
        'cast_spaces' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_superfluous_phpdoc_tags' => false,
        'not_operator_with_successor_space' => true,
        'ordered_imports' => true,
        'phpdoc_align' => true,
        'phpdoc_indent' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_no_package' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_summary' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'single_blank_line_at_eof' => true,
        'ternary_operator_spaces' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder);
