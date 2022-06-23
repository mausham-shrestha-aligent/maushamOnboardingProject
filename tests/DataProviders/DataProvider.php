<?php
namespace Tests\DataProviders;
class DataProvider {
    public function routeNotFoundCases(): array {
        return [
            ['/users','put'],
            ['/invoices','post']
        ];
    }
}
