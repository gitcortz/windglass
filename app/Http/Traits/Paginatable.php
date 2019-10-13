<?php

namespace App\Http\Traits;

trait Paginatable {

    private $pageSizeLimit = 100;
    private $defaultPageSize = 10;

    public function getPerPage() {
        $pageSize = request("page_size", $this->defaultPageSize);

        return min($pageSize, $this->pageSizeLimit);
    }
    
}
