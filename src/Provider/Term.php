<?php
namespace Trendwerk\Faker\Provider;

use Faker\Provider\Base;

final class Term
{
    public function terms($taxonomy, $amount = 1)
    {
        $termIds = array_map('absint', get_terms($taxonomy, [
            'fields'     => 'ids',
            'hide_empty' => false,
        ]));

        return Base::randomElements($termIds, $amount);
    }
}
