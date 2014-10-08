{if $fileComment}
{$fileComment}

{/if}
{if $namespace}
{$namespace}

{/if}
{if $classComment}
{$classComment}
{/if}
class {$className}{if $interface} implements {$interface}{/if}{literal} {{/literal}
{if $magicCall}

{$magicCall|indent}
{/if}
{if $methods}

{$methods|indent}
{/if}

{literal}}{/literal}