<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

/*
 * Foreign Key
 */

Blueprint::macro('addForeign', function ($table, $options = []) {
    $fk = (isset($options['fk']) && !empty($options['fk'])) ?
        $options['fk'] : strtolower(Str::singular($table)) . '_id';

    $reference = (isset($options['reference']) && !empty($options['reference'])) ?
        $options['reference'] : 'id';

    if (isset($options['bigInteger']) && false == $options['bigInteger']) {
        $schema = $this->unsignedInteger($fk)->index();
    } else {
        $schema = $this->unsignedBigInteger($fk)->index();
    }

    if (isset($options['nullable']) && true == $options['nullable']) {
        $schema->nullable();
    }

    if (!isset($options['no_reference'])) {
        $this->referenceOn($fk, $table, $reference);
    }

    if (isset($options['delete'])) {
        $schema->onDelete($options['delete']);
    }

    if (isset($options['update'])) {
        $schema->onUpdate($options['update']);
    }

    return $schema;
});

Blueprint::macro('addNullableForeign', function ($table, $fk, $bigInteger = true) {
    return $this->addForeign($table, ['nullable' => true, 'fk' => $fk, 'bigInteger' => $bigInteger])->comment('Nullable FK for ' . $table);
});

Blueprint::macro('referenceOn', function ($key, $table, $reference = 'id') {
    return $this->foreign($key)
        ->references($reference)
        ->on($table);
});

Blueprint::macro('belongsTo', function ($table, $key = null, $bigInteger = true, $reference = 'id') {
    if (is_null($key)) {
        $key = strtolower(Str::singular($table)) . '_id';
    }

    return $this->addForeign($table, ['fk' => $key, 'reference' => $reference, 'bigInteger' => $bigInteger])->comment('FK for ' . $table);
});

Blueprint::macro('nullableBelongsTo', function ($table, $key = null, $bigInteger = true, $reference = 'id') {
    if (is_null($key)) {
        $key = strtolower(Str::singular($table)) . '_id';
    }

    return $this->addNullableForeign($table, $key, $bigInteger);
});
